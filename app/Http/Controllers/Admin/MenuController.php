<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateItemRequest;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function searchItems(Request $request)
    {
        $query = $request->input('query');
        $items = Menu::where('item_name', 'LIKE', "%{$query}%")
            ->get(['id', 'item_name', 'price']);

        return response()->json($items);
    }

    public function index()
    {
        $items = Menu::latest()->paginate(10);
        return view('admin.menu.index', compact('items'));
    }
    public function create()
    {
        return view('admin.menu.create');
    }
    public function store(CreateItemRequest $request)
    {
        $validated = $request->validated();

        $menu = Menu::create($validated);
        return redirect()->route('menu.index')->with('success', 'تم إضافة العنصر بنجاح.');
    }
    public function show($id)
    {
        $item = Menu::findOrFail($id);
        return view('admin.menu.show', compact('item'));
    }
    public function edit($id)
    {
        $item = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('item'));
    }
    public function update(CreateItemRequest $request, $id)
    {
        $validated = $request->validated();
        $menu = Menu::findOrFail($id);
        $menu->update($validated);
        return redirect()->route('menu.index')->with('success', 'تم تحديث العنصر بنجاح.');
    }
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        try {
            $menu->delete();
            return response()->json(['message' => 'Item deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete the item'], 500);
        }
    }
}
