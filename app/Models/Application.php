<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_job_id',
        'title',
        'description',
        'resume',
        'cover_letter'

    ];

    public function   userJob()
    {
        return $this->belongsTo(UserJob::class);

    }


}
