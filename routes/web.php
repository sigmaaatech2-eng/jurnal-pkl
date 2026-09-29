<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherJournalController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\SchoolAdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HeadmasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminPlatformController;
use App\Http\Controllers\SchoolDataController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/

// Menampilkan halaman register
Route::get('/register', function () {
    $majors  = \App\Models\SchoolMajor::active()->orderBy('name')->get();
    $classes = \App\Models\SchoolClass::active()->with('major')->orderBy('name')->get();
    return view('auth.register', compact('majors', 'classes'));
})->middleware('guest')->name('register');


// Memproses register
Route::post('/register', function (Request $request) {

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'jurusan' => ['required'],
        'kelas' => ['required', 'string', 'max:100'],
        'password' => ['required', 'confirmed', 'min:8'],
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar di sistem.',
        'jurusan.required' => 'Silakan pilih jurusan Anda.',
        'kelas.required' => 'Silakan pilih kelas Anda.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal terdiri dari 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    // Jika jurusan dikirim sebagai ID major, ambil namanya
    $jurusanValue = $validated['jurusan'];
    if (is_numeric($validated['jurusan'])) {
        $majorModel = \App\Models\SchoolMajor::find($validated['jurusan']);
        if ($majorModel) {
            $jurusanValue = $majorModel->name;
        }
    }

    $schoolClass = \App\Models\SchoolClass::where('name', $validated['kelas'])->first();

    $user = User::create([
        'name'            => $validated['name'],
        'email'           => $validated['email'],
        'jurusan'         => $jurusanValue,
        'kelas'           => $validated['kelas'],
        'school_class_id' => $schoolClass?->id,
        'password'        => Hash::make($validated['password']),
    ]);

    /*
     * Register publik hanya untuk siswa.
     * Role lain dibuat oleh admin sekolah.
     */
    $user->assignRole('siswa');

    Auth::login($user);

    return redirect()
        ->route('dashboard')
        ->with('success', 'Akun siswa berhasil didaftarkan. Selamat datang di Jurnal PKL Online.');

})->middleware('guest')->name('register.store');


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');


Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ], [
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {

        $request->session()->regenerate();

        return redirect()->intended(
            route('dashboard')
        );
    }

    return back()
        ->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])
        ->onlyInput('email');

})->middleware('guest')->name('login.attempt');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()
        ->route('login');

})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| PROFILE & AKUN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
});


/*
|--------------------------------------------------------------------------
| MAIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN PLATFORM
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin_platform'])
    ->prefix('admin-platform')
    ->name('admin-platform.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminPlatformController::class, 'dashboard'])
            ->name('dashboard');

        // Subscriber Sekolah
        Route::get('/schools', [AdminPlatformController::class, 'schools'])
            ->name('schools.index');
        Route::get('/schools/{school}', [AdminPlatformController::class, 'schoolDetail'])
            ->name('schools.show');

        // Kelola Paket
        Route::get('/packages', [AdminPlatformController::class, 'packages'])
            ->name('packages.index');
        Route::get('/packages/create', [AdminPlatformController::class, 'createPackage'])
            ->name('packages.create');
        Route::post('/packages', [AdminPlatformController::class, 'storePackage'])
            ->name('packages.store');
        Route::get('/packages/{package}/edit', [AdminPlatformController::class, 'editPackage'])
            ->name('packages.edit');
        Route::put('/packages/{package}', [AdminPlatformController::class, 'updatePackage'])
            ->name('packages.update');
        Route::post('/packages/{package}/toggle', [AdminPlatformController::class, 'togglePackage'])
            ->name('packages.toggle');

        // Persetujuan Langganan
        Route::get('/approvals', [AdminPlatformController::class, 'approvals'])
            ->name('approvals.index');
        Route::get('/approvals/{subscription}', [AdminPlatformController::class, 'approvalDetail'])
            ->name('approvals.show');
        Route::post('/approvals/{subscription}/approve', [AdminPlatformController::class, 'approveSubscription'])
            ->name('approvals.approve');
        Route::post('/approvals/{subscription}/reject', [AdminPlatformController::class, 'rejectSubscription'])
            ->name('approvals.reject');

        // Riwayat Pembayaran
        Route::get('/payments', [AdminPlatformController::class, 'payments'])
            ->name('payments.index');

        // Kelola User
        Route::get('/users', [AdminPlatformController::class, 'users'])
            ->name('users.index');
        Route::get('/users/{user}', [AdminPlatformController::class, 'userDetail'])
            ->name('users.show');
        Route::post('/users/{user}/role', [AdminPlatformController::class, 'updateUserRole'])
            ->name('users.role');
        Route::post('/users/{user}/toggle', [AdminPlatformController::class, 'toggleUserStatus'])
            ->name('users.toggle');
        Route::delete('/users/{user}', [AdminPlatformController::class, 'deleteUser'])
            ->name('users.destroy');

        // Kelola Role & Permission
        Route::get('/roles', [AdminPlatformController::class, 'roles'])
            ->name('roles.index');
        Route::get('/roles/{role}', [AdminPlatformController::class, 'roleDetail'])
            ->name('roles.show');
        Route::post('/roles/{role}/permissions', [AdminPlatformController::class, 'updateRolePermissions'])
            ->name('roles.permissions');

        // Log Aktivitas
        Route::get('/logs', [AdminPlatformController::class, 'activityLogs'])
            ->name('logs.index');

        // Laporan
        Route::get('/reports', [AdminPlatformController::class, 'reports'])
            ->name('reports.index');
    });


/*
|--------------------------------------------------------------------------
| ADMIN SEKOLAH
|--------------------------------------------------------------------------
*/
Route::get(
    '/admin-sekolah/dashboard',
    [SchoolAdminDashboardController::class, 'index']
)->middleware([
    'auth',
    'role:admin_sekolah'
])->name('admin-sekolah.dashboard');

Route::middleware(['auth', 'role:admin_sekolah'])
    ->prefix('admin-sekolah')
    ->name('admin-sekolah.')
    ->group(function () {

        // Data Siswa
        Route::get('/students', [StudentController::class, 'index'])
            ->name('students.index');

        Route::get('/students/create', [StudentController::class, 'create'])
            ->name('students.create');

        Route::post('/students', [StudentController::class, 'store'])
            ->name('students.store');

        Route::get('/students/{student}', [StudentController::class, 'show'])
            ->name('students.show');


        // Manajemen User
        Route::get('/users', [UserManagementController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [UserManagementController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserManagementController::class, 'store'])
            ->name('users.store');

        Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])
            ->name('users.reset-password');


        // Data PKL
        Route::get('/internships', [InternshipController::class, 'index'])
            ->name('internships.index');

        Route::get('/internships/create', [InternshipController::class, 'create'])
            ->name('internships.create');

        Route::post('/internships', [InternshipController::class, 'store'])
            ->name('internships.store');

        // Data Sekolah — Jurusan
        Route::prefix('school-data')->name('school-data.')->group(function () {

            // Jurusan
            Route::get('/majors', [SchoolDataController::class, 'majorsIndex'])->name('majors.index');
            Route::get('/majors/create', [SchoolDataController::class, 'majorsCreate'])->name('majors.create');
            Route::post('/majors', [SchoolDataController::class, 'majorsStore'])->name('majors.store');
            Route::get('/majors/{major}/edit', [SchoolDataController::class, 'majorsEdit'])->name('majors.edit');
            Route::put('/majors/{major}', [SchoolDataController::class, 'majorsUpdate'])->name('majors.update');
            Route::delete('/majors/{major}', [SchoolDataController::class, 'majorsDestroy'])->name('majors.destroy');

            // Kelas
            Route::get('/classes', [SchoolDataController::class, 'classesIndex'])->name('classes.index');
            Route::get('/classes/create', [SchoolDataController::class, 'classesCreate'])->name('classes.create');
            Route::post('/classes', [SchoolDataController::class, 'classesStore'])->name('classes.store');
            Route::get('/classes/{class}/edit', [SchoolDataController::class, 'classesEdit'])->name('classes.edit');
            Route::put('/classes/{class}', [SchoolDataController::class, 'classesUpdate'])->name('classes.update');
            Route::delete('/classes/{class}', [SchoolDataController::class, 'classesDestroy'])->name('classes.destroy');

            // API — dropdown dinamis
            Route::get('/majors/{major}/classes', [SchoolDataController::class, 'classesByMajor'])->name('majors.classes');
        });
    });


/*
|--------------------------------------------------------------------------
| KEPALA SEKOLAH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:kepala_sekolah'])
    ->prefix('kepala-sekolah')
    ->name('kepala-sekolah.')
    ->group(function () {

        Route::get('/dashboard', [HeadmasterController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/students', [HeadmasterController::class, 'students'])
            ->name('students.index');

        Route::get('/students/{internship}', [HeadmasterController::class, 'studentDetail'])
            ->name('students.show');

        Route::get('/journals', [HeadmasterController::class, 'journals'])
            ->name('journals.index');

        Route::get('/attendances', [HeadmasterController::class, 'attendances'])
            ->name('attendances.index');

        Route::get('/recap', [HeadmasterController::class, 'recap'])
            ->name('recap.index');
    });


/*
|--------------------------------------------------------------------------
| GURU PEMBIMBING
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:guru_pembimbing'
])->prefix('guru-pembimbing')
    ->name('guru-pembimbing.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [TeacherDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | MONITORING JURNAL
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/journals',
            [TeacherJournalController::class, 'index']
        )->name('journals.index');


        Route::get(
            '/journals/{journal}',
            [TeacherJournalController::class, 'show']
        )->name('journals.show');


        /*
        |--------------------------------------------------------------------------
        | MONITORING SISWA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/students',
            [TeacherJournalController::class, 'students']
        )->name('students.index');

        Route::get(
            '/students/create',
            [TeacherJournalController::class, 'createStudent']
        )->name('students.create');

        Route::post(
            '/students',
            [TeacherJournalController::class, 'storeStudent']
        )->name('students.store');

        Route::get(
            '/students/{internship}',
            [TeacherJournalController::class, 'studentDetail']
        )->name('students.show');


        /*
        |--------------------------------------------------------------------------
        | MONITORING ABSENSI & REKAP
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/attendances',
            [TeacherJournalController::class, 'attendances']
        )->name('attendances.index');

        Route::get(
            '/recap',
            [TeacherJournalController::class, 'recap']
        )->name('recap.index');

        Route::match(['get', 'post'], '/recap/export', [TeacherJournalController::class, 'exportRecap'])
            ->name('recap.export');

    });


/*
|--------------------------------------------------------------------------
| MENTOR
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:mentor'
])->prefix('mentor')
    ->name('mentor.')
    ->group(function () {

        Route::get('/dashboard', [MentorController::class, 'dashboard'])->name('dashboard');

        Route::get('/students', [MentorController::class, 'students'])->name('students.index');

        Route::get('/students/{internship}', [MentorController::class, 'studentJournals'])->name('students.show');

        Route::get('/journals/{journal}', [MentorController::class, 'journalDetail'])->name('journals.show');

        Route::post('/journals/{journal}/validate', [MentorController::class, 'validateJournal'])->name('journals.validate');

        Route::post('/journals/{journal}/revision', [MentorController::class, 'requestRevision'])->name('journals.revision');
        Route::post('/attendance-deadline', [MentorController::class, 'updateAttendanceDeadline'])->name('attendance-deadline.update');

    });



/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:siswa'
])->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [StudentDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | JOURNALS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/journals',
            function () {

                /** @var User $user */
                $user = Auth::user();

                $journals = $user
                    ->journals()
                    ->latest('date')
                    ->get();

                return view(
                    'siswa.journals.index',
                    compact('journals')
                );

            }
        )->name('journals.index');


        Route::get(
            '/journals/create',
            [JournalController::class, 'create']
        )->name('journals.create');


        Route::post(
            '/journals',
            [JournalController::class, 'store']
        )->name('journals.store');


        Route::get(
            '/journals/{journal}/edit',
            [JournalController::class, 'edit']
        )->name('journals.edit');


        Route::put(
            '/journals/{journal}',
            [JournalController::class, 'update']
        )->name('journals.update');


        Route::delete(
            '/journals/{journal}',
            [JournalController::class, 'destroy']
        )->name('journals.destroy');


        Route::get(
            '/journals/{journal}',
            [JournalController::class, 'show']
        )->name('journals.show');


        /*
        |--------------------------------------------------------------------------
        | ATTENDANCES
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/attendances',
            [AttendanceController::class, 'index']
        )->name('attendances.index');


        Route::post(
            '/attendances/check-in',
            [AttendanceController::class, 'checkIn']
        )->name('attendances.check-in');


        Route::post(
            '/attendances/check-out',
            [AttendanceController::class, 'checkOut']
        )->name('attendances.check-out');

    });

Route::middleware('auth')->group(function () {

    Route::get(
        '/notifications/{notification}',
        [NotificationController::class, 'read']
    )->name('notifications.read');

});