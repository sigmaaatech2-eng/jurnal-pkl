<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Ambil PKL yang sedang aktif
        $internship = $user
            ->studentInternships()
            ->where('status', 'active')
            ->latest()
            ->first();

        // Statistik jurnal siswa
        $totalJournals = $user
            ->journals()
            ->count();

        $pendingJournals = $user
            ->journals()
            ->where('status', 'pending')
            ->count();

        $approvedJournals = $user
            ->journals()
            ->where('status', 'approved')
            ->count();

        $rejectedJournals = $user
            ->journals()
            ->where('status', 'rejected')
            ->count();

        // Absensi hari ini
        $todayAttendance = null;

        if ($internship) {
            $todayAttendance = Attendance::where(
                'student_id',
                $user->id
            )
                ->where(
                    'internship_id',
                    $internship->id
                )
                ->whereDate('date', today())
                ->first();
        }

        return view('siswa.dashboard', compact(
            'internship',
            'totalJournals',
            'pendingJournals',
            'approvedJournals',
            'rejectedJournals',
            'todayAttendance'
        ));
    }
}