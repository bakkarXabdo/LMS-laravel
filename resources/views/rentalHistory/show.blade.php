@extends('layouts.master')

@section('PageTitle') Rental History @endsection


@section('content')
    <div class="container body-content">
        <h2>Rental History #{{ $history->getKey() }}</h2>
        <h4>Rental Details</h4>
        <table class="table table-responsive table-bordered">
            <tbody>
            <tr class="d-flex">
                <th class="col-sm-2">Customer CardId</th>
                <td class="col-sm-10">{{ $history->CustomerCardId }}</td>
            </tr>
            <tr>
                <th>BookId</th>
                <td>{{ $history->BookId }}</td>
            </tr>
            <tr>
                <th>Book Title</th>
                <td>{{ $history->BookTitle }}</td>
            </tr>
            <tr>
                <th>Rental Created At</th>
                <td>{{ $history->RentalCreatedAt }}</td>
            </tr>
            <tr>
                <th>Rental Expires At</th>
                <td>{{ $history->RentalExpiresAt }}</td>
            </tr>
            <tr>
                <th>Rental Returned At</th>
                <td>{{ $history->RentalReturnedAt }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection