@extends('layouts.master')

@section('PageTitle') New Customer @endsection


@section('content')
    <h2>New Customer</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('customer.store') }}" method="post" novalidate="novalidate">
    <div class="form-group">
        <label for="Name">Name</label>
        <input class="form-control" data-val="true" data-val-length="Name must be 3-400 Long" data-val-length-max="400" data-val-length-min="3" data-val-required="The Name field is required." id="Name" name="Name" type="text" value="{{ old('Name') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="Name" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="BirthDate">Birthdate</label>
        <input class="form-control" id="BirthDate" name="BirthDate" type="date" value="{{ old('Birthdate') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="BirthDate" data-valmsg-replace="true"></span>

    </div>
    <div class="form-group">
        <label for="CardId">Card Id</label>
        <input class="form-control" id="CardId" name="CardId" type="number" value="{{ old('CardId') }}">
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
    @csrf
</form>
<a href="{{ route('customer.index') }}">Back To List</a>
@endsection
