<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Member;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PosController extends Controller
{
    /**
     * POS Screen
     */
    public function index()
    {
        $gymId = auth()->user()->gym_id;

        return Inertia::render('POS/Index', [
            'products' => Product::where('gym_id', $gymId)
                ->where('status', 'active')
                ->get(),

            'members' => Member::where('gym_id', $gymId)
                ->select('id', 'first_name', 'last_name')
                ->get(),
        ]);
    }

    /**
     * Store Sale
     */
    public function store(Request $request)
    {
        $gymId = auth()->user()->gym_id;

        $request->validate([
            'member_id' => ['nullable'],
            'payment_method' => ['required'],
            'items' => ['required', 'array'],
        ]);

        DB::transaction(function () use ($request, $gymId) {

            $subtotal = 0;

            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $sale = Sale::create([
                'gym_id' => $gymId,
                'member_id' => $request->member_id,
                'sale_date' => now(),
                'subtotal' => $subtotal,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'total' => $subtotal
                    - ($request->discount ?? 0)
                    + ($request->tax ?? 0),
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);

            foreach ($request->items as $item) {

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                Product::where('id', $item['product_id'])
                    ->decrement('stock_quantity', $item['quantity']);
            }
        });

        return redirect()
            ->route('pos.index')
            ->with('success', 'Sale completed successfully.');
    }

    /**
     * Sales History
     */
    public function sales()
    {
        $gymId = auth()->user()->gym_id;

        $sales = Sale::where('gym_id', $gymId)
            ->with(['member'])
            ->latest()
            ->paginate(20);

        return Inertia::render('POS/Sales', [
            'sales' => $sales
        ]);
    }

    /**
     * Receipt
     */
    public function receipt(Sale $sale)
    {
        abort_if(
            $sale->gym_id !== auth()->user()->gym_id,
            403
        );

        $sale->load([
            'member',
            'items.product'
        ]);

        return Inertia::render('POS/Receipt', [
            'sale' => $sale
        ]);
    }

    /**
     * Daily Summary
     */
    public function summary()
    {
        $gymId = auth()->user()->gym_id;

        $todaySales = Sale::where('gym_id', $gymId)
            ->whereDate('created_at', today())
            ->sum('total');

        $transactions = Sale::where('gym_id', $gymId)
            ->whereDate('created_at', today())
            ->count();

        return response()->json([
            'sales' => $todaySales,
            'transactions' => $transactions,
        ]);
    }
}