<?php

namespace App\Http\Controllers;

use App\Exports\RecapExport;
use App\Models\Journal;
use App\Models\User;
use App\Models\Internship;
use App\Models\Attendance;
use App\Models\SchoolMajor;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\JournalReviewedNotification;

class TeacherJournalController extends Controller
{
    /**
     * Menampilkan jurnal dari siswa yang dibimbing.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $journals = Journal::with([
            'student',
            'internship'
        ])
        ->whereHas('internship', function ($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })
        ->latest('date')
        ->get();

        return view(
            'guru-pembimbing.journals.index',
            compact('journals')
        );
    }


    /**
     * Menampilkan detail jurnal.
     */
    public function show(Journal $journal)
    {
        /** @var User $user */
        $user = Auth::user();

        $journal->load([
            'student',
            'internship'
        ]);

        // Pastikan jurnal berasal dari siswa bimbingannya
        if ($journal->internship->teacher_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke jurnal ini.');
        }

        return view(
            'guru-pembimbing.journals.show',
            compact('journal')
        );
    }


    /**
     * Menampilkan daftar siswa bimbingan.
     */
    public function students(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Ambil opsi filter dari siswa yang belum selesai PKL
        $teacherInternships = Internship::where('teacher_id', $user->id)
            ->where('status', '!=', 'completed')
            ->get();

        $studentIds = $teacherInternships->pluck('student_id');

        $kelasList = SchoolClass::active()->orderBy('name')->pluck('name');
        if ($kelasList->isEmpty()) {
            $kelasList = User::whereIn('id', $studentIds)
                ->whereNotNull('kelas')
                ->where('kelas', '!=', '')
                ->distinct()
                ->orderBy('kelas')
                ->pluck('kelas');
        }

        $jurusanList = SchoolMajor::active()->orderBy('name')->pluck('name');
        if ($jurusanList->isEmpty()) {
            $jurusanList = User::whereIn('id', $studentIds)
                ->whereNotNull('jurusan')
                ->where('jurusan', '!=', '')
                ->distinct()
                ->orderBy('jurusan')
                ->pluck('jurusan');
        }

        $companyList = $teacherInternships->pluck('company_name')->unique()->filter()->values();

        // Query siswa bimbingan (siswa yang sudah selesai PKL tidak ditampilkan lagi)
        $query = Internship::with([
            'student.schoolClass',
            'journals',
            'mentor',
        ])
        ->where('teacher_id', $user->id)
        ->where('status', '!=', 'completed');

        if ($request->filled('kelas')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('kelas', $request->kelas)
                  ->orWhere('school_class_id', $request->kelas)
                  ->orWhereHas('schoolClass', function ($sq) use ($request) {
                      $sq->where('name', $request->kelas);
                  });
            });
        }

        if ($request->filled('jurusan')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('jurusan', $request->jurusan);
            });
        }

        if ($request->filled('company_name')) {
            $query->where('company_name', $request->company_name);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%")
                         ->orWhere('nisn', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Fitur sortir (khususnya sortir per kelas)
        $sort = $request->get('sort', 'latest');
        if ($sort === 'kelas_asc') {
            $query->select('internships.*')
                ->join('users', 'internships.student_id', '=', 'users.id')
                ->leftJoin('school_classes', 'users.school_class_id', '=', 'school_classes.id')
                ->orderByRaw('COALESCE(school_classes.name, users.kelas) ASC NULLS LAST')
                ->orderBy('users.name', 'asc');
        } elseif ($sort === 'kelas_desc') {
            $query->select('internships.*')
                ->join('users', 'internships.student_id', '=', 'users.id')
                ->leftJoin('school_classes', 'users.school_class_id', '=', 'school_classes.id')
                ->orderByRaw('COALESCE(school_classes.name, users.kelas) DESC NULLS LAST')
                ->orderBy('users.name', 'asc');
        } elseif ($sort === 'name_asc') {
            $query->select('internships.*')
                ->join('users', 'internships.student_id', '=', 'users.id')
                ->orderBy('users.name', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->select('internships.*')
                ->join('users', 'internships.student_id', '=', 'users.id')
                ->orderBy('users.name', 'desc');
        } else {
            $query->latest('internships.created_at');
        }

        $internships = $query->get();

        return view(
            'guru-pembimbing.students.index',
            compact('internships', 'kelasList', 'jurusanList', 'companyList')
        );
    }

    /**
     * Menampilkan form tambah siswa bimbingan.
     */
    public function createStudent()
    {
        // Ambil ID siswa yang sedang memiliki kegiatan PKL aktif
        $activeStudentIds = Internship::where('status', 'active')->pluck('student_id');

        // Siswa: hanya user dengan role siswa yang belum memiliki PKL aktif
        $students = User::role('siswa')
            ->with('schoolClass')
            ->whereNotIn('id', $activeStudentIds)
            ->orderBy('name')
            ->get();

        // Mentor: hanya user dengan role mentor
        $mentors = User::role('mentor')
            ->orderBy('name')
            ->get();

        return view(
            'guru-pembimbing.students.create',
            compact('students', 'mentors')
        );
    }

    /**
     * Menyimpan data siswa bimbingan baru ke dalam Internship.
     */
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:users,id',
            ],
            'company_name' => [
                'required',
                'string',
                'max:255',
            ],
            'company_address' => [
                'required',
                'string',
            ],
            'mentor_id' => [
                'nullable',
                'exists:users,id',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
        ], [
            'student_id.required' => 'Pilih siswa yang akan dibimbing.',
            'student_id.exists' => 'Siswa yang dipilih tidak valid.',
            'company_name.required' => 'Nama tempat PKL wajib diisi.',
            'company_address.required' => 'Alamat tempat PKL wajib diisi.',
            'mentor_id.exists' => 'Mentor yang dipilih tidak valid.',
            'start_date.required' => 'Tanggal mulai PKL wajib diisi.',
            'end_date.required' => 'Tanggal selesai PKL wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        // Pastikan user yang dipilih benar-benar role siswa
        $student = User::find($validated['student_id']);
        if (! $student || ! $student->hasRole('siswa')) {
            return back()
                ->withErrors(['student_id' => 'User yang dipilih bukan merupakan siswa.'])
                ->withInput();
        }

        // Cegah siswa memiliki lebih dari satu Internship aktif
        $hasActive = Internship::where('student_id', $student->id)
            ->where('status', 'active')
            ->exists();

        if ($hasActive) {
            return back()
                ->withErrors(['student_id' => 'Siswa ini sudah memiliki kegiatan PKL yang sedang aktif.'])
                ->withInput();
        }

        // Jika mentor dipilih, pastikan rolenya mentor
        if (! empty($validated['mentor_id'])) {
            $mentor = User::find($validated['mentor_id']);
            if (! $mentor || ! $mentor->hasRole('mentor')) {
                return back()
                    ->withErrors(['mentor_id' => 'User yang dipilih bukan merupakan mentor.'])
                    ->withInput();
            }
        }

        // Buat data Internship baru
        Internship::create([
            'student_id' => $student->id,
            'teacher_id' => Auth::id(),
            'mentor_id' => $validated['mentor_id'] ?? null,
            'company_name' => $validated['company_name'],
            'company_address' => $validated['company_address'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'active',
        ]);

        return redirect()
            ->route('guru-pembimbing.students.index')
            ->with('success', 'Siswa berhasil ditambahkan ke daftar bimbingan Anda.');
    }


/**
 * Menampilkan monitoring detail siswa.
 */
public function studentDetail(Internship $internship)
{
    /** @var User $user */
    $user = Auth::user();

    // Pastikan siswa memang merupakan bimbingan guru yang login
    if ($internship->teacher_id !== $user->id) {
        abort(403, 'Anda tidak memiliki akses ke data siswa bimbingan ini.');
    }

    $internship->load([
        'student.schoolClass',
        'journals'
    ]);

    $journals = $internship->journals()
        ->latest('date')
        ->get();

    $totalJournals = $journals->count();

    $pendingJournals = $journals
        ->where('status', 'pending')
        ->count();

    $approvedJournals = $journals
        ->where('status', 'approved')
        ->count();

    $rejectedJournals = $journals
        ->where('status', 'rejected')
        ->count();

        return view(
            'guru-pembimbing.students.show',
            compact(
                'internship',
                'journals',
                'totalJournals',
                'pendingJournals',
                'approvedJournals',
                'rejectedJournals'
            )
        );
    }

    /**
     * Monitoring presensi / absensi seluruh siswa bimbingan.
     */
    public function attendances()
    {
        /** @var User $user */
        $user = Auth::user();

        $internshipIds = Internship::where('teacher_id', $user->id)->pluck('id');

        $attendances = Attendance::with(['student', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->latest('date')
            ->latest('check_in')
            ->paginate(15);

        return view('guru-pembimbing.attendances.index', compact('attendances'));
    }

    /**
     * Rekapitulasi progres siswa bimbingan PKL.
     */
    public function recap()
    {
        /** @var User $user */
        $user = Auth::user();

        $internships = Internship::with(['student', 'journals', 'attendances'])
            ->where('teacher_id', $user->id)
            ->get();

        return view('guru-pembimbing.recap.index', compact('internships'));
    }

    /**
     * Export rekapitulasi PKL ke file XLSX atau CSV (bisa pilih siswa tertentu).
     */
    public function exportRecap(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Internship::with(['student', 'journals', 'attendances', 'mentor'])
            ->where('teacher_id', $user->id);

        $selectedIds = $request->input('internship_ids');
        if (is_string($selectedIds)) {
            $selectedIds = array_filter(explode(',', $selectedIds));
        }

        if (!empty($selectedIds)) {
            $query->whereIn('id', (array) $selectedIds);
        }

        $internships = $query->get();

        if ($internships->isEmpty()) {
            return back()->with('error', 'Tidak ada data siswa yang dipilih atau tersedia untuk diexport.');
        }

        $format   = $request->input('format', $request->query('format', 'xlsx'));
        $filename = 'rekap-pkl-' . now()->format('Ymd-His');

        $export = new RecapExport($internships, $user->name);

        if ($format === 'csv') {
            return $export->downloadCsv($filename . '.csv');
        }

        return $export->downloadXlsx($filename . '.xlsx');
    }
}