<?php

namespace App\Http\Controllers;

use App\Exports\RecapExport;
use App\Models\Journal;
use App\Models\User;
use App\Models\Internship;
use App\Models\Attendance;
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
    public function students()
    {
        /** @var User $user */
        $user = Auth::user();

        $internships = Internship::with([
            'student',
            'journals',
            'mentor',
        ])
        ->where('teacher_id', $user->id)
        ->latest()
        ->get();

        return view(
            'guru-pembimbing.students.index',
            compact('internships')
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
        'student',
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
     * Export rekapitulasi PKL ke file XLSX atau CSV.
     */
    public function exportRecap(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $internships = Internship::with(['student', 'journals', 'attendances', 'mentor'])
            ->where('teacher_id', $user->id)
            ->get();

        $format   = $request->query('format', 'xlsx');
        $filename = 'rekap-pkl-' . now()->format('Ymd-His');

        $export = new RecapExport($internships, $user->name);

        if ($format === 'csv') {
            return $export->downloadCsv($filename . '.csv');
        }

        return $export->downloadXlsx($filename . '.xlsx');
    }
}