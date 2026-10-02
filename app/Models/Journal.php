<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'internship_id',
        'date',
        'title',
        'description',
        'attachment',
        'link',
        'status',
        'feedback',
        'mentor_score',
        'mentor_rating',
        'mentor_feedback',
    ];

    protected function casts(): array
{
    return [
        'date' => 'date',
    ];
}

    /**
     * Siswa yang membuat jurnal.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Data PKL yang terkait dengan jurnal.
     */
    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }
    
}