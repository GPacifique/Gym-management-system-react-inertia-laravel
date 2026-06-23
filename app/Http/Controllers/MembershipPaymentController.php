<?php
namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class MembershipPaymentController extends Controller
{
    public function index()
    {
        $gymId = Auth::user()->gym_id;

        $payments = MembershipPayment::with(['member', 'membership'])
            ->where('gym_id', $gymId)
            ->latest()
            ->paginate(10);

        return Inertia::render('MembershipPayments/Index', [
            'payments' => $payments,
        ]);
    }

    public function create()
    {
        $gymId = Auth::user()->gym_id;

        return Inertia::render('MembershipPayments/Create', [
            'members' => Member::where('gym_id', $gymId)->get(),
            'memberships' => Membership::where('gym_id', $gymId)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'membership_id' => 'required|exists:memberships,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
        ]);

        MembershipPayment::create([
            'gym_id' => Auth::user()->gym_id,
            'member_id' => $request->member_id,
            'membership_id' => $request->membership_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'paid',
            'payment_date' => $request->payment_date,
            'transaction_reference' => $request->transaction_reference,
            'notes' => $request->notes,
        ]);

        return redirect()->route('membership-payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show($id)
    {
        $payment = MembershipPayment::with(['member', 'membership'])
            ->findOrFail($id);

        return Inertia::render('MembershipPayments/Show', [
            'payment' => $payment,
        ]);
    }

    public function destroy($id)
    {
        $payment = MembershipPayment::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Payment deleted successfully.');
    }
}