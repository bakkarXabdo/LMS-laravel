@extends('layouts.master')

@section('PageTitle') Copies of {{ $book->Title }} @endsection

@section('content')
    <h2>Copy Details</h2>
    <table class="table table-responsive table-bordered">
        <tbody><tr class="d-flex">
            <th class="col-sm-2">Title</th>
            <td class="col-sm-10">
                <a href="{{ route('books.show', $copy->book->getKey()) }}"></a>
            </td>
        </tr>
        <tr>
            <th>Shelf</th>
            <td>{{ $copy->inventory->Shelf }}</td>
        </tr>
        <tr>
            <th>Column</th>
            <td>{{ $copy->inventory->Column }}</td>
        </tr>
        <tr>
            <th>Row</th>
            <td>{{ $copy->inventory->Row }}</td>
        </tr>
        <tr>
            <th>Rented</th>
            <td>
                @if($copy->rental)
                    <a title="Customer#{{ $copy->rental->customer->CardId }} ({{ $copy->rental->customer->Name }})" href="{{ route('rentals.show', $copy->rental->getKey()) }}">Rented</a>
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
    <a class="btn btn-primary" href="{{ route('rentals.create', ["copyId" => $Id]) }}">Rent</a>
    <a class="btn btn-danger" href="{{ route('bookcopies.destroy') }}">Delete</a></div>
@endsection

@push('scripts')
    <script>
        $("#delete-book").on("click",  function () {
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