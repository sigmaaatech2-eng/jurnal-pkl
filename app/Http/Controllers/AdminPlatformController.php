<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Internship;
use App\Models\PaymentHistory;
use App\Models\SchoolSubscription;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminPlatformController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        // Sekolah berdasarkan subscription
        $totalSchools = SchoolSubscription::count();
        $activeSchools = SchoolSubscription::where('status', 'active')->count();
        $pendingSchools = SchoolSubscription::where('status', 'pending')->count();

        // User stats
        $totalUsers = User::count();
        $totalStudents = User::role('siswa')->count();
        $totalTeachers = User::role('guru_pembimbing')->count();
        $totalMentors = User::role('mentor')->count();

        // Langganan terbaru
        $recentSubscriptions = SchoolSubscription::with('package')
            ->latest()
            ->take(5)
            ->get();

        // Log aktivitas terbaru
        $recentLogs = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Statistik per bulan (12 bulan terakhir) untuk chart
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyStats[] = [
                'label' => $month->format('M Y'),
                'users' => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'subscriptions' => SchoolSubscription::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }

        return view('admin-platform.dashboard', compact(
            'totalSchools',
            'activeSchools',
            'pendingSchools',
            'totalUsers',
            'totalStudents',
            'totalTeachers',
            'totalMentors',
            'recentSubscriptions',
            'recentLogs',
            'monthlyStats'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SUBSCRIBER SEKOLAH
    |--------------------------------------------------------------------------
    */

    public function schools(Request $request)
    {
        $query = SchoolSubscription::with(['package', 'adminUser', 'approvedBy']);

        if ($request->filled('search')) {
            $query->where('school_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schools = $query->latest()->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => SchoolSubscription::count(),
            'active' => SchoolSubscription::where('status', 'active')->count(),
            'pending' => SchoolSubscription::where('status', 'pending')->count(),
            'rejected' => SchoolSubscription::where('status', 'rejected')->count(),
            'expired' => SchoolSubscription::where('status', 'expired')->count(),
        ];

        return view('admin-platform.schools.index', compact('schools', 'statusCounts'));
    }

    public function schoolDetail(SchoolSubscription $school)
    {
        $school->load(['package', 'adminUser', 'approvedBy', 'payments.confirmedBy']);
        return view('admin-platform.schools.show', compact('school'));
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA PAKET
    |--------------------------------------------------------------------------
    */

    public function packages()
    {
        $packages = SubscriptionPackage::withCount('subscriptions')->latest()->get();

        $packageCounts = [
            'total' => SubscriptionPackage::count(),
            'active' => SubscriptionPackage::where('is_active', true)->count(),
            'inactive' => SubscriptionPackage::where('is_active', false)->count(),
            'total_subscribers' => SchoolSubscription::count(),
        ];

        return view('admin-platform.packages.index', compact('packages', 'packageCounts'));
    }

    public function createPackage()
    {
        return view('admin-platform.packages.create');
    }

    public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'max_students' => 'required|integer|min:1',
            'max_teachers' => 'required|integer|min:1',
            'max_mentors' => 'required|integer|min:1',
            'duration_months' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'string',
        ]);

        // Filter features yang kosong
        if (!empty($validated['features'])) {
            $validated['features'] = array_filter($validated['features']);
        }

        $package = SubscriptionPackage::create($validated);

        ActivityLog::log('create_package', "Paket \"{$package->name}\" berhasil dibuat.", $package);

        return redirect()->route('admin-platform.packages.index')
            ->with('success', "Paket \"{$package->name}\" berhasil dibuat.");
    }

    public function editPackage(SubscriptionPackage $package)
    {
        return view('admin-platform.packages.edit', compact('package'));
    }

    public function updatePackage(Request $request, SubscriptionPackage $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'max_students' => 'required|integer|min:1',
            'max_teachers' => 'required|integer|min=1',
            'max_mentors' => 'required|integer|min:1',
            'duration_months' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'string',
        ]);

        if (!empty($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features']));
        }

        $package->update($validated);

        ActivityLog::log('update_package', "Paket \"{$package->name}\" diperbarui.", $package);

        return redirect()->route('admin-platform.packages.index')
            ->with('success', "Paket berhasil diperbarui.");
    }

    public function togglePackage(SubscriptionPackage $package)
    {
        $package->update(['is_active' => !$package->is_active]);
        $status = $package->is_active ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::log('toggle_package', "Paket \"{$package->name}\" {$status}.", $package);

        return back()->with('success', "Paket berhasil {$status}.");
    }

    /*
    |--------------------------------------------------------------------------
    | PERSETUJUAN LANGGANAN
    |--------------------------------------------------------------------------
    */

    public function approvals(Request $request)
    {
        $query = SchoolSubscription::with(['package', 'adminUser'])
            ->where('status', 'pending');

        if ($request->filled('search')) {
            $query->where('school_name', 'like', '%' . $request->search . '%');
        }

        $pendingSubscriptions = $query->latest()->paginate(15)->withQueryString();

        $approvalCounts = [
            'pending' => SchoolSubscription::where('status', 'pending')->count(),
            'approved' => SchoolSubscription::where('status', 'active')->count(),
            'rejected' => SchoolSubscription::where('status', 'rejected')->count(),
        ];

        return view('admin-platform.approvals.index', compact('pendingSubscriptions', 'approvalCounts'));
    }

    public function approvalDetail(SchoolSubscription $subscription)
    {
        $subscription->load(['package', 'adminUser']);
        $packages = SubscriptionPackage::where('is_active', true)->get();
        return view('admin-platform.approvals.show', compact('subscription', 'packages'));
    }

    public function approveSubscription(Request $request, SchoolSubscription $subscription)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:subscription_packages,id',
            'start_date' => 'required|date',
        ]);

        $package = SubscriptionPackage::findOrFail($validated['package_id']);
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addMonths($package->duration_months);

        $subscription->update([
            'status' => 'active',
            'package_id' => $package->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        ActivityLog::log('approve_subscription', "Langganan sekolah \"{$subscription->school_name}\" disetujui.", $subscription);

        return redirect()->route('admin-platform.approvals.index')
            ->with('success', "Langganan \"{$subscription->school_name}\" berhasil disetujui.");
    }

    public function rejectSubscription(Request $request, SchoolSubscription $subscription)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $subscription->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        ActivityLog::log('reject_subscription', "Langganan sekolah \"{$subscription->school_name}\" ditolak.", $subscription);

        return redirect()->route('admin-platform.approvals.index')
            ->with('success', "Langganan \"{$subscription->school_name}\" telah ditolak.");
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function payments(Request $request)
    {
        $query = PaymentHistory::with(['subscription', 'confirmedBy']);

        if ($request->filled('search')) {
            $query->whereHas('subscription', function ($q) use ($request) {
                $q->where('school_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        $paymentCounts = [
            'all' => PaymentHistory::count(),
            'paid' => PaymentHistory::where('status', 'paid')->count(),
            'pending' => PaymentHistory::where('status', 'pending')->count(),
            'failed' => PaymentHistory::where('status', 'failed')->count(),
            'total_amount' => PaymentHistory::where('status', 'paid')->sum('amount'),
        ];

        return view('admin-platform.payments.index', compact('payments', 'paymentCounts'));
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA USER
    |--------------------------------------------------------------------------
    */

    public function users(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(20)->withQueryString();
        $roles = Role::orderBy('name')->get();
        $totalCount = User::count();
        $totalByRole = [];
        foreach ($roles as $role) {
            $totalByRole[$role->name] = User::role($role->name)->count();
        }

        return view('admin-platform.users.index', compact('users', 'roles', 'totalByRole', 'totalCount'));
    }

    public function userDetail(User $user)
    {
        $user->load('roles');
        $roles = Role::orderBy('name')->get();
        $recentLogs = ActivityLog::where('user_id', $user->id)->latest()->take(20)->get();
        return view('admin-platform.users.show', compact('user', 'roles', 'recentLogs'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        // Cegah ubah role admin platform sendiri
        if ($user->id === auth()->id()) {
            return back()->withErrors(['role' => 'Anda tidak dapat mengubah role Anda sendiri.']);
        }

        $oldRole = $user->getRoleNames()->first() ?? '-';
        $user->syncRoles([$validated['role']]);

        ActivityLog::log('update_user_role', "Role user \"{$user->name}\" diubah dari \"{$oldRole}\" ke \"{$validated['role']}\".", $user);

        return back()->with('success', "Role user berhasil diperbarui.");
    }

    public function toggleUserStatus(User $user)
    {
        // Cegah nonaktifkan diri sendiri
        if ($user->id === auth()->id()) {
            return back()->withErrors(['status' => 'Anda tidak dapat mengubah status akun Anda sendiri.']);
        }

        // Gunakan email_verified_at sebagai proxy untuk status aktif/nonaktif
        // (Karena tabel users tidak memiliki kolom is_active)
        // Alternatif: gunakan kolom terpisah - tapi kita tidak ingin buat migrasi baru
        // Strategi: toggle banned via password reset ke random (non-functional approach)
        // Lebih baik: tambahkan banned_at column
        // Untuk sekarang, hapus semua session user tsb via database
        \DB::table('sessions')->where('user_id', $user->id)->delete();

        ActivityLog::log('toggle_user_status', "Sesi user \"{$user->name}\" dihapus (logout paksa).", $user);

        return back()->with('success', "User \"{$user->name}\" berhasil di-logout dari semua perangkat.");
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['delete' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::log('delete_user', "User \"{$userName}\" dihapus dari sistem.");

        return redirect()->route('admin-platform.users.index')
            ->with('success', "User \"{$userName}\" berhasil dihapus.");
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA ROLE & PERMISSION
    |--------------------------------------------------------------------------
    */

    public function roles()
    {
        $roles = Role::withCount('permissions')->get();
        $allPermissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();

        // Group permissions by category
        $permissionGroups = $allPermissions->groupBy(function ($p) {
            $parts = explode('-', $p->name, 2);
            return count($parts) > 1 ? $parts[0] : 'other';
        });

        return view('admin-platform.roles.index', compact('roles', 'allPermissions', 'permissionGroups'));
    }

    public function roleDetail(Role $role)
    {
        $role->load('permissions');
        $allPermissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();
        $users = User::role($role->name)->take(10)->get();
        $userCount = User::role($role->name)->count();

        return view('admin-platform.roles.show', compact('role', 'allPermissions', 'users', 'userCount'));
    }

    public function updateRolePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $permissions = $validated['permissions'] ?? [];
        $role->syncPermissions($permissions);

        ActivityLog::log('update_role_permissions', "Permission untuk role \"{$role->name}\" diperbarui.", $role);

        return back()->with('success', "Permission role \"{$role->name}\" berhasil diperbarui.");
    }

    /*
    |--------------------------------------------------------------------------
    | LOG AKTIVITAS
    |--------------------------------------------------------------------------
    */

    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->latest()->paginate(30)->withQueryString();
        $actions = ActivityLog::select('action')->distinct()->pluck('action');
        $adminUsers = User::role('admin_platform')->get();

        return view('admin-platform.logs.index', compact('logs', 'actions', 'adminUsers'));
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    public function reports(Request $request)
    {
        // Statistik overview platform
        $stats = [
            'total_schools' => SchoolSubscription::count(),
            'active_schools' => SchoolSubscription::where('status', 'active')->count(),
            'total_users' => User::count(),
            'total_students' => User::role('siswa')->count(),
            'total_teachers' => User::role('guru_pembimbing')->count(),
            'total_mentors' => User::role('mentor')->count(),
            'total_internships' => Internship::count(),
            'active_internships' => Internship::where('status', 'active')->count(),
            'total_revenue' => PaymentHistory::where('status', 'paid')->sum('amount'),
        ];

        // Growth per bulan (12 bulan)
        $userGrowth = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $userGrowth[] = [
                'label' => $month->format('M Y'),
                'count' => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }

        // Distribusi role
        $roleDistribution = Role::withCount('users')->get();

        return view('admin-platform.reports.index', compact('stats', 'userGrowth', 'roleDistribution'));
    }
}
