<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($studentId)
{
    $student = auth()->user()
        ->students()
        ->with('payments')
        ->findOrFail($studentId);

    $payments = $student->payments()->latest()->get();

    return view('parent.child-payments', compact('student', 'payments'));
}
    // 🔍 View payments for a student (parent view)
    
public function students()
{
    return $this->hasMany(Student::class, 'parent_user_id');
}
    // ➕ Show form (admin/coach)
    public function create(Student $student)
    {
        return view('payments.create', compact('student'));
    }

    // 💾 Store payment
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,mobile_money,card',
            'status' => 'required|in:paid,pending',
        ]);

        Payment::create([
            'student_id' => $student->id,
            'recorded_by' => auth()->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'status' => $request->status,
            'paid_at' => now(),
            'reference' => $request->reference,
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully');
    }

    // 🗑 Delete (optional)
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->back()->with('success', 'Payment deleted');
    }
}