<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() == FALSE){
          //false artisany check nya gagal(belum login),kalau belum login boleh akses ke permintaan selanjutnya
        return $next($request);
    }else {
        return redirect()->route('landing_page')->with('failed', 'Anda sudah login!tidak dapat melakukan proses login kembali.');
    }
}
}