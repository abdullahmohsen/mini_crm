<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authorize
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $detector)
    {
    	$user_id = $this->auth->user()->id;
    	$current_role = User::with('role')->find($user_id)->role->name;

    	if($detector == 'customer') {
	        if($current_role != 'super_admin' && $current_role != 'employee') {
				return abort('401');
			}
    	} else if($detector == 'employee') {
    		if($current_role != 'super_admin') {
				return abort('401');
			}
    	}

        return $next($request);
    }
}
