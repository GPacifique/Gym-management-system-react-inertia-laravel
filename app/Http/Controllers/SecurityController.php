<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SecurityController extends Controller
{
    public function index()
    {
        return Inertia::render('Security/Index', [
            'settings' => [
                'two_factor' => true,
                'login_alerts' => true,
                'ip_whitelist' => false,
            ]
        ]);
    }
}