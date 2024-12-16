<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function searchCustomers(Request $request)
    {
        $search = $request->query('query');

        $customers = Customer::with('addresses') // Include the related address
            ->where('phone', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'phone']);

        // Transform the response to include address details
        $results = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $customer->addresses()->first()->address ?? null,
            ];
        });

        return response()->json($results);
    }
    public function search(Request $request)
    {
        $searchPhone = $request->query('phone');
        $searchName = $request->query('name');

        // Query to search customers based on phone or name, with eager loading for related data
        $customers = Customer::with(['user']) // Eager load the 'user' relationship for user name
            ->withCount('orders') // Get the count of orders
            ->when($searchPhone, function ($query) use ($searchPhone) {
                return $query->where('phone', 'LIKE', "%{$searchPhone}%");
            })
            ->when($searchName, function ($query) use ($searchName) {
                return $query->where('name', 'LIKE', "%{$searchName}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'phone']); // Get specific fields

        // Map through the customers and format the response
        $customers = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'orders_count' => $customer->orders_count, // Include order count
                'user' => $customer->user ? $customer->user->name : 'N/A', // Include user name
            ];
        });

        return response()->json($customers);
    }
    public function index()
    {
        $customers = Customer::with('user')->latest()->paginate(5);
        return view('admin.customers.index', compact('customers'));
    }
    public function create()
    {
        return view('admin.customers.create');
    }
    public function show($id)
    {
        $customer = Customer::with('addresses')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $customer = Customer::create($data);
        $address = $request->validate([
            'address' => 'required|string|max:255',
        ]);
        $customer->addresses()->create(['address' => $address]);

        return redirect()->route('customers.index')
            ->with('success', 'تم إضافة العميل بنجاح');
    }
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($data);
        $address = $request->validate([
            'address' => 'required|string|max:255',
        ]);
        $customer->addresses()->update(['address' => $address]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully');
    }
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update([
            'deleted_by' => auth()->id(),
        ]);
        $customer->delete();
        return response()->json(['status' => 'success', 'message' => 'Customer deleted successfully']);
    }
    public function trashed()
    {
        $customers = Customer::onlyTrashed()->with(['deletedBy','user'])->latest()->paginate(5);
        return view('admin.trashed.customers', compact('customers'));
    }
    public function restore($id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $customer->restore();
        return response()->json(['status' => 'success', 'message' => 'Customer restored successfully']);
    }
    public function forceDelete($id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $customer->forceDelete();
        return response()->json(['status' => 'success', 'message' => 'Customer permanently deleted']);
    }
}
