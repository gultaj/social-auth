<?php

namespace App\Observers;

use App\SocialAccount;
use App\Events\Social\SocialAccountWasLinked;

class SocialAccountObserver 
{
    public function created(SocialAccount $socialAccount)
    {
        event(new SocialAccountWasLinked($socialAccount->user()->first()));
    }
}