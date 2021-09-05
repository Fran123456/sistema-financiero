<?php

namespace App\Providers;

use App\Providers\Dashboard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class LogDashboarad
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Dashboard  $event
     * @return void
     */
    public function handle(Dashboard $event)
    {
        activity('Visita')
        ->by(Auth::user())
        ->log('El usuario '.Auth::user()->name.' visitó /dashboard.');        
    }
}
