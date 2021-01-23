<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        return view('customer.index');
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store()
    {
        return true;
    }

    public function show($Id)
    {
        $customer = Customer::where('Id', $Id)->withCount(["rentals as RentalCount"])->first();
        if(!$customer)
        {
            abort(404, 'customer not found');
        }
        return view('customer.show')->with($customer->attributesToArray());
    }

    public function edit($customerId)
    {
        return view('customer.edit');
    }

    public function update()
    {
        return true;
    }

    public function destroy($customerId)
    {
        return true;
    }
}
