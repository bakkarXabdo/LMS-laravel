@extends('layouts.master')

@section('PageTitle') Customers @endsection


@section('content')
    <h3>Customers List</h3>
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-2 pl-0">
                <a href="{{ route('customer.create') }}" class="btn btn-primary">Add Customer</a>
            </div>
        </div>
    </div>
    <table class="table table-bordered" id="js-books-table"></table>
@endsection
{{-- 
@push('scripts')
<script>
    $(document).ready(function () {
        var table = $("#js-customers-table").DataTable({
            serverSide: true,
            autoWidth: true,
            processing: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            ajax: {
                url: "/customers/table",
                method: "POST",
                dataSrc: "data"
            },
            columns: [
                {
                    title:"Customer",
                    name: "Name",
                    render: function (i, i, customer) {
                        return `<a href='/customers/details/${customer.id}' title='View This Customer'> ${customer.name} </a>`;
                    }
                },
                {
                    title: "Rented Books",
                    name:"RentalsCount",
                    searchable: false,
                    render: function (_, _, customer) {
                        if (customer.rentalsCount > 0) {
                            return `<a href='/rentals/ForCustomer/${customer.id}'>${customer.rentalsCount} Books<a/>`;
                        }
                        return "0";
                    }
                },
                {
                    title: "Card Id",
                    name:"CardId",
                    data: "cardId",
                    searchable: true,
                    orderable: false
                },
                {
                    title: "Actions",
                    data: "id",
                    orderable: false,
                    searchable: false,
                    width: 1,
                    render: function (customerId) {
                        var actions="";
                        @if(Model != null) {
                            <text>actions += `<a href="/rentals/new?customerId=${customerId}&bookId=@Model.BookId&copyId=@Model.CopyId" class="mx-1 btn btn-success"><i class="fa fa-check"></i> Choose</a>`</text>
                        }
                        else
                        {
                            if (User.IsInRole(LMS.Models.Role.CanAddCustomers))
                            {
                                <text>actions += `<a href="/customers/edit/${customerId}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>Edit</a>`</text>
                            }
                            if (User.IsInRole(LMS.Models.Role.CanDeleteCustomers))
                            {
                                <text>actions += `<a href="#" data-customer-id='${customerId}' class='js-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>Delete</a>`</text>
                            }
                        }
                        return `<span style="display:flex">${actions}</span>`;
                    }
                }
            ],
            order: [[1, "desc"]]
        });
        $("#js-customers-table").on("click", ".js-delete", function () {
            var button = $(this);
            @*bootbox.confirm("Delete " + button.parents('tr').children().first().find("a").text() + " ?", function (result) {
                if (result) {
                    $.ajax({
                        url: "/api/book/" + button.data("book-id"),
                        method: "DELETE",
                        success: function () {
                            table.row(button.parents('tr')).remove().draw();
                        }
                    })
                }
                return false;
            });*@
            bootbox.dialog({
                title: "Confirm Your Action",
                message: '<span>Delete Customer <strong>" ' + button.parents('tr').children().first().find("a").text() + '"</strong> ?</span>',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: "/customers/delete/" + button.data("customer-id"),
                                method: "POST",
                                dataType: "json",
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
                        className: 'btn-secondary',
                        callback: function () {
                            console.log("you piece of shit, why");
                        }
                    }
                },
                onEscape: function () {
                    console.log("test 123");
                }
            });
            return false;
        });
    });
</script>
@endpush --}}