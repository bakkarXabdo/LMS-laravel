@extends('layouts.master')

@section('PageTitle') Copies of {{ $copy->book->Title }} @endsection

@section('content')
    <h2>Copy Details</h2>
    <table class="table table-responsive table-bordered">
        <tbody><tr class="d-flex">
            <th class="col-sm-2">Book</th>
            <td class="col-sm-10">
                <a href="{{ route('books.show', $copy->book->getKey()) }}">{{ $copy->book->Title }}</a>
            </td>
        </tr>
        <tr>
            <th>Inventory</th>
            <td><a href="{{ route('inventory.show', $copy->inventory->getKey()) }}">{{ $copy->inventory->notation }}</a></td>
        </tr>
        <tr>
            <th>Rented</th>
            <td>
                @if($copy->rental)
                    <a title="view rental" href="{{ route('rentals.show', $copy->rental->getKey()) }}">Rented</a> To Customer <a title="view customer" href="{{ route('customer.show', $copy->rental->customer->getKey()) }}">{{ $copy->rental->customer->CardId }} ({{ $copy->rental->customer->Name }})</a>
                @else
                    No
                @endif
            </td>
        </tr>
        </tbody></table>
    <h4>Actions</h4>
    <hr>
    <div class="row" style="margin-left:0">
        <a class="btn btn-primary" href="{{ route('bookcopies.edit', $Id) }}">Edit</a>
        @if(!$copy->rental)
            <a class="btn btn-primary" href="{{ route('rentals.create', ["copyId" => $Id]) }}">Rent</a>
            <a class="btn btn-danger" id="copy-delete" href="#">Delete</a>
        @else
            <form style="display: inline-block" action="{{ route('rentals.return', $copy->rental->getKey()) }}" method="post">
                @csrf
                <button style="display: inline-block" class="btn btn-warning" type="submit">Put Back</button>
            </form>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $("#copy-delete").on("click",  function () {
            bootbox.dialog({
                title: "Confirm Your Action",
                message: 'Delete Book Copy #{{ $Id }}?',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('bookcopies.destroy', $Id) }}',
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
                        className: 'btn-secondary'
                    }
                }
            });
            return false;
        });
    </script>
@endpush