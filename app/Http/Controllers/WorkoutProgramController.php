<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkoutProgramController extends Controller
{
    /**
     * Display workout programs.
     */
    public function index()
    {
        $programs = [];

        return Inertia::render('WorkoutPrograms/Index', [
            'programs' => $programs,
        ]);
    }
}