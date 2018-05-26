<?php

namespace App\Listeners;

use App\Events\UserinfoSave;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RefreshCache
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
     * @param  UserinfoSave  $event
     * @return void
     */
    public function handle(UserinfoSave $event)
    {
        Cache::forget('userinfo'.$event->userInfo->user_id);
        //
    }
}
