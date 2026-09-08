<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Journal;
use App\Models\User;
use App\Notifications\JournalReviewedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorController extends Controller
{
    /**
     * Dashboard mentor — statistik + jurnal terbaru + siswa terbaru.
     */
    public function dashboard()
    {
        /** @var User $mentor */
        $mentor = Auth::user();

        // Semua internship yang mentor ini tangani
        $internships = Internship::with(['student', 'journals'])
            ->where('mentor_id', $mentor->id)
            ->get();

        $internshipIds = $internships->pluck('id');

        $totalStudents       = $internships->count();
        $waitingValidation   = Journal::whereIn('internship_id', $internshipIds)->where('status', 'pending')->count();
        $validated           = Journal::whereIn('internship_id', $internshipIds)->where('status', 'approved')->count();
        $needRevision        = Journal::whereIn('internship_id', $internshipIds)->where('status', 'rejected')->count();

        // Jurnal terbaru
        $recentJournals = Journal::with(['student', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->latest('date')
            ->take(8)
            ->get();

        // Siswa terbaru (6 saja)
        $recentStudents = $internships->take(6)->map(function ($internship) {
            $total    = $internship->journals->count();
            $approved = $internship->journals->where('status', 'approved')->count();
            $pending  = $internship->journals->where('status', 'pending')->count();
            $progress = $total > 0 ? min(100, round(($approved / $total) * 100)) : 0;

            return (object) [
                'internship'    => $internship,
                'student'       => $internship->student,
                'company_name'  => $internship->company_name,
                'status'        => $internship->status,
                'total'         => $total,
                'approved'      => $approved,
                'pending'       => $pending,
                'progress'      => $progress,
            ];
        });

        return view('mentor.dashboard', compact(
            'mentor',
            'totalStudents',
            'waitingValidation',
            'validated',
            'needRevision',
            'recentJournals',
            'recentStudents',
            'internships'
        ));
    }

    /**
     * Daftar siswa bimbingan mentor.
     */
    public function students(Request $request)
    {
        /** @var User $mentor */
        $mentor = Auth::user();

        $query = Internship::with(['student', 'journals', 'attendances'])
            ->where('mentor_id', $mentor->id);

        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $internships = $query->latest()->get();

        return view('mentor.students.index', compact('internships'));
    }

    /**
     * Jurnal milik satu siswa bimbingan.
     */
    public function studentJournals(Request $request, Internship $internship)
    {
        /** @var User $mentor */
        $mentor = Auth::user();

        if ($internship->mentor_id !== $mentor->id) {
            abort(403, 'Anda tidak memiliki akses ke data siswa ini.');
        }

        $internship->load(['student', 'mentor']);

        $journalQuery = $internship->journals()->latest('date');

        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $journalQuery->where('status', $request->status);
        }

        // Search judul/kegiatan
        if ($request->filled('search')) {
            $search = $request->search;
            $journalQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $journals = $journalQuery->get();

        $totalJournals    = $internship->journals()->count();
        $approvedJournals = $internship->journals()->where('status', 'approved')->count();
        $pendingJournals  = $internship->journals()->where('status', 'pending')->count();
        $rejectedJournals = $internship->journals()->where('status', 'rejected')->count();

        return view('mentor.students.show', compact(
            'internship',
            'journals',
            'totalJournals',
            'approvedJournals',
            'pendingJournals',
            'rejectedJournals'
        ));
    }

    /**
     * Detail satu jurnal.
     */
    public function journalDetail(Journal $journal)
    {
        /** @var User $mentor */
        $mentor = Auth::user();

        $journal->load(['student', 'internship']);

        if ($journal->internship->mentor_id !== $mentor->id) {
            abort(403, 'Anda tidak memiliki akses ke jurnal ini.');
        }

        return view('mentor.journals.show', compact('journal'));
    }

    /**
     * Validasi jurnal (approve + simpan nilai).
     */
    public function validateJournal(Request $request, Journal $journal)
    {
        /** @var User $mentor */
        $mentor = Auth::user();

        $journal->load('internship');

        if ($journal->internship->mentor_id !== $mentor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'mentor_score'    => ['nullable', 'integer', 'min:0', 'max:100'],
            'mentor_rating'   => ['nullable', 'in:sangat_baik,baik,cukup,perlu_perbaikan'],
            'mentor_feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $journal->update([
            'status'          => 'approved',
            'mentor_score'    => $validated['mentor_score']    ?? null,
            'mentor_rating'   => $validated['mentor_rating']   ?? null,
            'mentor_feedback' => $validated['mentor_feedback'] ?? null,
        ]);

        // Notifikasi ke siswa bahwa jurnalnya telah disetujui
        $journal->load('student');
        if ($journal->student) {
            $journal->student->notify(new JournalReviewedNotification($journal));
        }

        return redirect()
            ->route('mentor.journals.show', $journal)
            ->with('success', 'Jurnal berhasil divalidasi.');
    }

    /**
     * Minta revisi jurnal (reject + simpan alasan).
     */
    public function requestRevision(Request $request, Journal $journal)
    {
        /** @var User $mentor */
        $mentor = Auth::user();

        $journal->load('internship');

        if ($journal->internship->mentor_id !== $mentor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'mentor_feedback' => ['required', 'string', 'max:1000'],
        ], [
            'mentor_feedback.required' => 'Keterangan revisi wajib diisi.',
        ]);

        $journal->update([
            'status'          => 'rejected',
            'mentor_feedback' => $validated['mentor_feedback'],
        ]);

        // Notifikasi ke siswa bahwa jurnalnya memerlukan revisi
        $journal->load('student');
        if ($journal->student) {
            $journal->student->notify(new JournalReviewedNotification($journal));
        }

        return redirect()
            ->route('mentor.journals.show', $journal)
            ->with('success', 'Permintaan revisi telah dikirim ke siswa.');
    }
}
