<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $dates = ['line_reply_limit']; // Casting the event_time field to Carbon

    // Alternatively, you can use the $casts array in newer versions of Laravel
    protected $casts = [
        'line_reply_limit' => 'datetime',
    ];

    public function staffInCharge()
    {
        return $this->belongsToMany(User::class, 'client_staff', 'client_id', 'staff_id')->using(ClientStaff::class);
    }

    public function getFullNameAttribute($value)
    {
        return $this->sei . ' ' . $this->mei;
    }

    public function getLinePictureUrlAttribute($value)
    {
        return $value ?? 'img/default-avatar.png';
    }

    public function getAvatarAttribute()
    {
        return $this->line_picture_url ?? 'img/default-avatar.png';
    }

    public function getDisplayNameAttribute()
    {

        $fullname = $this->sei ? $this->sei .' '. $this->mei : '氏名未登録';
        $nickname = $this->line_display_name;

        $displayName = "{$fullname} ({$nickname})";

        return $displayName;
    }
}
