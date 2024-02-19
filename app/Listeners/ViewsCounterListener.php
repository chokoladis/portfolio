<?php

namespace App\Listeners;

use App\Events\ViewsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ViewsCounterListener
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
    public function handle(ViewsEvent $event): void
    {
        $event->model->increment('view_count'); 
    }
}
