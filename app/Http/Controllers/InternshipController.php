<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    /**
     * Menampilkan daftar penempatan PKL siswa.
     */
    public function index(Request $request)
    {
        // Pastikan hanya menampilkan penempatan untuk akun yang benar-benar siswa
        $query = Internship::whereHas('student', function ($q) {
            $q->role('siswa');
        })->with([
            'student',
            'teacher',
            'mentor',
        ]);

        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search siswa atau tempat PKL
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $internships = $query->latest()->paginate(15)->withQueryString();

        $baseCountQuery = Internship::whereHas('student', function ($q) {
            $q->role('siswa');
        });
        $totalCount     = (clone $baseCountQuery)->count();
        $activeCount    = (clone $baseCountQuery)->where('status', 'active')->count();
        $completedCount = (clone $baseCountQuery)->where('status', 'completed')->count();
        $cancelledCount = (clone $baseCountQuery)->where('status', 'cancelled')->count();

        return view('admin-sekolah.internships.index', compact(
            'internships',
            'totalCount',
            'activeCount',
            'completedCount',
            'cancelledCount'
        ));
    }

    /**
     * Menampilkan form tambah penempatan PKL.
     */
    public function create(Request $request)
    {
        // Hanya user dengan role masing-masing
        $students = User::role('siswa')
            ->orderBy('name')
            ->get();

        $teachers = User::role('guru_pembimbing')
            ->orderBy('name')
            ->get();

        $mentors = User::role('mentor')
            ->orderBy('name')
            ->get();

        $selectedStudentId = $request->query('student_id');

        return view('admin-sekolah.internships.create', compact(
            'students',
            'teachers',
            'mentors',
            'selectedStudentId'
        ));
    }

    /**
     * Menyimpan data penempatan PKL baru dengan validasi ketat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'      => ['required', 'exists:users,id'],
            'teacher_id'      => ['required', 'exists:users,id'],
            'mentor_id'       => ['required', 'exists:users,id'],
            'company_name'    => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string'],
            'start_date'      => ['required', 'date'],
            'end_date'        => ['required', 'date', 'after_or_equal:start_date'],
            'status'          => ['required', 'in:active,completed,cancelled'],
        ], [
            'student_id.required'      => 'Siswa wajib dipilih.',
            'student_id.exists'        => 'Siswa yang dipilih tidak valid.',
            'teacher_id.required'      => 'Guru Pembimbing wajib dipilih.',
            'teacher_id.exists'        => 'Guru Pembimbing yang dipilih tidak valid.',
            'mentor_id.required'       => 'Mentor wajib dipilih.',
            'mentor_id.exists'         => 'Mentor yang dipilih tidak valid.',
            'company_name.required'    => 'Nama tempat / instansi PKL wajib diisi.',
            'company_address.required' => 'Alamat tempat PKL wajib diisi.',
            'start_date.required'      => 'Tanggal mulai PKL wajib diisi.',
            'end_date.required'        => 'Tanggal selesai PKL wajib diisi.',
            'end_date.after_or_equal'  => 'Tanggal selesai harus sama dengan atau sesudah tanggal mulai.',
            'status.required'          => 'Status penempatan wajib dipilih.',
            'status.in'                => 'Status penempatan tidak valid.',
        ]);

        // 1. Validasi: Siswa harus berasal dari role siswa
        $student = User::find($validated['student_id']);
        if (!$student || !$student->hasRole('siswa')) {
            return back()
                ->withErrors(['student_id' => 'Pengguna yang dipilih bukan merupakan Siswa.'])
                ->withInput();
        }

        // 2. Validasi: Guru Pembimbing harus berasal dari role guru_pembimbing
        $teacher = User::find($validated['teacher_id']);
        if (!$teacher || !$teacher->hasRole('guru_pembimbing')) {
            return back()
                ->withErrors(['teacher_id' => 'Pengguna yang dipilih bukan merupakan Guru Pembimbing.'])
                ->withInput();
        }

        // 3. Validasi: Mentor harus berasal dari role mentor
        $mentor = User::find($validated['mentor_id']);
        if (!$mentor || !$mentor->hasRole('mentor')) {
            return back()
                ->withErrors(['mentor_id' => 'Pengguna yang dipilih bukan merupakan Mentor.'])
                ->withInput();
        }

        // 4. Validasi: Cegah siswa memiliki lebih dari satu penempatan PKL berstatus aktif
        if ($validated['status'] === 'active') {
            $hasActiveInternship = Internship::where('student_id', $student->id)
                ->where('status', 'active')
                ->exists();

            if ($hasActiveInternship) {
                return back()
                    ->withErrors(['student_id' => 'Siswa ' . $student->name . ' saat ini sudah memiliki penempatan PKL yang berstatus Aktif.'])
                    ->withInput();
            }
        }

        // Simpan data penempatan PKL
        Internship::create($validated);

        return redirect()
            ->route('admin-sekolah.internships.index')
            ->with('success', 'Penempatan PKL untuk siswa ' . $student->name . ' berhasil disimpan.');
    }
}