<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use App\Models\SchoolMajor;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar seluruh siswa beserta status penempatan PKL.
     */
    public function index(Request $request)
    {
        $query = User::role('siswa')
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['guru_pembimbing', 'mentor', 'admin_sekolah', 'kepala_sekolah']);
            })
            ->with([
                'studentInternships' => function ($q) {
                    $q->latest();
                },
                'studentInternships.teacher',
                'studentInternships.mentor',
            ]);

        // Filter pencarian nama atau email siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter status PKL
        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'active') {
                $query->whereHas('studentInternships', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($request->status === 'completed') {
                $query->whereHas('studentInternships', function ($q) {
                    $q->where('status', 'completed');
                });
            } elseif ($request->status === 'unassigned') {
                $query->whereDoesntHave('studentInternships', function ($q) {
                    $q->whereIn('status', ['active', 'completed']);
                });
            }
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        $pureStudentQuery = User::role('siswa')->whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['guru_pembimbing', 'mentor', 'admin_sekolah', 'kepala_sekolah']);
        });

        // Counter untuk badge tab filter
        $totalCount      = (clone $pureStudentQuery)->count();
        $activeCount     = Internship::where('status', 'active')->whereHas('student', function ($q) {
            $q->role('siswa')->whereDoesntHave('roles', function ($sq) {
                $sq->whereIn('name', ['guru_pembimbing', 'mentor', 'admin_sekolah', 'kepala_sekolah']);
            });
        })->distinct('student_id')->count('student_id');
        $completedCount  = Internship::where('status', 'completed')->whereHas('student', function ($q) {
            $q->role('siswa')->whereDoesntHave('roles', function ($sq) {
                $sq->whereIn('name', ['guru_pembimbing', 'mentor', 'admin_sekolah', 'kepala_sekolah']);
            });
        })->distinct('student_id')->count('student_id');
        $unassignedCount = (clone $pureStudentQuery)->whereDoesntHave('studentInternships', function ($q) {
            $q->whereIn('status', ['active', 'completed']);
        })->count();

        return view('admin-sekolah.students.index', compact(
            'students',
            'totalCount',
            'activeCount',
            'completedCount',
            'unassignedCount'
        ));
    }

    /**
     * Menampilkan form pendaftaran akun siswa baru.
     */
    public function create()
    {
        $majors  = SchoolMajor::active()->orderBy('name')->get();
        $classes = SchoolClass::active()->with('major')->orderBy('name')->get();
        return view('admin-sekolah.students.create', compact('majors', 'classes'));
    }

    /**
     * Menyimpan data pendaftaran akun siswa baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'jurusan'  => ['nullable'],
            'kelas'    => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $jurusanValue = $validated['jurusan'] ?? null;
        if (!empty($jurusanValue) && is_numeric($jurusanValue)) {
            $majorModel = SchoolMajor::find($jurusanValue);
            if ($majorModel) {
                $jurusanValue = $majorModel->name;
            }
        }

        $student = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'jurusan'  => $jurusanValue,
            'kelas'    => $validated['kelas'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        $student->assignRole('siswa');

        return redirect()
            ->route('admin-sekolah.students.index')
            ->with('success', 'Akun siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan profil lengkap siswa, riwayat penempatan PKL, jurnal, dan absensi.
     */
    public function show(User $student)
    {
        // Pastikan pengguna bertindak sebagai siswa
        if (!$student->hasRole('siswa')) {
            abort(404, 'Data siswa tidak ditemukan.');
        }

        $student->load([
            'studentInternships' => function ($q) {
                $q->latest();
            },
            'studentInternships.teacher',
            'studentInternships.mentor',
            'studentInternships.journals',
            'studentInternships.attendances',
        ]);

        // Ambil penempatan aktif saat ini, atau penempatan paling terakhir
        $activeInternship = $student->studentInternships->where('status', 'active')->first();
        $currentInternship = $activeInternship ?? $student->studentInternships->first();

        // Ringkasan Jurnal
        $journals         = $currentInternship ? $currentInternship->journals()->latest('date')->take(8)->get() : collect();
        $totalJournals    = $currentInternship ? $currentInternship->journals()->count() : 0;
        $approvedJournals = $currentInternship ? $currentInternship->journals()->where('status', 'approved')->count() : 0;
        $pendingJournals  = $currentInternship ? $currentInternship->journals()->where('status', 'pending')->count() : 0;
        $rejectedJournals = $currentInternship ? $currentInternship->journals()->where('status', 'rejected')->count() : 0;

        // Ringkasan Absensi
        $attendances      = $currentInternship ? $currentInternship->attendances()->latest('date')->take(8)->get() : collect();
        $totalAttendances = $currentInternship ? $currentInternship->attendances()->count() : 0;
        $presentCount     = $currentInternship ? $currentInternship->attendances()->where('status', 'present')->count() : 0;
        $lateCount        = $currentInternship ? $currentInternship->attendances()->where('status', 'late')->count() : 0;

        return view('admin-sekolah.students.show', compact(
            'student',
            'currentInternship',
            'activeInternship',
            'journals',
            'totalJournals',
            'approvedJournals',
            'pendingJournals',
            'rejectedJournals',
            'attendances',
            'totalAttendances',
            'presentCount',
            'lateCount'
        ));
    }
}