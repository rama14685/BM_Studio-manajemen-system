<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Inventory;
use App\Models\PosTransaction;
use App\Models\PosItem;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPOSController extends Controller
{
    /**
     * Display the POS screen.
     */
    public function index()
    {
        // Get pending bookings that haven't been paid yet
        $bookings = Booking::with(['user', 'studio'])
            ->where('status', 'pending')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        // Get drinks inventory
        $drinks = Inventory::where('type', 'drink')
            ->where('stock_qty', '>', 0)
            ->orderBy('name')
            ->get();

        return view('admin.pos.index', compact('bookings', 'drinks'));
    }

    /**
     * Process POS checkout.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventories,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $booking = null;
            $bookingPrice = 0;

            if ($request->booking_id) {
                $booking = Booking::with('user')->findOrFail($request->booking_id);
                if ($booking->status === 'paid') {
                    return back()->with('error', 'Booking ini sudah dibayar.');
                }
                $bookingPrice = $booking->total_price;
            }

            // Calculate drinks subtotal and validate stocks
            $drinksSubtotal = 0;
            $posItemsData = [];

            foreach ($request->items as $itemData) {
                $drink = Inventory::findOrFail($itemData['inventory_id']);
                
                if ($drink->type !== 'drink') {
                    return back()->with('error', "Item {$drink->name} lain bukan minuman.");
                }

                if ($drink->stock_qty < $itemData['qty']) {
                    return back()->with('error', "Stok {$drink->name} tidak mencukupi. Sisa stok: {$drink->stock_qty}.");
                }

                $subtotal = $drink->price * $itemData['qty'];
                $drinksSubtotal += $subtotal;

                $posItemsData[] = [
                    'inventory' => $drink,
                    'qty' => $itemData['qty'],
                    'subtotal' => $subtotal,
                ];
            }

            $totalAmount = $bookingPrice + $drinksSubtotal;

            // Create POS Transaction
            $posTransaction = PosTransaction::create([
                'booking_id' => $request->booking_id,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
            ]);

            // Save POS Items & deduct stocks
            foreach ($posItemsData as $item) {
                PosItem::create([
                    'pos_transaction_id' => $posTransaction->id,
                    'inventory_id' => $item['inventory']->id,
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Deduct stock
                $item['inventory']->decrement('stock_qty', $item['qty']);
            }

            // Log Finance Incomes
            $dateToday = now()->toDateString();

            // 1. Log Studio Booking Income (if exists)
            if ($booking) {
                $booking->update(['status' => 'paid']);
                
                Finance::create([
                    'type' => 'income',
                    'category' => 'booking',
                    'amount' => $bookingPrice,
                    'description' => "Pembayaran Booking #{$booking->id} oleh {$booking->user->name} via POS",
                    'date' => $dateToday,
                ]);
            }

            // 2. Log Drinks Income (if exists)
            if ($drinksSubtotal > 0) {
                $desc = "Penjualan Minuman via POS #" . $posTransaction->id;
                if ($booking) {
                    $desc .= " (Disewa oleh {$booking->user->name})";
                }
                Finance::create([
                    'type' => 'income',
                    'category' => 'drinks_stock',
                    'amount' => $drinksSubtotal,
                    'description' => $desc,
                    'date' => $dateToday,
                ]);
            }

            return redirect()->route('admin.pos.receipt', $posTransaction->id)
                ->with('success', 'Transaksi POS berhasil disimpan.');
        });
    }

    /**
     * Show receipt for print.
     */
    public function receipt($id)
    {
        $transaction = PosTransaction::with([
            'booking.user',
            'booking.studio',
            'posItems.inventory'
        ])->findOrFail($id);

        return view('admin.pos.receipt', compact('transaction'));
    }
}
