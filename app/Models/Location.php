<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];

    public function goodItem()
    {
        return $this->hasMany(GoodItem::class);
    }

    public function damagedItem()
    {
        return $this->hasMany(DamagedItem::class);
    }
}
