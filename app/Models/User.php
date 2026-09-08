<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Attendance;



use Illuminate\Support\Facades\Storage;

#[Fillable([
    'name',
    'email',
    'avatar',
    'phone',
    'nisn',
    'nip',
    'jurusan',
    'kelas',
    'school_name',
    'bidang',
    'company_name',
    'position',
    'address',
    'bio',
    'password',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'phone',
        'nisn',
        'nip',
        'jurusan',
        'kelas',
        'school_name',
        'bidang',
        'company_name',
        'position',
        'address',
        'bio',
        'password',
    ];

    /** @use HasFactory<UserFactory> */

    /**
     * Get avatar URL or fallback to UI-Avatars.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2563eb&color=ffffff&bold=true';
    }

    /**
     * Get human-readable role name.
     */
    public function getRoleDisplayNameAttribute(): string
    {
        $role = $this->getRoleNames()->first() ?? 'User';
        return match ($role) {
            'siswa' => 'Siswa PKL',
            'guru_pembimbing' => 'Guru Pembimbing',
            'mentor' => 'Mentor Industri',
            'admin_sekolah' => 'Admin Sekolah',
            'kepala_sekolah' => 'Kepala Sekolah',
            'admin_platform' => 'Admin Platform',
            default => ucwords(str_replace('_', ' ', $role)),
        };
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }/**
 * PKL sebagai siswa.
 */
public function studentInternships(): HasMany
{
    return $this->hasMany(Internship::class, 'student_id');
}

/**
 * PKL yang dibimbing sebagai mentor.
 */
public function mentorInternships(): HasMany
{
    return $this->hasMany(Internship::class, 'mentor_id');
}

/**
 * PKL yang dibimbing sebagai guru pembimbing.
 */
public function teacherInternships(): HasMany
{
    return $this->hasMany(Internship::class, 'teacher_id');
}
/**
 * Jurnal yang dibuat oleh siswa.
 */
public function journals(): HasMany
{
    return $this->hasMany(Journal::class, 'student_id');
}
public function attendances(): HasMany
{
    return $this->hasMany(Attendance::class, 'student_id');
}
}
