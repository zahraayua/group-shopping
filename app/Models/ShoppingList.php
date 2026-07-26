<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;

class ShoppingList extends Model
{
    protected $fillable = [
        'group_id',
        'owner_id',
        'item_name',
        'quantity',
        'estimated_price',
        'is_checked'
    ];


    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}