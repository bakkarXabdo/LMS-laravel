
@extends('layouts.master')

@section('PageTitle') {{ $actionName }} Inventory @endsection

@section('content')
    <h3>New Inventory</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            Please Fix These Errors-
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ $target }}" method="post" novalidate="novalidate">
        @csrf
        <div class="form-group">
            <label for="Shelf">Shelf</label>
            <input class="form-control" data-val="true" data-val-number="The field Shelf must be a number." data-val-required="The Shelf field is required." id="Shelf" name="Shelf" type="number" value="{{ isset($Shelf) ? $Shelf : '' }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Shelf" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Column">Column</label>
            <input class="form-control" data-val="true" data-val-number="The field Column must be a number." data-val-required="The Column field is required." id="Column" name="Column" type="number" value="{{ isset($Column) ? $Column : '' }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Column" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Row">Row</label>
            <input class="form-control" data-val="true" data-val-number="The field Row must be a number." data-val-required="The Row field is required." id="Row" name="Row" type="number" value="{{ isset($Row) ? $Row : '' }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Row" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Size">Size</label>
            <input class="form-control" data-val="true" data-val-number="The field Size must be a number." data-val-required="The Size field is required." id="Size" min-val="1" name="Size" type="number" value="{{ isset($Size) ? $Size : '' }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Size" data-valmsg-replace="true"></span>
        </div>
        <input data-val="true" data-val-number="The field Id must be a number." data-val-required="The Id field is required." id="Id" name="Id" type="hidden" value="{{ isset($Id) ? $Id : '' }}">
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
@endsection