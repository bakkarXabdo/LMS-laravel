<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Student;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use stdClass;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

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
        $validated = \request()->validate([
            'CardId' => 'required|unique:customers',
            'Name' => 'required',
            'BirthDate' => 'required'
        ]);
        $pwd = strtolower(Str::random(4));
        $customer = Db::transaction(function() use ($pwd, $validated) {
            $user = User::create([
                "username" => $validated["CardId"],
                "password" => Hash::make($pwd)
            ]);
            $validated["UserId"] = $user->getKey();
            return Student::create($validated);
        });
        if($customer && $customer->getKey())
        {
            Cache::put("customer-password", $pwd);
            return redirect(route('customer.show', $customer->getKey()));
        }else{
            abort(500, "Internal Server Error");
        }
    }

    public function changePassword($customerId)
    {
        $customer = Student::find($customerId);
        if(!$customer)
        {
            abort(404, 'customer not found');
        }
        $pwd = strtolower(Str::random(4));
        if($customer->user->update(["password" => Hash::make($pwd)]))
        {
            Cache::put("customer-password", $pwd);
            return redirect(route('customer.show', $customer->getKey()));
        }else{
            abort(500, "Internal Server Error");
        }

    }
    public function show($Id)
    {
        $customer = Student::where('Id', $Id)->withCount(["rentals as RentalCount"])->first();
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
        $customer = Student::find($customerId);
        if(!$customer || !$customer->getKey())
        {
            abort(404, "Customer #$customerId not found");
        }
        return view('customer.edit')->with($customer->attributesToArray());
    }

    public function update()
    {
        $customer = Student::find(\request('Id'));
        if(!$customer || !$customer->getKey())
        {
            abort(404, "Customer not found");
        }
        $validated = \request()->validate([
            'CardId' => 'required',
            'Name' => 'required',
            'BirthDate' => 'required'
        ]);
        if($customer->update($validated))
        {
            return redirect(route('customer.show', $customer->getKey()));
        }else{
            abort(500, "internal server Error");
        }
    }

    public function destroy($customerId)
    {
        $customer = Student::find($customerId);
        if (isset($customer) && $customer->getKey()) {
            $rentalsCount = $customer->rentals->count();
            if($rentalsCount > 0) {
                return Response::json((object) [
                    "success" => false,
                    "message" => "Customer has $rentalsCount active Rentals, <a style='color:blue;text-decoration:underline' href='"
                        . route('rentals.forcustomer', $customerId)
                        . "'>View</a>"
                ], 200);
            } else {
                if (DB::transaction(function () use ($customer) {
                    return $customer->delete();
                })) {
                    return Response::json((object) ["success" => true, "message" => "Customer #$customerId Was Removed"], 200);
                } else {
                    return Response::json((object) ["success" => false, "message" => "Unknown Error occurred"], 200);
                }
            }
        } else {
            return Response::json((object) ["success" => false, "message" => "Customer #$customerId Was Not Found"], 200);
        }
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
        $data = Student::query();
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
