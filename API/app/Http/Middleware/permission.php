<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $param)
    {                
        $user = Auth::guard()->user();        

        $permission = $user->role->permissions->find($param);
        if($permission) {
            if($permission->active == 1) {
                return $next($request);
            }
        }
        return response()->json([
            'errors' => [
                'main' => 'Unathorized'
            ],
            'status' => false
        ], 401);
    }
}
