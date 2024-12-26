<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $table = 'user_activities';

    protected $fillable = [
        'activity_id',
        'user_id',
        'remaining_time',
        'status',
        'created_at',
        'updated_at',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
