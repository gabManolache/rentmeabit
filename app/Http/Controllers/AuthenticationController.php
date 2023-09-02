<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{

    // Login Cover
    public function login()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/login', ['pageConfigs' => $pageConfigs]);
    }


    // Register cover
    public function register()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/register', ['pageConfigs' => $pageConfigs]);
    }

    // Forgot Password cover
    public function forgot_password()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/forgot-password', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password cover
    public function reset_password()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/reset-password', ['pageConfigs' => $pageConfigs]);
    }


    // email verify cover
    public function verify_email()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/verify-email', ['pageConfigs' => $pageConfigs]);
    }


    // two steps cover
    public function two_steps()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/two-steps', ['pageConfigs' => $pageConfigs]);
    }

    // register multi steps
    public function register_multi_steps()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/register-multisteps', ['pageConfigs' => $pageConfigs]);
    }
}
