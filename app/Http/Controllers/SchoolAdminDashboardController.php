<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolAdminDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama Admin Sekolah dengan data statistik riil.
     */
    public function index()
    {
        // 1. Total Siswa terdaftar
        $totalStudents = User::role('siswa')->count();

        // 2. Total Siswa yang sedang PKL (status aktif)
        $totalActiveInterns = Internship::where('status', 'active')
            ->whereHas('student', function ($q) {
                $q->role('siswa');
            })
            ->distinct('student_id')
            ->count('student_id');

        // 3. Total Guru Pembimbing
        $totalTeachers = User::role('guru_pembimbing')->count();

        // 4. Total Mentor DUDI/Perusahaan
        $totalMentors = User::role('mentor')->count();

        // 5. Total Siswa yang belum memiliki penempatan PKL (belum pernah atau belum aktif/selesai)
        $totalUnassignedStudents = User::role('siswa')
            ->whereDoesntHave('studentInternships', function ($q) {
                $q->whereIn('status', ['active', 'completed']);
            })
            ->count();

        // Daftar penempatan PKL terbaru (6 data)
        $recentInternships = Internship::whereHas('student', function ($q) {
                $q->role('siswa');
            })
            ->with(['student', 'teacher', 'mentor'])
            ->latest()
            ->take(6)
            ->get();

        // Siswa yang belum ditempatkan (5 data untuk quick placement)
        $unassignedStudents = User::role('siswa')
            ->whereDoesntHave('studentInternships', function ($q) {
                $q->whereIn('status', ['active', 'completed']);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('admin-sekolah.dashboard', compact(
            'totalStudents',
            'totalActiveInterns',
            'totalTeachers',
            'totalMentors',
            'totalUnassignedStudents',
            'recentInternships',
            'unassignedStudents'
        ));
    }
}
