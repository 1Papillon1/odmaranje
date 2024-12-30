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

    public function calculateXP()
    {
        $energyChangeFactor = $this->type === 'add' ? 2 : 1;

        $baseXP = $this->duration * $energyChangeFactor;

        if ($this->duration > 120) {
            $baseXP *= 1.2; 
        } elseif ($this->duration > 60) {
            $baseXP *= 1.1; 
        }

        
        return round($baseXP);
    }
}
