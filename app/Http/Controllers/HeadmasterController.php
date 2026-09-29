<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Internship;
use App\Models\Journal;
use App\Models\User;
use App\Models\SchoolMajor;
use Illuminate\Http\Request;

class HeadmasterController extends Controller
{
    /**
     * Dashboard Kepala Sekolah – statistik real-time PKL.
     */
    public function dashboard()
    {
        // Total siswa PKL (aktif)
        $totalStudentsPkl = Internship::where('status', 'active')
            ->whereHas('student', fn ($q) => $q->role('siswa'))
            ->distinct('student_id')
            ->count('student_id');

        // Siswa hadir hari ini
        $presentToday = Attendance::whereDate('date', today())
            ->whereNotNull('check_in')
            ->whereHas('internship', fn ($q) => $q->where('status', 'active'))
            ->distinct('student_id')
            ->count('student_id');

        // Total jurnal
        $totalJournals = Journal::count();

        // Jurnal menunggu review (mentor)
        $pendingJournals = Journal::where('status', 'pending')->count();

        // Jurnal disetujui
        $approvedJournals = Journal::where('status', 'approved')->count();

        // Jurnal ditolak
        $rejectedJournals = Journal::where('status', 'rejected')->count();

        // Ringkasan kondisi PKL – penempatan terbaru
        $recentInternships = Internship::with(['student', 'teacher', 'mentor'])
            ->where('status', 'active')
            ->whereHas('student', fn ($q) => $q->role('siswa'))
            ->latest()
            ->take(6)
            ->get();

        // 1. STATISTIK SISWA PER JURUSAN
        $studentsAll = User::role('siswa')
            ->with(['studentInternships'])
            ->get();

        $majorStats = $studentsAll->groupBy(fn ($u) => $u->jurusan ?: 'Belum Ditentukan')
            ->map(function ($group, $majorName) {
                $total = $group->count();
                $active = $group->filter(fn ($u) => $u->studentInternships->where('status', 'active')->isNotEmpty())->count();
                $completed = $group->filter(fn ($u) => $u->studentInternships->where('status', 'completed')->isNotEmpty())->count();
                $unassigned = $total - $active - $completed;
                $pct = $total > 0 ? round(($active / $total) * 100) : 0;

                return [
                    'major'       => $majorName,
                    'total'       => $total,
                    'active'      => $active,
                    'completed'   => $completed,
                    'unassigned'  => max(0, $unassigned),
                    'percentage'  => $pct,
                ];
            })
            ->values();

        // 2. DATA GRAFIK PERKEMBANGAN SISWA (7 Hari Terakhir)
        $chartLabels = [];
        $chartJournals = [];
        $chartAttendances = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->translatedFormat('d M');

            $chartJournals[] = Journal::whereDate('date', $dateString)->count();
            $chartAttendances[] = Attendance::whereDate('date', $dateString)
                ->whereNotNull('check_in')
                ->count();
        }

        // Data Grafik Distribusi Jurusan
        $chartMajorLabels = $majorStats->pluck('major')->toArray();
        $chartMajorTotals = $majorStats->pluck('total')->toArray();
        $chartMajorActives = $majorStats->pluck('active')->toArray();

        return view('kepala-sekolah.dashboard', compact(
            'totalStudentsPkl',
            'presentToday',
            'totalJournals',
            'pendingJournals',
            'approvedJournals',
            'rejectedJournals',
            'recentInternships',
            'majorStats',
            'chartLabels',
            'chartJournals',
            'chartAttendances',
            'chartMajorLabels',
            'chartMajorTotals',
            'chartMajorActives'
        ));
    }

    /**
     * Daftar seluruh siswa yang sedang PKL.
     */
    public function students(Request $request)
    {
        $query = Internship::with(['student', 'teacher', 'mentor'])
            ->whereHas('student', fn ($q) => $q->role('siswa'));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($request->filled('jurusan')) {
            $jurusan = $request->jurusan;
            $query->whereHas('student', fn ($q) => $q->where('jurusan', $jurusan));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $internships = $query->latest()->paginate(15)->withQueryString();

        // List jurusan yang ada untuk filter
        $jurusanList = SchoolMajor::active()->orderBy('name')->pluck('name');
        if ($jurusanList->isEmpty()) {
            $jurusanList = User::role('siswa')
                ->whereNotNull('jurusan')
                ->distinct()
                ->pluck('jurusan');
        }

        return view('kepala-sekolah.students.index', compact('internships', 'jurusanList'));
    }

    /**
     * Detail siswa PKL – informasi PKL + jurnal.
     */
    public function studentDetail(Internship $internship)
    {
        $internship->load(['student', 'teacher', 'mentor', 'journals', 'attendances']);

        $journals = $internship->journals()->latest('date')->get();
        $attendances = $internship->attendances()->latest('date')->get();

        $totalJournals   = $journals->count();
        $pendingJournals = $journals->where('status', 'pending')->count();
        $approvedJournals = $journals->where('status', 'approved')->count();
        $rejectedJournals = $journals->where('status', 'rejected')->count();
        $totalAttendance = $attendances->count();
        $presentDays     = $attendances->whereNotNull('check_in')->count();

        return view('kepala-sekolah.students.show', compact(
            'internship',
            'journals',
            'attendances',
            'totalJournals',
            'pendingJournals',
            'approvedJournals',
            'rejectedJournals',
            'totalAttendance',
            'presentDays'
        ));
    }

    /**
     * Monitoring jurnal seluruh siswa PKL.
     */
    public function journals(Request $request)
    {
        $query = Journal::with(['student', 'internship.teacher'])
            ->whereHas('student', fn ($q) => $q->role('siswa'));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhere('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $journals = $query->latest('date')->paginate(15)->withQueryString();

        return view('kepala-sekolah.journals.index', compact('journals'));
    }

    /**
     * Monitoring absensi siswa PKL.
     */
    public function attendances(Request $request)
    {
        $query = Attendance::with(['student', 'internship'])
            ->whereHas('student', fn ($q) => $q->role('siswa'));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest('date')->latest('check_in')->paginate(15)->withQueryString();

        return view('kepala-sekolah.attendances.index', compact('attendances'));
    }

    /**
     * Rekap PKL – ringkasan per tempat PKL / keseluruhan.
     */
    public function recap()
    {
        $totalStudents = User::role('siswa')->count();
        $totalActiveStudents = Internship::where('status', 'active')
            ->whereHas('student', fn ($q) => $q->role('siswa'))
            ->distinct('student_id')
            ->count('student_id');
        $totalJournals = Journal::count();
        $totalAttendance = Attendance::whereNotNull('check_in')->count();

        // Rekap per tempat PKL
        $byCompany = Internship::whereHas('student', fn ($q) => $q->role('siswa'))
            ->with(['student', 'journals', 'attendances'])
            ->get()
            ->groupBy('company_name')
            ->map(function ($items) {
                return [
                    'company'     => $items->first()->company_name ?: 'Belum ditentukan',
                    'count'       => $items->count(),
                    'active'      => $items->where('status', 'active')->count(),
                    'journals'    => $items->sum(fn ($i) => $i->journals->count()),
                    'attendances' => $items->sum(fn ($i) => $i->attendances->whereNotNull('check_in')->count()),
                ];
            })
            ->values();

        // Rekap per Guru Pembimbing
        $byTeacher = Internship::whereHas('student', fn ($q) => $q->role('siswa'))
            ->with(['student', 'teacher', 'journals', 'attendances'])
            ->get()
            ->groupBy('teacher_id')
            ->map(function ($items) {
                $teacher = $items->first()->teacher;
                return [
                    'teacher_name' => $teacher ? $teacher->name : 'Belum Ditentukan',
                    'teacher_email'=> $teacher ? $teacher->email : '-',
                    'count'        => $items->count(),
                    'active'       => $items->where('status', 'active')->count(),
                    'journals'     => $items->sum(fn ($i) => $i->journals->count()),
                    'attendances'  => $items->sum(fn ($i) => $i->attendances->whereNotNull('check_in')->count()),
                ];
            })
            ->values();

        // Rekap per Jurusan
        $byMajor = User::role('siswa')
            ->with(['studentInternships.journals', 'studentInternships.attendances'])
            ->get()
            ->groupBy(fn ($u) => $u->jurusan ?: 'Belum Ditentukan')
            ->map(function ($students, $majorName) {
                $internships = $students->flatMap->studentInternships;
                return [
                    'major'       => $majorName,
                    'count'       => $students->count(),
                    'active'      => $internships->where('status', 'active')->count(),
                    'journals'    => $internships->sum(fn ($i) => $i->journals->count()),
                    'attendances' => $internships->sum(fn ($i) => $i->attendances->whereNotNull('check_in')->count()),
                ];
            })
            ->values();

        return view('kepala-sekolah.recap.index', compact(
            'totalStudents',
            'totalActiveStudents',
            'totalJournals',
            'totalAttendance',
            'byCompany',
            'byTeacher',
            'byMajor'
        ));
    }
}

