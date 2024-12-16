<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    public function index()
    {
        $items  = Stock::all();
        return view('admin.stock.index', compact('items'));
    }
    public function create()
    {
        return view('admin.stock.create');
    }
    public function show(Stock $stock)
    {
        return view('admin.stock.show', compact('stock'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'created_at' => 'required',
            'notes' => 'nullable|string',
        ]);
        Stock::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'created_at' => $data['created_at'],
            'notes' => $data['notes'],
        ]);
        return redirect()->route('stock.index');
    }
    public function edit(Stock $stock)
    {
        return view('admin.stock.edit', compact('stock'));
    }
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $stock->update($request->all());
        return redirect()->route('stock.index');
    }
    public function destroy($stock)
    {
        $stock = Stock::findOrFail($stock);
        $stock->delete();
        return response()->json(['status' => 'success', 'message' => 'Order deleted successfully']);
    }

}
