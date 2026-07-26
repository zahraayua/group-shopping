<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'group_id',
        'image',
        'total_price',
        'ocr_text'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}