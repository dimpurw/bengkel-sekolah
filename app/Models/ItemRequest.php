<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    protected $guarded = [];

    public function goodItem()
    {
        return $this->belongsTo(GoodItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
