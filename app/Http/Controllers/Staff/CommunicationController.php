<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\User;
use App\Models\Staff;
use App\Mail\CommunicationSent;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendCommunicationChunk;

class CommunicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of communications.
     */
    public function index()
    {
        $items = Communication::orderBy('created_at', 'desc')->paginate(15);
        return view('staff.communications.index', compact('items'));
    }

    /**
     * Show the form for creating a new communication.
     */
    public function create()
    {
        return view('staff.communications.create');
    }

    /**
     * Store a newly created communication in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'minutes' => 'nullable|string',
            'activity_type' => 'nullable|string',
            'audience' => 'nullable|in:staff,all',
        ]);

        $data['sender_id'] = auth()->id();
        $data['audience'] = $data['audience'] ?? 'staff';

        $communication = Communication::create($data);

        // Send emails based on audience selection
        $audience = $communication->audience ?? 'staff';
        $emails = collect();

        // Get staff emails (always included)
        $staffEmails = Staff::whereNotNull('email')
            ->where('email', '!=', '')
            ->pluck('email')
            ->filter()
            ->unique();
        $emails = $emails->merge($staffEmails);

        // Get user emails only if audience is 'all'
        if ($audience === 'all') {
            $userEmails = User::whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->filter()
                ->unique();
            $emails = $emails->merge($userEmails);
        }

        // Normalize to array and chunk for batched dispatch
        $emails = $emails->unique()->values()->all();

        $chunkSize = 100;
        $chunks = array_chunk($emails, $chunkSize);

        $dispatched = 0;

        // Check if we should send synchronously
        $forceSync = $request->boolean('send_now')
            || config('queue.default') === 'sync'
            || app()->environment('local')
            || env('COMMUNICATION_FORCE_SEND_SYNC', false);

        foreach ($chunks as $chunk) {
            if ($forceSync) {
                SendCommunicationChunk::dispatchSync($communication, $chunk);
            } else {
                SendCommunicationChunk::dispatch($communication, $chunk);
            }
            $dispatched += count($chunk);
        }

        return redirect()->route('staff.communications.index')
            ->with('success', "Communication queued for sending to {$dispatched} recipients.");
    }

    /**
     * Display the specified communication.
     */
    public function show(Communication $communication)
    {
        return view('staff.communications.show', compact('communication'));
    }

    /**
     * Delete the specified communication.
     */
    public function destroy(Communication $communication)
    {
        $communication->delete();
        return redirect()->route('staff.communications.index')
            ->with('success', 'Communication deleted successfully.');
    }
}
