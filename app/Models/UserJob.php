<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class UserJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'company', 'location','status','role', 'description', 'application_instructions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }




    public function applications()
    {
        return $this->hasMany(Application::class);
    }


}
