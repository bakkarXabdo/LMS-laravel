@extends('layouts.master')

@section('PageTitle') Rental Details @endsection

@section('content')
    <br>
    <h4>Rental Details</h4>
    <table class="table table-responsive table-bordered">
        <tbody>
            <tr class="d-flex">
                <th class="col-sm-2">Customer</th>
                <td><a href="{{ route('students.show', $rental->customer->Id) }}">{{ $rental->customer->Name }}</a></td>
            </tr>
            <tr class="d-flex">
                <th class="col-sm-2">Customer Card-Id</th>
                <td>{{ $rental->customer->CardId }}</td>
            </tr>
            <tr>
                <th>Book Copy</th>
                <td><a href="{{ route('bookcopies.show', $rental->copy->Id) }}">{{ $rental->book->Title }}</a></td>
            </tr>
            <tr>
                <th>Created</th>
                <td>{{\Illuminate\Support\Carbon::parse($rental->DateAdded)->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>Expires</th>
                <td>
                    @if($rental->returnDate < 0)
                        <span class="text-danger">Expired before {{ $rental->returnDate }} Days</span>
                    @elseif($rental->returnDate == 0)
                        <span class="text-warning"> Expired Today! </span>
                    @else
                        After {{ $rental->returnDate }} {{ $rental->returnDate == 1 ? "Day" : "Days"}}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Actions</h4>
    <hr>
    <div class="row" style="margin-left:0">
        <form action="{{ route('rentals.return', $rental->Id) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-success" href>Put Back</button>
        </form>
    </div>
@endsection