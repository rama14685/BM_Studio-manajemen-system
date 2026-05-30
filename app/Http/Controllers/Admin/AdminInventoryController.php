<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    /**
     * Display a listing of inventory items.
     */
    public function index(Request $request)
    {
        $type = $request->input('type', 'drink'); // default to drinks view

        $items = Inventory::where('type', $type)
            ->orderBy('name')
            ->get();

        return view('admin.inventories.index', compact('items', 'type'));
    }

    /**
     * Store a newly created inventory item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:drink,equipment',
            'name' => 'required|string|max:255',
            'stock_qty' => 'required|integer|min:0',
            'price' => 'required_if:type,drink|nullable|numeric|min:0',
            'condition' => 'required_if:type,equipment|nullable|in:Baik,Rusak,Sedang Diperbaiki',
        ]);

        Inventory::create($request->all());

        return redirect()->route('admin.inventories.index', ['type' => $request->type])
            ->with('success', 'Item inventaris berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Inventory $inventory)
    {
        return view('admin.inventories.edit', compact('inventory'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock_qty' => 'required|integer|min:0',
            'price' => 'required_if:type,drink|nullable|numeric|min:0',
            'condition' => 'required_if:type,equipment|nullable|in:Baik,Rusak,Sedang Diperbaiki',
        ]);

        $inventory->update($request->all());

        return redirect()->route('admin.inventories.index', ['type' => $inventory->type])
            ->with('success', 'Item inventaris berhasil diperbarui.');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $type = $inventory->type;
        $inventory->delete();

        return redirect()->route('admin.inventories.index', ['type' => $type])
            ->with('success', 'Item inventaris berhasil dihapus.');
    }

    /**
     * Fast adjustment of stock qty.
     */
    public function adjustStock(Request $request, Inventory $inventory)
    {
        $request->validate([
            'adjustment' => 'required|integer',
        ]);

        $newQty = $inventory->stock_qty + $request->adjustment;
        if ($newQty < 0) {
            return back()->with('error', 'Stok tidak boleh kurang dari 0.');
        }

        $inventory->update(['stock_qty' => $newQty]);

        return back()->with('success', 'Stok berhasil disesuaikan.');
    }
}
