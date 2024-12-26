<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'energy',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // roles role_id
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');

    }

  
    public function achievements()
    {
       
        return $this->belongsToMany(Achievement::class, 'user_achievements', 'user_id', 'achievement_id');
    }

    // Activities
    public function completedActivitiesCount()
{
    return $this->hasMany(UserActivity::class)
        ->where('status', 'completed')
        ->groupBy('activity_id')
        ->selectRaw('activity_id, COUNT(*) as count')
        ->pluck('count', 'activity_id')
        ->toArray();
}


public function completedActivitiesCountWithName()
{
   
    return $this->hasMany(UserActivity::class)
        ->where('status', 'completed');


}

     // Multiplers for rest_bucks
     public function calculateMultiplier()
     {
         $completedCounts = $this->completedActivitiesCount();
         if (empty($completedCounts)) {
             return 1; // Ako nema završenih aktivnosti, multiplikator je 1
         }
 
         // Izračunaj prosečan broj završenih aktivnosti
         $average = array_sum($completedCounts) / count($completedCounts);
 
         // Izračunaj standardnu devijaciju za uravnoteženost
         $variance = array_reduce($completedCounts, function ($carry, $count) use ($average) {
             return $carry + pow($count - $average, 2);
         }, 0) / count($completedCounts);
 
         $standardDeviation = sqrt($variance);
 
         // Multiplikator je obrnut proporcionalan standardnoj devijaciji
         $balanceMultiplier = 1 + (1 / max($standardDeviation, 1)); // Dodaj minimum od 1 da se izbegne deljenje nulom
 
         return round($balanceMultiplier, 2);
     }
 
     public function calculateEnergyMultiplier()
     {
         $userEnergy = $this->energy; // Trenutna energija korisnika
         $maxEnergy = 96; // Maksimalna energija
 
         // Što je energija manja, multiplikator je veći
         $energyMultiplier = $userEnergy < $maxEnergy
             ? 1 + (1 - ($userEnergy / $maxEnergy)) // Rast multiplikatora pri nižoj energiji
             : 1;
 
         return round($energyMultiplier, 2);
     }

    

    
    


}
