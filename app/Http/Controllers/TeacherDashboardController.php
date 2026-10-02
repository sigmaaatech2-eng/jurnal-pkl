<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Internship;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama Guru Pembimbing.
     */
    public function index()
    {
        /** @var User $teacher */
        $teacher = Auth::user();

        // 1. Ambil data seluruh siswa bimbingan (PKL)
        $internships = Internship::with(['student', 'journals'])
            ->where('teacher_id', $teacher->id)
            ->get();

        $internshipIds = $internships->pluck('id');

        // STATISTIK UTAMA
        $totalStudents = $internships->count();

        // Hadir hari ini
        $presentToday = Attendance::whereIn('internship_id', $internshipIds)
            ->whereDate('date', today())
            ->whereNotNull('check_in')
            ->count();

        // Jurnal masuk
        $totalJournals = Journal::whereIn('internship_id', $internshipIds)->count();

        // Jurnal menunggu review
        $pendingJournals = Journal::whereIn('internship_id', $internshipIds)
            ->where('status', 'pending')
            ->count();

        // 2. AKTIVITAS TERBARU (Siswa kirim jurnal, jurnal direview, absensi siswa)
        $activities = collect();

        // a. Siswa mengirim jurnal
        $recentJournals = Journal::with(['student', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->latest('created_at')
            ->take(5)
            ->get();

        foreach ($recentJournals as $journal) {
            $activities->push((object)[
                'type' => 'journal_submitted',
                'title' => $journal->student->name ?? 'Siswa',
                'description' => 'Mengirim jurnal kegiatan: "' . ($journal->title ?? 'Kegiatan PKL') . '"',
                'company' => $journal->internship->company_name ?? null,
                'time' => $journal->created_at,
                'status' => $journal->status,
                'badge' => $journal->status === 'pending' ? 'Menunggu Review' : ($journal->status === 'approved' ? 'Disetujui' : 'Revisi'),
                'badge_color' => $journal->status === 'pending' ? 'amber' : ($journal->status === 'approved' ? 'emerald' : 'red'),
                'url' => route('guru-pembimbing.journals.show', $journal),
            ]);
        }

        // b. Jurnal direview
        $reviewedJournals = Journal::with(['student', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        foreach ($reviewedJournals as $journal) {
            $isApproved = $journal->status === 'approved';
            $activities->push((object)[
                'type' => 'journal_reviewed',
                'title' => $journal->student->name ?? 'Siswa',
                'description' => 'Jurnal "' . ($journal->title ?? 'Kegiatan PKL') . '" telah ' . ($isApproved ? 'disetujui' : 'ditolak / perlu revisi'),
                'company' => $journal->internship->company_name ?? null,
                'time' => $journal->updated_at,
                'status' => $journal->status,
                'badge' => $isApproved ? 'Selesai Direview' : 'Perlu Revisi',
                'badge_color' => $isApproved ? 'emerald' : 'rose',
                'url' => route('guru-pembimbing.journals.show', $journal),
            ]);
        }

        // c. Absensi siswa
        $recentAttendances = Attendance::with(['student', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->whereNotNull('check_in')
            ->latest('date')
            ->latest('check_in')
            ->take(5)
            ->get();

        foreach ($recentAttendances as $att) {
            $timeText = 'Check-in ' . substr($att->check_in, 0, 5) . ' WIB';
            if ($att->check_out) {
                $timeText .= ' • Check-out ' . substr($att->check_out, 0, 5) . ' WIB';
            }

            $activities->push((object)[
                'type' => 'attendance',
                'title' => $att->student->name ?? 'Siswa',
                'description' => 'Melakukan presensi hadir: ' . $timeText,
                'company' => $att->internship->company_name ?? null,
                'time' => $att->created_at ?? $att->date,
                'status' => 'present',
                'badge' => 'Presensi Hadir',
                'badge_color' => 'blue',
                'url' => route('guru-pembimbing.students.show', $att->internship_id),
            ]);
        }

        // Urutkan dan ambil 7 aktivitas teratas
        $recentActivities = $activities->sortByDesc('time')->take(7)->values();

        // 3. DAFTAR SISWA BIMBINGAN DENGAN PROGRESS
        $recentStudents = $internships->take(6)->map(function ($internship) {
            $totalCount = $internship->journals->count();
            $approvedCount = $internship->journals->where('status', 'approved')->count();
            $pendingCount = $internship->journals->where('status', 'pending')->count();
            $progressPercent = $totalCount > 0 ? min(100, round(($approvedCount / $totalCount) * 100)) : 0;

            return (object)[
                'id' => $internship->id,
                'internship' => $internship,
                'student' => $internship->student,
                'name' => $internship->student->name ?? 'Siswa',
                'email' => $internship->student->email ?? '-',
                'company_name' => $internship->company_name ?? 'Belum ditentukan',
                'company_address' => $internship->company_address,
                'status' => $internship->status ?? 'active',
                'total_journals' => $totalCount,
                'approved_journals' => $approvedCount,
                'pending_journals' => $pendingCount,
                'progress_percent' => $progressPercent,
                'url' => route('guru-pembimbing.students.show', $internship),
            ];
        });

        return view('guru-pembimbing.dashboard', compact(
            'totalStudents',
            'presentToday',
            'totalJournals',
            'pendingJournals',
            'recentActivities',
            'recentStudents'
        ));
    }
}
