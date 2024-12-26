<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = ['name', 'description', 'energy_change', 'duration'];
    
    //* Pripada Useru odnos sa user_activities

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_activities', 'activity_id', 'user_id');
    }
}
