<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    
    {
        if (Auth::check()){
            //kalau ada login,boleh akses ke url yamg di minta
        return $next($request);
    }else {
        //kalau belum dibalikin ke login buat login dulu
        return redirect()->route('login')->with('failed', 'Silahkan login terlebih dahulu!');
    }
}
}