<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code', 'user_id', 'item_id', 'price', 'qty', 'status', 'msg'
    ];
}