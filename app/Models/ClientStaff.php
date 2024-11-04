<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientStaff extends Pivot
{
    public $timestamps = false;
    protected $table = 'client_staff';
}
