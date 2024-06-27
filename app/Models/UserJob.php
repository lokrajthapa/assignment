<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'company', 'location', 'description', 'application_instructions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authorize($ability, $arguments = [])
    {
        return Auth::user()->can($ability, $this);
    }



}
