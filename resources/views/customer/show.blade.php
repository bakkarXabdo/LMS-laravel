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
            @if(\Illuminate\Support\Facades\Cache::has("customer-password"))
                <tr style="background: rgb(212 189 107)">
                    <th>Password</th>
                    <td>
                        {{ \Illuminate\Support\Facades\Cache::pull("customer-password") }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <h4>Actions</h4>
        <hr>
        <div class="row" style="margin-left:0">
            <a class="btn btn-primary" href="{{ route('customer.edit', $Id) }}">Edit</a>
            <a class="btn btn-primary" href="{{ route('rentals.create', ["customerId" => $Id]) }}">Rent</a>
            @if(!\Illuminate\Support\Facades\Cache::has("customer-password"))
                <form style="display: inline-block;" method="post" action="{{ route('customer.changePassword', $Id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            @endif
            <a id="delete-customer" href="#" class="btn btn-danger">Delete</a>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $("#delete-customer").on("click",  function () {
            var button = $(this);
            bootbox.dialog({
                title: "Confirm Your Action",
                message: `<span>Delete Customer <strong>{{ $Name }}</strong> ?</span>`,
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('customer.destroy', $Id) }}',
                                data:{
                                    _method: "DELETE"
                                },
                                method: "POST",
                                dataType:"json",
                                success: function (data) {
                                    if (data.success) {
                                        toastr.success(data.message);
                                        location.href = document.referrer;
                                    } else {
                                        toastr.error(data.message);
                                    }
                                }
                            })
                        }
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-secondary',
                    }
                }
            });
            return false;
        });
    </script>
@endpush