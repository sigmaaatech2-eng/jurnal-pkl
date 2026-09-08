<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_id',
    'internship_id',
    'date',
    'check_in',
    'check_in_photo',
    'check_out',
    'check_out_photo',
    'status',
];

    protected $casts = [
        'date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }
}