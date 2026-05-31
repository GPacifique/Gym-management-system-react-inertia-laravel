<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    public function index()
    {
        return response('', 200);
    }

    public function create(Request $request)
    {
        $staff_id = $request->query('staff_id');
        $staff = Staff::findOrFail($staff_id);
        return view('staff.attendances.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'attendance_date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,late'],
            'notes' => ['nullable', 'string'],
        ]);

        // TODO: Store attendance record
        // StaffAttendance::create($validated);

        return redirect()->route('staff.show', $validated['staff_id'])
                       ->with('success', 'Attendance recorded successfully');
    }
}
