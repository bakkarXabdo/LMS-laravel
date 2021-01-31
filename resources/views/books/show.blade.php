@extends('layouts.master')

@section('PageTitle') {{ $Title }} @endsection

@section('content')

    <br /><br />
    <h4>Book Details</h4>
    <table class="table table-responsive table-bordered">
        <tr class="d-flex">
            <th class="col-sm-2">Title</th>
            <td>{{ $Title }}</td>
        </tr>
        <tr>
            <th>Authors</th>
            <td>{{ $book->Authors }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $book->category->Name }}</td>
        </tr>
        <tr>
            <th>Language</th>
            <td>{{ $book->language->Name }}</td>
        </tr>
        <tr>
            <th>Release Year</th>
            <td>{{ $ReleaseYear }}</td>
        </tr>
        <tr>
            <th>Date Added</th>
            <td>{{\Illuminate\Support\Carbon::parse($DateAdded)->format('d-m-Y H:i:s') }}</td>
        </tr>

        <tr>
            <th>Library Stock</th>
            <td>
                @if ($NumberInStock == 0)
                    <span class="text-danger">No Copies!</span>
                @else
                    <a href="{{ route('bookcopies.index', ["bookId" => $Id]) }}">
                        {{ $NumberInStock }} {{ $NumberInStock > 1 ? "Copies" : "Copy" }}
                    </a>
                @endif
            </td>
        </tr>
        <tr>
            <th>Rented Copies</th>
            <td>
                @if ($RentalsCount > 0)
                    <a href="{{ route('rentals.forbook', $Id) }}">{{ $RentalsCount }} {{ $RentalsCount > 1 ? "Copies" : "Copy"}}</a>
                @else
                    None
                @endif
            </td>
        </tr>
        <tr>
            <th>Available</th>
            <td>
                @if ($NumberInStock == 0)
                    <span class="text-danger">No Copies!</span>
                @elseif($NumberAvailable > 0)
                    {{ $NumberAvailable }}
                @else
                    <span class="text-danger">Out Of Stock!</span>
                @endif
            </td>
        </tr>
    </table>
    <h4>Actions</h4>
    <hr />
    <div class="row" style="margin-left:0">
        @php
            $url = route('bookcopies.choose', ['bookId' => $Id]);
        @endphp
        @if ($NumberAvailable > 0)
            @if($NumberAvailable == 1)
                @php
                    $copies = App\Models\BookCopy::query()->select(['bookcopies.Id'])->join('rentals', 'rentals.BookCopyId', 'bookcopies.Id')->where('bookcopies.BookId', $book->getKey())->get();
                    $copy = App\Models\BookCopy::query()->whereNotIn('bookcopies.Id', $copies)->where('bookcopies.BookId', $book->getKey())->first();
                    $url = route('rentals.create', ['copyId' => $copy->getKey()]);
                @endphp
            @endif
            <a href="{{ $url }}" class="btn btn-primary">Rent</a>
        @endif
        <a href="{{ route('bookcopies.create', $Id) }}" class="btn btn-{{ $NumberAvailable > 0 ? "primary" : "success" }}">Add Copy</a>
        <a href="{{ route('books.edit', $Id) }}" class="btn btn-primary">Edit</a>
        <a href="#" id="delete-book" class="btn btn-danger">Delete</a>
    </div>
    <br />
    <a href="{{ route('books.index') }}">Back To List</a>

@endsection

@push('scripts')
    <script>
        $("#delete-book").on("click",  function () {
            var button = $(this);
            bootbox.dialog({
                title: "Confirm Your Action",
                message: `
                        @if($NumberInStock > 1)
                            <span>This Book Has <a href="{{ route('bookcopies.index', ["bookId" => $Id]) }}">{{ $NumberInStock }} Copies</a>, Are you sure You want To Delete Them All?</span>
                        @else
                            <span>Delete <strong>{{ $Title }}</strong> ?</span>
                        @endif`,
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('books.destroy', $Id) }}',
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
                        callback: function () {
                            console.log("Operation Cancelled");
                        }
                    }

                },
                onEscape: function () {
                    console.log("Operation Escaped");
                }
            });
            return false;
        });
    </script>
@endpush