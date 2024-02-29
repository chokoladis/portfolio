<?php

namespace App\Listeners;

use App\Events\ViewsEvent;

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
        // todo viewwed_admin
        $model = $event->model;

        $user_id = auth()->id() ?? request()->ip();
        $user_id = str_replace('.', '_', $user_id);
        
        $name_session = 'view_user_'.$user_id.'_model_'.$model->getTable().'_'.$model->id;
        $session_user_view = session($name_session);
        if (!$session_user_view){
            session([$name_session => true]);
            $event->model->stats->increment('view_count'); 
        }
    }
}
