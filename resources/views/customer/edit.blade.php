@extends('layouts.master')

@section('PageTitle') Customer {{-- {{$Name}} --}} @endsection


@section('content')
<h2>Edit Customer: {{-- {{$Name}} --}}</h2>
    
<form action="{{ route('customer.store'/*'customer.update',  $Id */) }}" method="post" novalidate="novalidate">
    <div class="form-group">
        <label for="Customer_Name">Name</label>
        <input class="form-control" data-val="true" data-val-length="Name must be 3-400 Long" data-val-length-max="400" data-val-length-min="3" 
                data-val-required="The Name field is required." id="Customer_Name" name="Name" type="text" value="{{-- {{$Name}} --}}"
        >
        <span class="field-validation-valid text-danger" data-valmsg-for="Name" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Customer_Birthdate">Birthdate</label>
        <input class="form-control" id="Customer_Birthdate" name="Birthdate" type="date" value="{{-- {{$Birthdate}} --}}">
    </div>
    <div class="form-group">
        <label for="Customer_CardId">Card Id</label>
        <input class="form-control" id="Customer_CardId" name="CardId" type="number" value="{{-- {{$CardId}} --}}">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <input name="Id" type="hidden" value="{{-- {{ $Id }} --}}">
    @csrf
</form>
<a href="{{ route('customer.index') }}">Back To List</a>
@endsection
