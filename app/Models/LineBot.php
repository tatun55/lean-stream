<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineBot extends Model
{
    protected $guarded = [];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
}
