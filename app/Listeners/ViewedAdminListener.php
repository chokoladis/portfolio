<?php

namespace App\Listeners;

use App\Events\ViewsAdminEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ViewedAdminListener
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
    public function handle(ViewsAdminEvent $event): void
    {
        $model = $event->model;

        if ($model->stats && !$model->stats->viewed_admin_at){
            $model->stats->viewed_admin_at = now();
            $model->stats->save();
        }
    }
}
