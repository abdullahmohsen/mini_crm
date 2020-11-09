<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'title', 'name'
    ];

    public function user() {
    	return $this->hasOne(User::class);
    }
}
