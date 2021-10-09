<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            if(Auth::user()->role_id == User::ROLE_SUPERADMIN){

                return $next($request);
            }
            dd('a');
            // if(Auth::user()->role_id == User::ROLE_ADMIN){
            //     return redirect()->route('superadminDashboard');
            // }

            // if(Auth::user()->role_id == User::ROLE_KOMDA){
            //     return redirect()->route('superadminDashboard');
            // }

            // if(Auth::user()->role_id == User::ROLE_DAPEN){
            //     return redirect()->route('superadminDashboard');
            // }

            // if(Auth::user()->role_id == User::ROLE_ANGGOTA){
            //     return redirect()->route('superadminDashboard');
            // }
        }
        dd('a');
        return redirect('/login');
    }
}
