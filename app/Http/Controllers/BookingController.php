<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * LIST ALL BOOKINGS (staff roles)
     */
    public function index()
    {
        $user = auth()->user();

        // Members only see their own bookings
        if ($user->role === 'member') {
            return redirect()->route('bookings.mine');
        }

        $bookings = Booking::with('user')
            ->latest()
            ->paginate(10);

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings
        ]);
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        return Inertia::render('Bookings/Create');
    }

    /**
     * STORE BOOKING
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'date'    => 'required|date',
            'time'    => 'required',
        ]);

        Booking::create([
            'user_id' => auth()->id(),
            'service' => $validated['service'],
            'date'    => $validated['date'],
            'time'    => $validated['time'],
            'status'  => 'pending',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * SHOW SINGLE BOOKING
     */
    public function show(Booking $booking)
    {
        $this->authorizeAccess($booking);

        return Inertia::render('Bookings/Show', [
            'booking' => $booking
        ]);
    }

    /**
     * EDIT FORM
     */
    public function edit(Booking $booking)
    {
        $this->authorizeAccess($booking);

        return Inertia::render('Bookings/Edit', [
            'booking' => $booking
        ]);
    }

    /**
     * UPDATE BOOKING
     */
    public function update(Request $request, Booking $booking)
    {
        $this->authorizeAccess($booking);

        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'date'    => 'required|date',
            'time'    => 'required',
            'status'  => 'nullable|string',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * DELETE BOOKING
     */
    public function destroy(Booking $booking)
    {
        $this->authorizeAccess($booking);

        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * MEMBER VIEW ONLY THEIR BOOKINGS
     */
    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return Inertia::render('Bookings/MyBookings', [
            'bookings' => $bookings
        ]);
    }

    /**
     * ACCESS CONTROL (IMPORTANT)
     */
    private function authorizeAccess(Booking $booking)
    {
        $user = auth()->user();

        // Super admin + manager + receptionist can access all
        if (in_array($user->role, ['super_admin', 'manager', 'receptionist'])) {
            return true;
        }

        // Members only access their own
        if ($user->role === 'member' && $booking->user_id !== $user->id) {
            abort(403);
        }

        return true;
    }
}