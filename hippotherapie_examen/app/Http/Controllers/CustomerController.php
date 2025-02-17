<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::all();
        return view ('customer.index', compact('customers'));
    }

    public function store(CustomerRequest $request): RedirectResponse
    {
        $data = $request->except('_token');
        Customer::create($data);
        return redirect()->route('customer.index');  
    }

    public function edit(Customer $customer): View
    {
        return view ('customer.edit', compact('customer'));   
    }

    public function create(): View
    {
        return view ('customer.create');
    }

    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        $data = $request->except('_token');
        $customer->update($data);
        return redirect()->route('customer.index');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        return redirect()->route('customer.index');
    }

    public function showCustomer(Customer $customer): View
    {
        $invoices = Invoice::where('customer_id', $customer->id)->get();
        return view('customer.customer', compact('customer', 'invoices'));
    }
}
