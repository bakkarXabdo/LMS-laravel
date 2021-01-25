@extends('layouts.master')

@section('PageTitle') New Rental @endsection


@section('content')
    <h2>New Rental</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <hr />
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h4>Book Copy</h4>
            </div>
            <div class="col-sm-6">
                <h4>Customer</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                @if($copy != null)
                    <table class="table table-condensed">
                        <tr>
                            <th>Copy Id</th>
                            <td>{{ $copy->Id }}</td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td style="font-size: large; font-weight: bold">{{ $copy->book->Title }}</td>
                        </tr>
                    </table>
                @endif
            </div>
            <div class="col-sm-6">
                @if ($customer != null)
                <table class="table table-condensed">
                    <tr>
                        <th>Card Id</th>
                        <td>{{ $customer->CardId }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td style="font-size: large; font-weight: bold">{{ $customer->Name }}</td>
                    </tr>
                </table>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <a class="btn btn-primary my-2" href="{{ route('books.choose', ["customerId" => isset($customer) ? $customer->Id : 'false']) }}">{{ isset($copy) ? "Change" : "Choose" }}</a>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary my-2" href="{{ route('customer.choose', ["copyId" => isset($copy) ? $copy->Id : 'false']) }}">{{ isset($customer) ? "Change" : "Choose" }}</a>
            </div>
        </div>
    </div>
    <hr />
    @if ($copy != null && $customer != null)
        <h4>Copy Location</h4>
        <table class="table table-responsive table-bordered">
            <tr class="d-flex">
                <th class="col-sm-2">Shelf</th>
                <td class="col-sm-10">{{ $copy->inventory->Shelf }}</td>
            </tr>
            <tr>
                <th>Column</th>
                <td>{{ $copy->inventory->Column }}</td>
            </tr>
            <tr>
                <th>Row</th>
                <td>{{ $copy->inventory->Row }}</td>
            </tr>
        </table>
        <form method="post" action="{{ route('rentals.store') }}">
            @csrf
            <div class="form-group">
                <label class="h4">Rental Duration (Days)</label>
                <input value="15" type="number" min="1" class="form-control" name="duration" />
            </div>
            <input name="copyId" value="{{ $copy->Id }}" hidden />
            <input name="customerId" value="{{ $customer->Id }}" hidden />
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirm</button>
        </form>
    @endif
@endsection