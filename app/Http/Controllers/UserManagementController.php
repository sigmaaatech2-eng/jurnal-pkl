<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolMajor;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Menampilkan semua pengguna yang dikelola Admin Sekolah.
     */
    public function index(Request $request)
    {
        $allowedRoles = [
            'siswa',
            'guru_pembimbing',
            'mentor',
            'kepala_sekolah',
            'admin_sekolah',
        ];

        $query = User::whereHas('roles', function ($query) use ($allowedRoles) {
            $query->whereIn('name', $allowedRoles);
        })->with('roles');

        // Filter berdasarkan peran
        if ($request->filled('role') && $request->role !== 'all' && in_array($request->role, $allowedRoles)) {
            $query->role($request->role);
        }

        // Pencarian nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        // Hitung total per role untuk ringkasan di dashboard
        $counts = [
            'all'             => User::whereHas('roles', fn($q) => $q->whereIn('name', $allowedRoles))->count(),
            'siswa'           => User::role('siswa')->count(),
            'guru_pembimbing' => User::role('guru_pembimbing')->count(),
            'mentor'          => User::role('mentor')->count(),
            'kepala_sekolah'  => User::role('kepala_sekolah')->count(),
        ];

        return view('admin-sekolah.users.index', compact('users', 'counts'));
    }


    /**
     * Form tambah pengguna.
     */
    public function create()
    {
        $majors  = SchoolMajor::active()->orderBy('name')->get();
        $classes = SchoolClass::active()->with('major')->orderBy('name')->get();
        return view('admin-sekolah.users.create', compact('majors', 'classes'));
    }


    /**
     * Simpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'role' => [
                'required',
                'in:siswa,guru_pembimbing,mentor,kepala_sekolah',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'kelas'   => ['nullable', 'string', 'max:100'],
            'jurusan' => ['nullable'],  // bisa berupa ID (dari dropdown) atau string teks bebas
        ], [
            'name.required'     => 'Nama lengkap pengguna wajib diisi.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Alamat email ini sudah terdaftar di sistem.',
            'role.required'     => 'Pilih salah satu peran pengguna.',
            'role.in'           => 'Peran yang dipilih tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed'=> 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Jika jurusan dikirim sebagai ID (dari dropdown data sekolah), ambil namanya
        $jurusanValue = null;
        if (!empty($validated['jurusan'])) {
            $majorModel = \App\Models\SchoolMajor::find($validated['jurusan']);
            $jurusanValue = $majorModel ? $majorModel->name : $validated['jurusan'];
        }

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'kelas'    => $validated['kelas'] ?? null,
            'jurusan'  => $jurusanValue,
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('admin-sekolah.users.index')
            ->with('success', "Akun pengguna {$user->name} dengan peran " . str_replace('_', ' ', $validated['role']) . " berhasil dibuat.");
    }


    /**
     * Reset password pengguna oleh Admin Sekolah.
     * Admin Sekolah tidak dapat mereset password Admin Platform.
     */
    public function resetPassword(Request $request, User $user)
    {
        // Cegah admin sekolah mereset password admin_platform
        if ($user->hasRole('admin_platform')) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah password Admin Platform.');
        }

        $validated = $request->validate([
            'new_password' => [
                'required',
                'string',
                Password::min(8),
                'confirmed',
            ],
        ], [
            'new_password.required'  => 'Password baru wajib diisi.',
            'new_password.min'       => 'Password baru minimal terdiri dari 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()
            ->route('admin-sekolah.users.index')
            ->with('success', "Password pengguna {$user->name} berhasil diubah.");
    }
}