<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Internship;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('admin_platform')) {
            return redirect()->route('admin-platform.dashboard');
        }

        if ($user->hasRole('admin_sekolah')) {
            return redirect()->route('admin-sekolah.dashboard');
        }

        if ($user->hasRole('kepala_sekolah')) {
            return redirect()->route('kepala-sekolah.dashboard');
        }

        if ($user->hasRole('guru_pembimbing')) {
            return redirect()->route('guru-pembimbing.dashboard');
        }

        if ($user->hasRole('mentor')) {
            return redirect()->route('mentor.dashboard');
        }

        if ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        abort(403, 'User tidak ditemukan.');
    }
}