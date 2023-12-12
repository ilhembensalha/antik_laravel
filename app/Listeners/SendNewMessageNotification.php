<?php

namespace App\Listeners;

use App\Events\NewMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewMessageNotification
{
    public function handle(NewMessage $event)
    {
        broadcast(new NewMessage($event->message));
    }
}