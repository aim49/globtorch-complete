<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if($request->user()==null)
        {
            return redirect()->back()->withErrors("Insufficient permissions");
        }
        
        foreach($roles as $role)
        {
            if ($request->user()->user_type == $role)
            {
                return $next($request);
            }
        }

        return redirect()->back()->withErrors("Insufficient permissions");
    }
}
