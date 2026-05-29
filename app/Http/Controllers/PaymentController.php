<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * PAYMENTS LIST
     */
    public function index()
    {
        $payments = Payment::with([
            'business',
            'member',
            'subscription'
        ])
        ->latest()
        ->paginate(20);

        /*
        |--------------------------------------------------------------------------
        | INCOME SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalIncome = Payment::where('status', 'paid')
            ->sum('amount');

        $todayIncome = Payment::whereDate(
            'payment_date',
            today()
        )
        ->where('status', 'paid')
        ->sum('amount');

        return Inertia::render('Payments/Index', [
            'payments' => $payments,
            'totalIncome' => $totalIncome,
            'todayIncome' => $todayIncome,
        ]);
    }

    /**
     * CREATE
     */
    public function create()
    {
        return Inertia::render('Payments/Create', [
            'businesses' => Business::all(),
            'members' => Member::all(),
            'subscriptions' => Subscription::all(),
        ]);
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'member_id' => 'required|exists:members,id',
            'subscription_id' => 'nullable|exists:subscriptions,id',
            'amount' => 'required|numeric',
            'payment_method' => 'nullable',
            'transaction_id' => 'nullable',
            'status' => 'required',
            'note' => 'nullable',
            'payment_date' => 'required|date',
        ]);

        Payment::create($validated);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * SHOW
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'business',
            'member',
            'subscription'
        ]);

        return Inertia::render('Payments/Show', [
            'payment' => $payment
        ]);
    }

    /**
     * DELETE
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}