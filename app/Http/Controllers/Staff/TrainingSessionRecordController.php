<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\TrainingSessionRecord;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Http\Request;

class TrainingSessionRecordController extends Controller
{
    public function index()
    {
        $query = TrainingSessionRecord::query();

        if ($branch = request()->query('branch')) {
            $query->where('branch', $branch);
        }

        if ($pitch = request()->query('training_pitch')) {
            $query->where('training_pitch', $pitch);
        }

        if ($coachId = request()->query('coach_id')) {
            $query->where('coach_id', $coachId);
        }

        if ($date = request()->query('date')) {
            $query->whereDate('date', $date);
        }

        $records = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();

        $sessions = TrainingSession::orderBy('date', 'desc')->get(['id','date','location','group_name']);
        $branches = $sessions->pluck('location')->filter()->unique()->values();
        $pitches = $sessions->pluck('group_name')->filter()->unique()->values();

        $coaches = [];
        try {
            $coaches = User::role('coach')->select('id','name')->orderBy('name')->get();
        } catch (\Throwable $e) {
            $coaches = User::select('id','name')->orderBy('name')->get();
        }

        return view('staff.training_sessions.index', compact('records', 'branches', 'pitches', 'coaches'));
    }

    public function create()
    {
        $sessions = TrainingSession::orderBy('date', 'desc')->get(['id','date','location','group_name']);
        $branches = $sessions->pluck('location')->filter()->unique()->values();
        $pitches = ['IPRC Kicukiro- Football', 'Green Hills Academy', 'Star School -Masaka', 'Nyamagana Stadium', 'IPRC-Kigali -Basketball'];

        $coaches = [];
        try {
            $coaches = User::role('coach')->get(['id', 'name']);
        } catch (\Throwable $e) {
            $coaches = User::select('id', 'name')->orderBy('name')->get();
        }

        return view('staff.training_sessions.create', compact('sessions', 'branches', 'pitches', 'coaches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'nullable|date',
            'training_days' => ['nullable', 'array'],
            'training_days.*' => ['in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'country' => 'nullable|string|in:Rwanda,Tanzania',
            'city' => 'nullable|string|in:Kigali,Mwanza',
            'sport_discipline' => 'nullable|string|in:Football,Basketball',
            'coach_name' => 'nullable|string|max:191',
            'coach_id' => 'nullable|exists:users,id',
            'lead_coach_id' => 'nullable|exists:users,id',
            'support_staff' => 'nullable|array',
            'branch' => 'nullable|string|max:191',
            'training_pitch' => 'nullable|string|max:191',
            'other_training_pitch' => 'nullable|string|max:255',
            'training_objective' => 'nullable|string',
            'main_topic' => 'nullable|string|max:191',
        ]);

        // Handle other training pitch
        if (!empty($data['other_training_pitch']) && ($data['training_pitch'] ?? '') === 'Other') {
            $data['training_pitch'] = $data['other_training_pitch'];
        }
        unset($data['other_training_pitch']);

        TrainingSessionRecord::create($data);

        return redirect()->route('training_sessions.index')
            ->with('success', 'Training session record created successfully.');
    }

    public function show(TrainingSessionRecord $trainingSession)
    {
        return view('staff.training_sessions.show', ['record' => $trainingSession]);
    }

    public function edit(TrainingSessionRecord $trainingSession)
    {
        $sessions = TrainingSession::orderBy('date', 'desc')->get(['id','date','location','group_name']);
        $branches = $sessions->pluck('location')->filter()->unique()->values();
        $pitches = ['IPRC Kicukiro- Football', 'Green Hills Academy', 'Star School -Masaka', 'Nyamagana Stadium', 'IPRC-Kigali -Basketball'];

        $coaches = [];
        try {
            $coaches = User::role('coach')->get(['id', 'name']);
        } catch (\Throwable $e) {
            $coaches = User::select('id', 'name')->orderBy('name')->get();
        }

        return view('staff.training_sessions.edit', ['record' => $trainingSession], compact('sessions', 'branches', 'pitches', 'coaches'));
    }

    public function update(Request $request, TrainingSessionRecord $trainingSession)
    {
        $data = $request->validate([
            'date' => 'nullable|date',
            'training_days' => ['nullable', 'array'],
            'training_days.*' => ['in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'start_time' => 'nullable',
            'finish_time' => 'nullable',
            'country' => 'nullable|string|in:Rwanda,Tanzania',
            'city' => 'nullable|string|in:Kigali,Mwanza',
            'sport_discipline' => 'nullable|string|in:Football,Basketball',
            'coach_name' => 'nullable|string|max:191',
            'coach_id' => 'nullable|exists:users,id',
            'lead_coach_id' => 'nullable|exists:users,id',
            'support_staff' => 'nullable|array',
            'branch' => 'nullable|string|max:191',
            'training_pitch' => 'nullable|string|max:191',
            'other_training_pitch' => 'nullable|string|max:255',
            'training_objective' => 'nullable|string',
            'main_topic' => 'nullable|string|max:191',
        ]);

        // Handle other training pitch
        if (!empty($data['other_training_pitch']) && ($data['training_pitch'] ?? '') === 'Other') {
            $data['training_pitch'] = $data['other_training_pitch'];
        }
        unset($data['other_training_pitch']);

        $trainingSession->update($data);

        return redirect()->route('training_sessions.index')
            ->with('success', 'Training session record updated successfully.');
    }

    public function destroy(TrainingSessionRecord $trainingSession)
    {
        $trainingSession->delete();

        return redirect()->route('training_sessions.index')
            ->with('success', 'Training session record deleted successfully.');
    }
}
