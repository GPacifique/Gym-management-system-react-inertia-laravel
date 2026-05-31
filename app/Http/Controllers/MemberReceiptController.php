<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberReceipt;
use App\Models\MemberPayment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberReceiptController extends Controller
{
    /**
     * List all receipts
     */
    public function index()
    {
        $receipts = MemberReceipt::with([
            'payment.member',
            'payment.subscription'
        ])
        ->latest()
        ->paginate(20);

        return Inertia::render('Receipts/Index', [
            'receipts' => $receipts
        ]);
    }

    /**
     * Show single receipt
     */
    public function show(MemberReceipt $receipt)
    {
        $receipt->load([
            'payment.member',
            'payment.subscription'
        ]);

        return Inertia::render('Receipts/Show', [
            'receipt' => $receipt
        ]);
    }

    /**
     * Print / download receipt view
     */
    public function print(MemberReceipt $receipt)
    {
        $receipt->load([
            'payment.member',
            'payment.subscription'
        ]);

        return Inertia::render('Receipts/Print', [
            'receipt' => $receipt
        ]);
    }

    /**
     * Delete receipt (admin only)
     */
    public function destroy(MemberReceipt $receipt)
    {
        $receipt->delete();

        return redirect()
            ->route('receipts.index')
            ->with('success', 'Receipt deleted successfully.');
    }
}