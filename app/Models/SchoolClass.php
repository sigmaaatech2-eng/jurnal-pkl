<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolClass extends Model
{
    protected $fillable = [
        'school_major_id',
        'name',
        'grade',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Jurusan dari kelas ini.
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(SchoolMajor::class, 'school_major_id');
    }

    /**
     * Siswa yang terdaftar di kelas ini.
     */
    public function students(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\User::class, 'school_class_id');
    }

    /**
     * Hanya kelas aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Khusus kelas tingkat PKL (Kelas XII / Kelas 12).
     */
    public function scopePkl($query)
    {
        return $query->where(function ($q) {
            $q->where('grade', 'XII')->orWhereNull('grade');
        });
    }
}
