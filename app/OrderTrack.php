<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'admin' => 'App\Admin',
    'customer' => 'App\Customer'
]);

class OrderTrack extends Model
{
    public function orderable()
    {
        return $this->morphTo();
    }
}