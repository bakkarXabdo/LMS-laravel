@extends('layouts.master')

@section('PageTitle') Books @endsection

@section('content')
<h3>Available Books</h3>
<div class="container">
    <div class="row mb-2">
        <div class="col-sm-2 pl-0">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
        </div>
    </div>
</div>
<style>
    #js-books-table tfoot tr {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<table class="table table-bordered" id="js-books-table"></table>
@endsection

@push('scripts')
<script>
    let table;
    $(document).ready(function () {
         table = $("#js-books-table").DataTable({
            serverSide: true,
            autoWidth: true,
            processing: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><div class="text-black-50">Loading...</div> '
            },
            ajax: {
                url: "{{ route('books.table') }}",
                method: "POST",
                dataSrc: "data"
            },
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            columns: [
                {
                    title: "Title",
                    name:"Title",
                    orderSequence: [ "desc", "asc" ],
                    render: function (_, _, book) {
                        let url = '{{ route('books.show', ':Id') }}'.replace(':Id', book.Id);
                        return `<a href='${url}' title='#${book.Id}'> ${book.Title} </a>`;
                    }
                },
                {
                    title: "Category",
                    data: "Category.Name",
                    searchable: false,
                    orderable:false
                },
                {
                    title: "Stock",
                    name:"NumberInStock",
                    data: "NumberInStock",
                    orderSequence: [ "desc", "asc" ],
                    searchable: false,
                    render: function (_, _, book) {
                        if (book.NumberInStock > 0) {
                            let url = '{{ route('bookcopies.forbook', ':Id') }}'.replace(':Id', book.Id);
                            return `<a title="view Copies" href="${url}">${book.NumberInStock} ${book.NumberInStock > 1 ? " Copies" : " Copy"}</a>`;
                        }else return `<span class="text-danger">No Stock!</span>`;
                    }
                },
                {
                    title: "Rented",
                    name: "RentalsCount",
                    data: "RentalsCount",
                    orderSequence: [ "desc", "asc" ],
                    searchable: false,
                    render: function (_, _, book) {
                        if (book.RentalsCount > 0) {
                            let url = '{{ route('rentals.forbook', ':Id') }}'.replace(':Id', book.Id);
                            return `<a title="View Rented Books" href="${url}">${book.RentalsCount} <span class="v-only">${book.RentalsCount > 1 ? " Copies" : " Copy"}</span></a>`;
                        } else return 0;
                    }
                },
                {
                    title: "Available",
                    name:"NumberAvailable",
                    data: "NumberAvailable",
                    orderSequence: [ "desc", "asc" ],
                    searchable: false,
                    render: function (_, _, book) {
                        if (book.NumberAvailable > 0) {
                            let url = '{{ route('bookcopies.forbook', ':Id') }}'.replace(':Id', book.Id);
                            return `<a title="View Rented Books" href="${url}">${book.NumberAvailable} <span class="v-only">${book.NumberAvailable > 1 ? " Copies" : " Copy"}</span></a>`;
                        } else if (book.NumberInStock > 0)
                            return `<span class="text-danger v-only">Out of Stock!</span><span class="p-only">0</span>`;
                        else
                            return `<span class="text-danger v-only">No Stock!</span><span class="p-only">0</span>`;
                    }
                },
                {
                    title: "Actions",
                    data: "id",
                    orderable: false,
                    width: 1,
                    search:true,
                    print:false,
                    render: function (_,_,book) {
                        var edit = remove = choose = url = "";
                        @if (!isset($choosing))
                            url = '{{ route('books.edit', ':id') }}'.replace(':id', book.Id);
                            edit = `<a href="${url}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>Edit</a>`;
                            remove = `<a href="#" data-book-id='${book.Id}' class='js-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>Delete</a>`;
                        @else
                            url = '{{ route('bookcopies.choose', ['bookId'=>':id', 'customerId'=>$customerId]) }}'.replace( encodeURIComponent(':id'), book.Id);
                            if(book.NumberAvailable > 0)
                                choose = `<a href="${url}" class="mx-1 btn btn-success"><i class="fa fa-check"></i> Choose</a>`;
                        @endif
                        return `<span style="display:flex">${edit + remove + choose}</span>`;
                    }
                }
            ]
        });

        $("#js-books-table").on("click", ".js-delete", function () {
            var button = $(this);
            bootbox.dialog({
                title: "Confirm Your Action",
                message: '<span>Delete <strong>" ' + button.parents('tr').children().first().find("a").text() + '"</strong> ?</span>',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('books.destroy', ':id') }}'.replace(':id', button.data("book-id")) ,
                                method: "POST",
                                data:{
                                    _method: "DELETE"
                                },
                                dataType:"json",
                                success: function (data) {
                                    if (data.success) {
                                        table.row(button.parents('tr')).remove().draw();
                                        toastr.success(data.message);
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
    });
</script>
@endpush