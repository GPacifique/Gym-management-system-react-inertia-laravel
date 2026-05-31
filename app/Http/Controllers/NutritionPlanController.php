<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NutritionPlanController extends Controller
{
    /**
     * Display nutrition plans.
     */
    public function index()
    {
        $plans = [];

        return Inertia::render('NutritionPlans/Index', [
            'plans' => $plans,
        ]);
    }
}