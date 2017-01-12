<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['social', 'guest']);
    }

    public function redirect($service, Request $request)
    {
        return \Socialite::driver($service)->redirect();
    }

    public function callback($service, Request $request)
    {
        $serviceUser = \Socialite::driver($service)->user();

        $user = $this->getExistingUser($serviceUser, $service);

        if (!$user) {
            $user = User::create([
                'name' => $serviceUser->getName(),
                'email' => $serviceUser->getEmail(),
            ]);
        }

        if (!$user->hasSocialLinked($service)) {
            $user->accounts()->create([
                'social_id' => $serviceUser->getId(),
                'service' => $service,
            ]);
        }

        \Auth::login($user);

        return redirect()->intended();
    }

    protected function getExistingUser($serviceUser, $service)
    {
        return User::where('email', $serviceUser->getEmail())
            ->orWhereHas('accounts', function($q) use ($serviceUser, $service) {
                $q->where('social_id', $serviceUser->getId())
                    ->where('service', $service);
            })->first();
    }
}
