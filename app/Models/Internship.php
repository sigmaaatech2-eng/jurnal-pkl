<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'mentor_id',
        'teacher_id',
        'company_name',
        'company_address',
        'start_date',
        'end_date',
        'max_check_in_time',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::retrieved(function (Internship $internship) {
            if ($internship->status === 'active' && $internship->end_date && $internship->end_date->isPast() && ! $internship->end_date->isToday()) {
                $internship->status = 'completed';
                $internship->saveQuietly();
            }
        });
    }

    /**
     * Update otomatis status penempatan yang tanggal selesainya sudah lewat.
     */
    public static function syncExpiredStatuses(): void
    {
        static::where('status', 'active')
            ->where('end_date', '<', now()->toDateString())
            ->update(['status' => 'completed']);
    }

    /**
     * Relasi ke siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relasi ke mentor.
     */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Relasi ke guru pembimbing.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * Semua absensi yang terkait dengan PKL ini.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
