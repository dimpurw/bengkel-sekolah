<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    protected $guarded = [];

    public function stockOut()
    {
        return $this->belongsTo(StockOut::class);
    }
}
