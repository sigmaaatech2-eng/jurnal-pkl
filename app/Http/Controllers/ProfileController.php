<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna yang disesuaikan untuk masing-masing aktor.
     */
    public function edit(Request $request): View
    {
        /** @var User $user */
        $user = $request->user() ?? Auth::user();
        $role = $user->getRoleNames()->first() ?? 'user';

        $data = [
            'user' => $user,
            'role' => $role,
            'stats' => [],
            'internship' => null,
            'relatedUsers' => collect(),
        ];

        switch ($role) {
            case 'siswa':
                $internship = $user->studentInternships()
                    ->with(['mentor', 'teacher'])
                    ->latest()
                    ->first();

                $data['internship'] = $internship;
                $data['stats'] = [
                    'total_journals' => $user->journals()->count(),
                    'approved_journals' => $user->journals()->where('status', 'approved')->count(),
                    'pending_journals' => $user->journals()->where('status', 'pending')->count(),
                    'total_attendances' => $user->attendances()->count(),
                ];
                break;

            case 'guru_pembimbing':
                $internships = $user->teacherInternships()->with('student')->get();
                $data['relatedUsers'] = $internships->pluck('student')->filter()->unique('id');
                $data['stats'] = [
                    'assigned_students' => $data['relatedUsers']->count(),
                    'active_internships' => $internships->where('status', 'active')->count(),
                ];
                break;

            case 'mentor':
                $internships = $user->mentorInternships()->with('student')->get();
                $data['relatedUsers'] = $internships->pluck('student')->filter()->unique('id');
                $data['stats'] = [
                    'mentored_students' => $data['relatedUsers']->count(),
                    'active_internships' => $internships->where('status', 'active')->count(),
                ];
                break;

            case 'admin_sekolah':
            case 'kepala_sekolah':
                $data['stats'] = [
                    'total_students' => User::role('siswa')->count(),
                    'total_teachers' => User::role('guru_pembimbing')->count(),
                    'total_mentors' => User::role('mentor')->count(),
                    'total_internships' => Internship::count(),
                ];
                break;

            case 'admin_platform':
                $data['stats'] = [
                    'total_users' => User::count(),
                    'total_internships' => Internship::count(),
                ];
                break;
        }

        return view('profile.edit', $data);
    }

    /**
     * Perbarui informasi profil pengguna dan data khusus peran.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user() ?? Auth::user();
        $role = $user->getRoleNames()->first();

        // Validasi dasar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string', 'max:1000'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];

        // Validasi tambahan sesuai peran
        if ($role === 'siswa') {
            $rules['nisn'] = ['nullable', 'string', 'max:30'];
            $rules['jurusan'] = ['nullable', 'string', 'max:100'];
            $rules['kelas'] = ['nullable', 'string', 'max:50'];
        } elseif ($role === 'guru_pembimbing') {
            $rules['nip'] = ['nullable', 'string', 'max:50'];
            $rules['bidang'] = ['nullable', 'string', 'max:100'];
        } elseif ($role === 'mentor') {
            $rules['company_name'] = ['nullable', 'string', 'max:255'];
            $rules['position'] = ['nullable', 'string', 'max:100'];
        } elseif (in_array($role, ['admin_sekolah', 'kepala_sekolah'])) {
            $rules['nip'] = ['nullable', 'string', 'max:50'];
            $rules['school_name'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill($validated);
        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Perbarui kata sandi pengguna.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui!');
    }

    /**
     * Hapus foto avatar pengguna.
     */
    public function deleteAvatar(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user() ?? Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }
}
