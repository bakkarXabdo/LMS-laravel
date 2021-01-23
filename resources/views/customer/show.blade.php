@extends('layouts.master')

@section('PageTitle') Customer {{ $Name }} @endsection


@section('content')
    <div class="container body-content">
        <h2>{{ $Name }}</h2>
        <h4>Customer Details</h4>
        <table class="table table-responsive table-bordered">
            <tbody>
                <tr class="d-flex">
                    <th class="col-sm-2">Name</th>
                    <td class="col-sm-10">{{ $Name }}</td>
                </tr>
                <tr>
                    <th>Birth Date</th>
                    <td>{{ \Carbon\Carbon::parse()->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Card Id</th>
                    <td>{{ $CardId }}</td>
                </tr>
                <tr>
                    <th>Rented Books</th>
                    <td>
                        @if($RentalCount == 0 )
                            0 Books
                        @else
                            <a href="{{ route('rentals.forcustomer', $Id) }}">{{ $RentalCount }} {{ $RentalCount > 1 ? "Books" : "Book"}}</a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <h4>Actions</h4>
        <hr>
        <div class="row" style="margin-left:0">
            <a class="btn btn-primary" href="{{ route('customer.edit', $Id) }}">Edit</a>
            <a class="btn btn-primary" href="{{ route('rentals.create', ["customerId" => $Id]) }}">Rent</a>
            <form style="display: inline-block;" action="{{ route('customer.destroy', $Id) }}">
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
@endsection
