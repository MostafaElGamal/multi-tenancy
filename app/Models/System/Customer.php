<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Model
{
    use  UsesSystemConnection, HasRoles;

    protected $guarded = [];
    
    public function hostname()
    {
        return $this->hasOne(Hostname::class);
    }
}
