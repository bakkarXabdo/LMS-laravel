<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function show($Id)
    {
        $customer = Customer::where('Id', $Id)->withCount(["rentals as RentalCount"])->first();
        if(!$customer)
        {
            abort(404, 'customer not found');
        }
        return view('customer.show')->with($customer->attributesToArray());
    }
}
