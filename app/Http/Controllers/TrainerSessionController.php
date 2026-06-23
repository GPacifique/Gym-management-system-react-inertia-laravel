<?php

namespace App\Http\Controllers;

use App\Models\TrainerSession;
use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainerSessionController extends Controller
{
    /**
     * Display sessions.
     */
    public function index(Request $request)
    {
        $trainer = auth()->user()->trainer;

        $sessions = TrainerSession::query()
            ->where('trainer_id', $trainer->id)
            ->with('member')
            ->latest('session_date')
            ->paginate(15);

        return Inertia::render('Trainer/Sessions/Index', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $trainer = auth()->user()->trainer;

        $members = Member::whereHas('trainers', function ($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->get();

        return Inertia::render('Trainer/Sessions/Create', [
            'members' => $members,
        ]);
    }

    /**
     * Store session.
     */
    public function store(Request $request)
    {
        $trainer = auth()->user()->trainer;

        $validated = $request->validate([
            'member_id'      => ['required', 'exists:members,id'],
            'title'          => ['required', 'string', 'max:255'],
            'session_date'   => ['required', 'date'],
            'start_time'     => ['required'],
            'end_time'       => ['required'],
            'location'       => ['nullable', 'string'],
            'notes'          => ['nullable', 'string'],
        ]);

        $validated['trainer_id'] = $trainer->id;
        $validated['status'] = 'scheduled';

        TrainerSession::create($validated);

        return redirect()
            ->route('trainer.sessions.index')
            ->with('success', 'Training session created successfully.');
    }

    /**
     * Show session.
     */
    public function show(TrainerSession $session)
    {
        $this->authorizeSession($session);

        return Inertia::render('Trainer/Sessions/Show', [
            'session' => $session->load('member'),
        ]);
    }

    /**
     * Edit session.
     */
    public function edit(TrainerSession $session)
    {
        $this->authorizeSession($session);

        return Inertia::render('Trainer/Sessions/Edit', [
            'session' => $session,
        ]);
    }

    /**
     * Update session.
     */
    public function update(Request $request, TrainerSession $session)
    {
        $this->authorizeSession($session);

        $validated = $request->validate([
            'title'        => ['required'],
            'session_date' => ['required', 'date'],
            'start_time'   => ['required'],
            'end_time'     => ['required'],
            'location'     => ['nullable'],
            'notes'        => ['nullable'],
            'status'       => ['required'],
        ]);

        $session->update($validated);

        return redirect()
            ->route('trainer.sessions.index')
            ->with('success', 'Session updated successfully.');
    }

    /**
     * Delete session.
     */
    public function destroy(TrainerSession $session)
    {
        $this->authorizeSession($session);

        $session->delete();

        return redirect()
            ->route('trainer.sessions.index')
            ->with('success', 'Session deleted successfully.');
    }

    /**
     * Mark session completed.
     */
    public function complete(TrainerSession $session)
    {
        $this->authorizeSession($session);

        $session->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Session marked as completed.');
    }

    /**
     * Cancel session.
     */
    public function cancel(TrainerSession $session)
    {
        $this->authorizeSession($session);

        $session->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Session cancelled.');
    }

    /**
     * Authorization helper.
     */
    private function authorizeSession(TrainerSession $session)
    {
        if ($session->trainer_id !== auth()->user()->trainer->id) {
            abort(403);
        }
    }
}