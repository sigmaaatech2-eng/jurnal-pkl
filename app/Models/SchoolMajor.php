<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolMajor extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Kelas-kelas yang termasuk dalam jurusan ini.
     */
    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'school_major_id');
    }

    /**
     * Hanya jurusan aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
