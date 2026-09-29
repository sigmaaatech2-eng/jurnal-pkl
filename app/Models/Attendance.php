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
        'check_in_lat',
        'check_in_lng',
        'check_in_address',
        'check_out',
        'check_out_photo',
        'check_out_lat',
        'check_out_lng',
        'check_out_address',
        'status',
        'late_status',
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