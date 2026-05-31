<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\Member;
use App\Models\MemberPayment;
use App\Models\MemberReceipt;
use App\Models\MemberSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MemberPaymentController extends Controller
{
    /**
     * Display payments.
     */
    public function index()
    {
        $payments = MemberPayment::with([
            'member',
            'subscription'
        ])
        ->latest()
        ->paginate(20);

        return Inertia::render(
            'Payments/Index',
            [
                'payments' => $payments
            ]
        );
    }

    /**
     * Show create payment page.
     */
    public function create()
    {
        return Inertia::render(
            'Payments/Create',
            [
                'members' => Member::orderBy('first_name')->get(),
                'subscriptions' => MemberSubscription::with('member')
                    ->where('status', 'active')
                    ->get(),
            ]
        );
    }

    /**
     * Store payment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'member_subscription_id' => 'nullable|exists:member_subscriptions,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:255',
            'transaction_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            $member = Member::findOrFail(
                $validated['member_id']
            );

            $payment = MemberPayment::create([
                'gym_id' => $member->gym_id,
                'member_id' => $validated['member_id'],
                'member_subscription_id' => $validated['member_subscription_id'] ?? null,
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'transaction_reference' => $validated['transaction_reference'] ?? null,
                'payment_date' => now(),
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            MemberReceipt::create([
                'payment_id' => $payment->id,
                'receipt_number' => 'RCT-'
                    . date('Ymd')
                    . '-'
                    . str_pad(
                        $payment->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    ),
                'issued_at' => now(),
            ]);
        });

        return redirect()
            ->route('payments.index')
            ->with(
                'success',
                'Payment recorded successfully.'
            );
    }

    /**
     * View payment.
     */
    public function show(MemberPayment $payment)
    {
        $payment->load([
            'member',
            'subscription',
            'receipt'
        ]);

        return Inertia::render(
            'Payments/Show',
            [
                'payment' => $payment
            ]
        );
    }

    /**
     * Receipt view.
     */
    public function receipt(MemberPayment $payment)
    {
        $payment->load([
            'member',
            'receipt',
            'subscription'
        ]);

        return Inertia::render(
            'Payments/Receipt',
            [
                'payment' => $payment
            ]
        );
    }

    /**
     * Delete payment.
     */
    public function destroy(MemberPayment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with(
                'success',
                'Payment deleted successfully.'
            );
    }
}