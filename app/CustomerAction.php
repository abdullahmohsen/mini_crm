<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAction extends Model
{
    protected $fillable = [
        'action_name', 'customer_id', 'record'
    ];

}
