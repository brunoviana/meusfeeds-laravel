<?php

namespace App\Http\Controllers;

use Socialite;

class AutenticarUsuarioController extends Controller
{
    public function google()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            // return redirect('/login');
        }
    }
}
