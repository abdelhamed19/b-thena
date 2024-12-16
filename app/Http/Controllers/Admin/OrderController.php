<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderRequest;
use App\Models\Customer;
use App\Models\CustomerAddress;

class OrderController extends Controller
{
    public function getItemPrice($id)
    {
        // Find the Menu item by its ID
        $item = Menu::find($id);

        if ($item) {
            // Return the item price (item_price attribute)
            return response()->json(['item_price' => $item->item_price]);
        }

        // If item not found, return an error response
        return response()->json(['error' => 'Item not found'], 404);
    }
    public function search(Request $request)
    {
        $query = Order::query();

        // Filter by customer name
        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->customer_name . '%');
            });
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'LIKE', '%' . $request->order_number . '%');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->with(['customer', 'user'])
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'created_at' => $order->created_at->format('Y-m-d h:i A'),
                    'customer_name' => $order->customer->name ?? 'N/A',
                    'total_price' => $order->total_price,
                    'type' => $order->type,
                    'audit_by' => $order->user->name ?? 'N/A',
                ];
            });

        return response()->json($orders);
    }
    public function index()
    {
        $orders = Order::with(['user', 'customer'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    public function create()
    {
        $items = Menu::where('is_active', Menu::ACTIVE)->get();
        return view('admin.orders.create', compact('items'));
    }
    public function store(StoreOrderRequest $request)
    {
        try {
            $validated = $request->validated();
            $totalPrice = collect($validated['items'])->sum('total');
            if (isset($validated['phone_number']) && isset($validated['customer_name'])) {
                $customer = Customer::where('phone', '=', $validated['phone_number'])->first();
                if (!$customer) {
                    $customer = Customer::create([
                        'name' => $validated['customer_name'],
                        'phone' => $validated['phone_number'],
                        'user_id' => auth()->id(),
                    ]);
                    if ($validated['address']) {
                        $customer->addresses()->create(['address' => $validated['address']]);
                    }
                }
                if ($validated['address']) {
                    $customer->addresses()->update(['address' => $validated['address']]);
                }
            }
            // Create order
            $order = Order::create([
                'customer_id' => $customer->id ?? null,
                'type' => $validated['type'],
                'notes' => $validated['notes'] ?? null,
                'total_price' => $totalPrice,
                'status' => 'active',
                'user_id' => auth()->id(),
            ]);

            // Create order items
            $order->items()->createMany($validated['items']);
            return redirect()->route('orders.receipt', $order->id)
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred. Please try again.');
        }
    }
    public function showReceipt(Order $order)
{
    $order->load(['items','customer']); // Load the related order items
    return view('admin.receipt', compact('order'));
}
    public function show($id)
    {
        $order = Order::with(['items', 'customer'])->findOrFail($id);
        $address = CustomerAddress::where('customer_id', $order->customer_id)->first() ?? null;
        return view('admin.orders.show', compact('order', 'address'));
    }
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_number' => 'required',
            'customer_id' => 'required',
            'total_price' => 'required',
            'type' => 'required',
        ]);

        $order->update($request->all());

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        try {
            // $order->items()->delete();
            $order->update([
                'deleted_by' => auth()->id(),
            ]);
            $order->delete();
            return response()->json(['status' => 'success', 'message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Order cannot be deleted']);
        }
    }
    public function trashed()
    {
        $orders = Order::onlyTrashed()->with(['deletedBy', 'customer'])->latest()->paginate(10);
        return view('admin.trashed.orders', compact('orders'));
    }
    public function showTrashed($id)
    {
        $order = Order::onlyTrashed()->with(['items', 'customer'])->findOrFail($id);
        $address = CustomerAddress::where('customer_id', $order->customer_id)->first() ?? null;
        return view('admin.orders.show', compact('order'));
    }
    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        try {
            $order->restore();
            $order->update([
                'deleted_by' => null,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Order restored successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Order cannot be restored']);
        }
    }
    public function forceDelete($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        try {
            $order->forceDelete();
            return response()->json(['status' => 'success', 'message' => 'Order deleted permanently']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Order cannot be deleted permanently']);
        }
    }
}
