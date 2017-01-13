<?php

namespace App\Listeners\Social;

use App\Events\Social\SocialAccountWasLinked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Social\SocialAccountLinked;

class SendSocialAccountLinkedEmail
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
     * @param  SocialAccountWasLinked  $event
     * @return void
     */
    public function handle(SocialAccountWasLinked $event)
    {
        \Mail::to($event->user)->send(new SocialAccountLinked($event->user));
    }
}
