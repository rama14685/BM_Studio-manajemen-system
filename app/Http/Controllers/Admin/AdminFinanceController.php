<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;

class AdminFinanceController extends Controller
{
    /**
     * Display a listing of financial transactions.
     */
    public function index(Request $request)
    {
        $query = Finance::orderBy('date', 'desc')->orderBy('created_at', 'desc');

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $finances = $query->paginate(15);
        return view('admin.finances.index', compact('finances'));
    }

    /**
     * Show the form for creating a new financial log.
     */
    public function create()
    {
        return view('admin.finances.create');
    }

    /**
     * Store a newly created financial log.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|in:booking,electricity,drinks_stock,other',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
            'date' => 'required|date',
        ]);

        Finance::create($request->all());

        return redirect()->route('admin.finances.index')->with('success', 'Catatan keuangan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the financial log.
     */
    public function edit(Finance $finance)
    {
        return view('admin.finances.edit', compact('finance'));
    }

    /**
     * Update the financial log in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|in:booking,electricity,drinks_stock,other',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
            'date' => 'required|date',
        ]);

        $finance->update($request->all());

        return redirect()->route('admin.finances.index')->with('success', 'Catatan keuangan berhasil diperbarui.');
    }

    /**
     * Remove the financial log from storage.
     */
    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect()->route('admin.finances.index')->with('success', 'Catatan keuangan berhasil dihapus.');
    }
}
