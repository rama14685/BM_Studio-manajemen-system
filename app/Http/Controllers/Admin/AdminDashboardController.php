<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Finance;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the financial summary dashboard.
     */
    public function index()
    {
        // Totals
        $totalIncome = Finance::where('type', 'income')->sum('amount');
        $totalExpense = Finance::where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // Count stats
        $pendingBookingsCount = Booking::where('status', 'pending')->count();
        $activeBookingsCount = Booking::where('status', 'paid')->count();
        $lowStockDrinks = Inventory::where('type', 'drink')->where('stock_qty', '<', 10)->get();

        // Income by category
        $bookingIncome = Finance::where('type', 'income')->where('category', 'booking')->sum('amount');
        $drinksIncome = Finance::where('type', 'income')->where('category', 'drinks_stock')->sum('amount');
        $otherIncome = Finance::where('type', 'income')->where('category', 'other')->sum('amount');

        // Recent financial transactions
        $recentTransactions = Finance::orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalIncome',
            'totalExpense',
            'netBalance',
            'pendingBookingsCount',
            'activeBookingsCount',
            'lowStockDrinks',
            'bookingIncome',
            'drinksIncome',
            'otherIncome',
            'recentTransactions'
        ));
    }
}
