<?php

namespace App\Models;

use App\Services\UtilityService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $guarded = [];

    public function sender()
    {
        if ($this->from_user) {
            return $this->belongsTo(Client::class, 'sender_id', 'line_user_id');
        } else {
            return $this->belongsTo(Organisation::class, 'organisation_id');
        }
    }

    public function receiver()
    {
        if ($this->from_user) {
            return $this->belongsTo(Organisation::class, 'sender_id');
        } else {
            return $this->belongsTo(Client::class, 'sender_id', 'line_user_id');
        }
    }

    public function getCreatedAtLabelAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans(); // Customize format
    }
}
