<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class CheckLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
     {
         /*if (Session::has('language')) {
             if (App::getLocale()!= Session::get('language')) {
              App::setLocale(Session::get('language'));
             }
           }else {
              Session::put('language', 'es');
              App::setLocale('es');
          }
           return $next($request);*/

           if (config('locale.status')) {
            if (session()->has('locale') &&
                in_array(session()->get('locale'), array_keys(config('locale.languages')))) {

                /*
                 * Establece el locale de Laravel
                 */
                app()->setLocale(session()->get('locale'));

                setlocale(LC_TIME, config('locale.languages')[session()->get('locale')][1]);

                Carbon::setLocale(config('locale.languages')[session()->get('locale')][0]);


                if (config('locale.languages')[session()->get('locale')][2]) {
                    session(['lang-rtl' => true]);
                } else {
                    session()->forget('lang-rtl');
                }
            }
        }

        return $next($request);
     }
}
