<?php

namespace App\Listeners;

use App\Mail\ResourceAlarmEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ResourceAlarm
{   
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $resource = $event->target->resource;

        foreach($resource->subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new ResourceAlarmEmail());
        }
    }
}
