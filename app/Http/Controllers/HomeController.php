<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show SaaS landing page
     */
    public function index(Request $request)
    {
        // If user is logged in → redirect to dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        // Public landing stats (temporary placeholders)
        $stats = [
            'businesses' => 100,
            'branches' => 300,
            'services' => 600,
        ];

        return Inertia::render('Home', [
            'stats' => $stats,
        ]);
    }
}