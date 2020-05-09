<?php

namespace App\Models\System;

use Hyn\Tenancy\Models\Website;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Hyn\Tenancy\Contracts\Hostname as HostNameContract;

class Hostname extends Model implements HostNameContract
{

    /**
     *  Relationships
     */

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
