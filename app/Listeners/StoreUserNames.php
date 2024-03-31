<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;


class StoreUserNames
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    // 监听器 StoreUserNames
    public function handle(Registered $event)
    {
        session([
            'nom' => $event->user->nom,
            'prenom' => $event->user->prenom,
        ]);
    }

}
