<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShoppingList;
use App\Models\Message;
use App\Models\User;
use App\Models\Receipt;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by'
    ];

    public function shoppingLists()
    {
        return $this->hasMany(ShoppingList::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}