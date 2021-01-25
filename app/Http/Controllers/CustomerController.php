<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use stdClass;

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
    public function choose()
    {
        return view('customer.index',[
            "renting" => true,
            'copyId' => \request('copyId')
        ]);
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
    public function table()
    {
        // the request
        $request = json_decode(json_encode(request()->all()));
        $rcol = collect(request('columns'));
        $rcol = $rcol->map(function($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });

        // database
        $data = Customer::query();
        $data->withCount(['rentals as RentalsCount']);

        // ordering
        foreach ($request->order as $order)
        {
            $data->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }

        // column search
        foreach ($request->columns as $index => $column)
        {
            if($column->searchable && $column->search->value)
            {
                $data->where($rcol->where('Id', '=', $index)->first()['name'], 'LIKE' ,'%'.$column->search->value.'%');
            }
        }

        // are we renting?
        if(isset($request->renting) && $request->renting)
        {
            // Do something special
        }

        // pagination
        $count = $data->count();
        if($request->length > 0)
        {
            $data->skip($request->start);
            $data->take($request->length);
        }

        // Response
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->get()->values();
        return Response::json($resp);
    }
}
