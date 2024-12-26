<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Achievement extends Model
{
    use HasFactory;

    // Ako je potrebno, definiraj koje kolone su masovno dodeljive
    protected $fillable = ['name', 'description'];

    //* Pripada Useru odnos sa user_achievements

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements', 'achievement_id', 'user_id');
    }
}
