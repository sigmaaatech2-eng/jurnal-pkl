<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Menampilkan halaman absensi siswa.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $internship = $user
            ->studentInternships()
            ->with('mentor')
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $internship) {
            return redirect()
                ->route('siswa.dashboard')
                ->with('error', 'Kamu belum memiliki data PKL aktif.');
        }

        $todayAttendance = Attendance::where('student_id', $user->id)
            ->where('internship_id', $internship->id)
            ->whereDate('date', '=', today())
            ->first();

        $attendances = Attendance::where('student_id', $user->id)
            ->where('internship_id', $internship->id)
            ->latest('date')
            ->get();

        return view(
            'siswa.attendances.index',
            compact(
                'internship',
                'todayAttendance',
                'attendances'
            )
        );
    }

    /**
     * Check In siswa.
     */
    public function checkIn(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $internship = $user
            ->studentInternships()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $internship) {
            return back()
                ->with('error', 'Data PKL aktif tidak ditemukan.');
        }

        $attendance = Attendance::where('student_id', $user->id)
            ->where('internship_id', $internship->id)
            ->whereDate('date', '=', today())
            ->first();

        if ($attendance) {
            return back()
                ->with('error', 'Kamu sudah melakukan check in hari ini.');
        }

        $request->validate([
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],
            'lat' => ['nullable', 'string', 'max:50'],
            'lng' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $photoPath = $request
            ->file('photo')
            ->store('attendance/check-in', 'public');

        $checkInTime = now()->format('H:i:s');
        $maxTime = $internship->max_check_in_time ?? '08:00:00';

        // Tentukan tepat waktu atau terlambat
        $lateStatus = ($checkInTime > $maxTime) ? 'terlambat' : 'tepat_waktu';

        Attendance::create([
            'student_id'       => $user->id,
            'internship_id'    => $internship->id,
            'date'             => today()->toDateString(),
            'check_in'         => $checkInTime,
            'check_in_photo'   => $photoPath,
            'check_in_lat'     => $request->input('lat'),
            'check_in_lng'     => $request->input('lng'),
            'check_in_address' => $request->input('address'),
            'status'           => 'present',
            'late_status'      => $lateStatus,
        ]);

        $msg = $lateStatus === 'terlambat'
            ? 'Check in berhasil. Anda tercatat TERLAMBAT (melebihi batas jam ' . substr($maxTime, 0, 5) . ' WIB).'
            : 'Check in berhasil. Anda hadir TEPAT WAKTU.';

        return back()->with('success', $msg);
    }

    /**
     * Check Out siswa.
     */
    public function checkOut(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $internship = $user
            ->studentInternships()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $internship) {
            return back()
                ->with('error', 'Data PKL aktif tidak ditemukan.');
        }

        $attendance = Attendance::where('student_id', $user->id)
            ->where('internship_id', $internship->id)
            ->whereDate('date', '=', today())
            ->first();

        if (! $attendance) {
            return back()
                ->with('error', 'Kamu belum melakukan check in hari ini.');
        }

        if ($attendance->check_out) {
            return back()
                ->with('error', 'Kamu sudah melakukan check out hari ini.');
        }

        $request->validate([
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],
            'lat' => ['nullable', 'string', 'max:50'],
            'lng' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $photoPath = $request
            ->file('photo')
            ->store('attendance/check-out', 'public');

        $attendance->update([
            'check_out'         => now()->format('H:i:s'),
            'check_out_photo'   => $photoPath,
            'check_out_lat'     => $request->input('lat'),
            'check_out_lng'     => $request->input('lng'),
            'check_out_address' => $request->input('address'),
        ]);

        return back()
            ->with('success', 'Check out berhasil.');
    }
}