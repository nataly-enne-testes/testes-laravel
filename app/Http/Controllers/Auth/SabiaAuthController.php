<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SabiaAuthController extends Controller
{
    public function redirectToProvider($provider)
    {

        // $provider é o módulo de autenticação (github, twitter, etc...).
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallBack($provider)
    {

        // pega o user
        $user = Socialite::driver($provider)->stateless()->user();

        $authUser = User::firstOrNew(['provider_id'=>$user->id]);

        $authUser->name=$user->name;
        $authUser->email=$user->email;
        $authUser->provider=$provider;
        $authUser->save();

        auth()->login($authUser);

        return redirect('/');



    }
}
