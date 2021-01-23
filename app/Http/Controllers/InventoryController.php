<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Rental;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use stdClass;

class InventoryController extends Controller
{

    public function index()
    {
        return view('inventory.index');
    }

    public function create()
    {
        return view('inventory.form',[
            "actionName" => "new",
            "target" => route('inventory.store')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Shelf' => 'required|integer',
            'Column' => 'required|integer',
            'Row' => 'required|integer',
            'Size' => 'required|integer'
        ]);
        $dup = Inventory::where('Shelf', $request['Shelf'])->where('Column', $request['Column'])->where('Row', $request['Row'])->first();
        if($dup)
        {
            return "Inventory <a href='" . $dup->path . "'>$dup->Shelf/$dup->Column/$dup->Row</a> Already Exists";
        }
        $i = Inventory::create($validated);
        $i->save();
        return redirect($i->path);
    }
    public function show($IId)
    {
        $inventory = Inventory::where((new Inventory)->getKeyName(), '=', $IId)->withCount(['copies as Copies'])->first();
        if(!$inventory)
        {
            abort(404);
        }
        return view('inventory.show')->with($inventory->attributesToArray());
    }

    public function edit($InventoryId)
    {
        $inventory = Inventory::find($InventoryId);
        if(!$inventory)
        {
            abort(404, "Inventory #$InventoryId not found");
        }
        return view('inventory.form',[
            "actionName" => "new",
            "target" => route('inventory.update', $inventory->getKey())
        ])->with($inventory->attributesToArray());
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'Shelf' => 'required|integer',
            'Column' => 'required|integer',
            'Row' => 'required|integer',
            'Size' => 'required|integer'
        ]);
        $dup = Inventory::where('Shelf', $request['Shelf'])->where('Column', $request['Column'])->where('Row', $request['Row'])->first();
        if($dup && $dup->getKey() != $inventory->getKey())
        {
            return "Inventory <a href='" . $dup->path . "'>$dup->Shelf/$dup->Column/$dup->Row</a> Already Exists";
        }
        $inventory->update($validated);
        return redirect($inventory->path);
    }

    public function destroy(Inventory $inventory)
    {
        if(Db::transaction(function() use ($inventory) {
            return $inventory->delete();
        })){
            return redirect(route('inventory.index'));
        }else{
            return abort(500);
        }
    }

    public function table()
    {
        $request = json_decode(json_encode(request()->all()));
        $rcol = collect(request('columns'));
        $rcol = $rcol->map(function($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });

        $data = Inventory::query();
        $data->select(['inventory.*',
            Db::raw("(select count(*) from bookcopies where bookcopies.InventoryId = inventory.Id) as Copies")
            ]);
        foreach ($request->order as $order)
        {
            $data->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }
        foreach ($request->columns as $index => $column)
        {
            if($column->searchable && $column->search->value)
            {
                $data->where($rcol->where('Id', '=', $index)->first()['name'], '=' ,$column->search->value);
            }
        }
        $count = $data->count();
        if($request->length > 0)
        {
            $data->skip($request->start);
            $data->take($request->length);
        }
        $data = $data->get();
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->values();
        return Response::json($resp);
    }
}
