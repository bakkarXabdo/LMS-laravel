@extends('layouts.master')



@section('PageTitle') Rentals @endsection



@section('content')
    @if ($book != null)
        <h3>Rentals for Book {{ $book->Title }} (#<a href="{{ route('books.show', $book->getKey()) }}">{{ $book->getKey() }}</a>)</h3>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-2 pl-0">
                    <a class="btn btn-primary" href="{{ route('bookcopies.choose', ["bookId" => $book->getKey()]) }}">New Rental</a>
                </div>
            </div>
        </div>
    @elseif($customer != null)
        <h3>Rentals for Customer {{ $customer->Name }} (#<a href="{{ route('customer.show', $customer->getKey()) }}">{{ $customer->CardId }}</a>)</h3>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-2 pl-0">
                    <a class="btn btn-primary" href="{{ route('rentals.create', ["customerId" => $customer->getKey()]) }}">New Rental</a>
                </div>
            </div>
        </div>
    @else
        <h3>Rentals</h3>
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-2 pl-0">
                    <a class="btn btn-primary" href="{{ route('rentals.create') }}">New Rental</a>
                </div>
            </div>
        </div>
    @endif
    <table class="table table-bordered" id="js-rental-table"></table>
@endsection



@push('scripts')
    <script>
        let table;
        let url;
        let jst = $("#js-rental-table");
        $(document).ready(function () {
             table = jst.DataTable({
                dom:'lrtip',
                serverSide: true,
                autoWidth: true,
                processing: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                ajax: {
                    url: "{{ route('rentals.table') }}",
                    method: "POST",
                    dataSrc: "data",
                    "data": function (d) {
                        @if($book != null)
                            d.bookId = '{{ $book->getKey() }}';
                        @endif
                        @if($customer != null)
                            d.customerId = '{{ $customer->getKey() }}';
                        @endif
                    }
                },
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                columns: [
                    {
                        title: "Customer Card-Id",
                        name: "customers.CardId",
                        orderable:false,
                        searchable:true,
                        render: function(_,_,rental){
                            url = '{{ route('customer.show', ':id') }}'.replace(':id', rental.customer.Id);
                            return `<a title="${rental.customer.Name}" href="${url}">${rental.customer.CardId}</a`;
                        }
                    },
                    {
                        title: "Book Copy",
                        name: "books.Title",
                        searchable:true,
                        orderable: true,
                        render:function(_,__,rental){
                            url = '{{ route('bookcopies.show', ':id') }}'.replace(':id', rental.BookCopyId);
                            return `<a title="View copy" href="${url}">${rental.book.Title}</a>`;
                        }
                    },
                    {
                        title: "Rental Created",
                        name: "CreatedAt",
                        data: "CreatedAt",
                        orderable:true,
                    },
                    {
                        title: "Expires",
                        name: "RemainingDays",
                        data: "RemainingDays",
                        searchable: false,
                        orderable: true,
                        render: (days) => days <= 0 ? `<span class="text-danger">Expired before ${days} Days</span>` : `<span>After ${days} Days</span>`
                    },
                    {
                        title: "Actions",
                        orderable: false,
                        searchable: false,
                        data:"Id",
                        width:1,
                        render: function (rentalId,_,rental) {
                            var actions = "";
                            actions += `<a href="#" data-rental-id="${rentalId}" data-bookcopy-id="${rental.BookCopyId}" class="js-confirm mx-1 btn btn-primary">Put Back</a>`;
                            return `<span style="display:flex;">${actions}</span>`;
                        }
                    }
                ],
                order:[[3, "asc"]]
            });
            jst.on("click", ".js-confirm", function () {
                var button = $(this);
                bootbox.dialog({
                    title: "Confirm Your Action",
                    message: '<span>Mark Book Copy #' + button.data("bookcopy-id") + ' As Returned</span>',
                    backdrop:true,
                    buttons: {
                        confirm: {
                            label: 'Put Back',
                            className: 'btn-warning',
                            callback: function () {
                                $.ajax({
                                    url: "{{ route('rentals.return', ':id') }}".replace(':id', button.data("rental-id")),
                                    method: "POST",
                                    success: function (data) {
                                        if (data.success) {
                                            table.row(button.parents('tr')).remove().draw();
                                            toastr.success(data.message);
                                        } else {
                                            toastr.error(data.error);
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
            jst.append('<tfoot class="d-flex"></tfoot>');
            jst.find('thead th').each(function (index) {
                if(index < 2) {
                    jst.find('tfoot').append(`<th></th>`);
                }
            });
            jst.find('tfoot th').each(function (index) {
                $(this).html(`<input data-col-indx=${index} type="text" style="width: 100%" class="form-control d-flex px-1 mt-2" placeholder="Search " />`);
            });
            $('input', 'tfoot th').on( 'keyup', function () {
                table.columns($(this).data('col-indx')).search($(this).val()).draw();
            } );
        });
    </script>
@endpush
