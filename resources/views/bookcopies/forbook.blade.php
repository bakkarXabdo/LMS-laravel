@extends('layouts.master')

@section('PageTitle') Copies of {{ $book->Title }} @endsection

@section('content')
    <h3>Available Copies of book <a href="{{ route('books.show', $book->getKey()) }}">{{ $book->Title }}</a></h3>
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-2 pl-0">
                <a href="{{ route('bookcopies.create', $book->getKey()) }}" class="btn btn-primary">Add Copy</a>
            </div>
        </div>
    </div>
    <style>
        #js-copies-table tfoot tr {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
    <table class="table table-bordered" id="js-copies-table"></table>
@endsection

@push('scripts')
<script>
    let table;
    $(document).ready(function () {
        table = $("#js-copies-table").DataTable({
            serverSide: true,
            autoWidth: true,
            processing: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><div class="text-black-50">Loading...</div> '
            },
            ajax: {
                url: "{{ route('bookcopies.forbooktable', $book->Id) }}",
                method: "POST",
                dataSrc: "data",
                "data": function (d) {
                    d.bookId = '{{ $book->Id }}';
                }
            },
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            columns: [
                {

                    title: "Location - Shelf",
                    name: "Shelf",
                    data: "Shelf",
                    searchable: false,
                    orderable: false
                },
                {
                    title: "Location - Column",
                    name: "Column",
                    data: "Column",
                    searchable: false,
                    orderable: false
                },
                {
                    title: "Location - Row",
                    name: "Row",
                    data: "Row",
                    searchable:false,
                    orderable: false
                },
                {
                    title: "Rented",
                    name: "Rented",
                    data: "Rented",
                    searchable: false,
                    render: function (rented, _, copy) {
                        if (rented) {
                            let url = '{{ route('rentals.forcopy', ':id') }}'.replace(':id', copy.Id);
                            return `<a title="View rental: ${"Customer#" + copy.Customer.CardId + "(" + copy.Customer.Name + ")"}" href="${url}">Rented</a>`;
                        }
                        return "No";
                    }
                },
                {
                    title: "Actions",
                    data: "Id",
                    orderable: false,
                    searchable: false,
                    width:1,
                    render: function (copyId,_,copy) {
                        var edit = remove = rent = choose = "";
                        let url = "";
                        @if($renting)
                            if (!copy.Rented)
                            {
                                url = '{{ route('rentals.create',["customerId" => $customerId, "copyId" => ":id"]) }}'.replace(encodeURIComponent(':id'), copy.Id);
                                choose = `<a href="${url}" class='mx-1 btn btn-success'><i class="fa fa-check"></i> Choose</a>`;
                            } else {
                                url = '{{ route('rentals.forcopy', ':id') }}'.replace(':id', copy.Id);
                                choose = `<a href="${url}" class='mx-1 btn btn-primary'>Rental Details</a>`;
                            }
                        @else
                            url = '{{ route('bookcopies.edit', ':id') }}'.replace(':id', copy.Id);
                            edit = `<a href="${url}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>Edit</a>`;
                            remove = `<a href="#" data-copy-id='${copyId}' class='js-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>Delete</a>`;
                            if(!copy.Rented)
                            {
                                url = '{{ route('rentals.create',["customer" => $customerId, "copy" => ":id"]) }}'.replace(encodeURIComponent(':id'), copy.Id);
                                rent = `<a href="${url}" class='mx-1 btn btn-primary'>Rent</a>`;
                            }
                        @endif
                        return `<span style="display:flex;">${rent+edit+remove+choose}</span>`;
                    }
                }
            ],
            order:[[3, "asc"]]
        });
        $("#js-copies-table").on("click", ".js-delete", function () {
            var button = $(this);
            bootbox.dialog({
                title: "Confirm Your Action",
                message: '<span>Delete Book Copy?</span>',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('bookcopies.destroy', ':id') }}'.replace(':id', button.data("copy-id")) ,
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