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
    <table class="table table-bordered" id="js-customers-table"></table>
@endsection

@push('scripts')
<script>
    let table;
    let url;
    let jst = $("#js-customers-table")
    $(document).ready(function () {
        table = jst.DataTable({
            dom:'lrtip',
            serverSide: true,
            autoWidth: true,
            processing: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            ajax: {
                url: "{{ route('customer.table') }}",
                method: "POST",
                dataSrc: "data",
                @if(isset($renting) && $renting)
                data:function(d){
                    d.renting = true;
                }
                @endif
            },
            columns: [
                {
                    title:"Customer",
                    name: "Name",
                    render: function (_,_, customer) {
                        url = '{{ route('customer.show', ':id') }}'.replace(':id', customer.Id);
                        return `<a href='${url}' title='View This Customer'> ${customer.Name} </a>`;
                    }
                },
                {
                    title: "Rented Books",
                    name:"RentalsCount",
                    searchable: false,
                    orderable:true,
                    render: function (_, _, customer) {
                        if (customer.RentalsCount > 0) {
                            url = '{{ route('rentals.forcustomer', ':id') }}'.replace(':id', customer.Id);
                            return `<a href='${url}'>${customer.RentalsCount} Books<a/>`;
                        }
                        return "0";
                    }
                },
                {
                    title: "Card Id",
                    name:"CardId",
                    data: "CardId",
                    searchable: true,
                    orderable: false
                },
                {
                    title: "Actions",
                    data: "Id",
                    orderable: false,
                    searchable: false,
                    width: 1,
                    render: function (customerId) {
                        let actions="";
                        @if(isset($renting) && $renting)
                            url = '{{ route('rentals.create', ['copyId' => $copyId, 'customerId' => ':id']) }}'.replace(encodeURIComponent(':id'), customerId)
                            actions += `<a href="${url}" class="mx-1 btn btn-success"><i class="fa fa-check"></i> Choose</a>`;
                        @else
                            url = '{{ route('customer.edit', ':id') }}'.replace(':id', customerId);
                        actions += `<a href="${url}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>Edit</a>`;
                        actions += `<a href="#" data-customer-id='${customerId}' class='js-customer-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>Delete</a>`;
                        @endif
                            return `<span style="display:flex">${actions}</span>`;
                    }
                }
            ],
            order: [[1, "desc"]]
        });
        jst.on("click", ".js-customer-delete", function () {
            var button = $(this);
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
                                url: "{{ route('customer.destroy', ':id') }}".replace(':id', button.data("customer-id")),
                                method: "POST",
                                data:{
                                    _method:'DELETE'
                                },
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
                        className: 'btn-secondary'
                    }
                }
            });
            return false;
        });
        jst.append('<tfoot class="d-flex"></tfoot>');
        jst.find('thead th').each(function (index) {
            jst.find('tfoot').append(`<th></th>`);
        });
        jst.find('tfoot th').each(function (index) {
            if(index == 0 || index == 2)
            {
                $(this).html(`<input data-col-indx=${index} type="text" style="width: 100%" class="form-control d-flex px-1 mt-2" placeholder="Search " />`);
            }else{
                $(this).html(`<input data-col-indx=${index} hidden />`);
            }
        });
        $('input', 'tfoot th').on( 'keyup', function () {
            let col = table.columns($(this).data('col-indx'));
            if(col.search() !== $(this).val()) {
                col.search($(this).val()).draw();
            }
        } );
        // $("<tr role='row'></tr>").insertBefore(jst.find('thead tr'));
        // jst.find('thead tr th').each(function (index) {
        //     jst.find('thead tr:nth-child(1)').append(`<th></th>`);
        // });
        // jst.find('thead tr:nth-child(1) th').each(function (index) {
        //     if(index == 0 || index == 2)
        //     {
        //         $(this).html(`<input data-col-indx=${index} type="text" style="width: 100%" class="form-control d-flex px-1 mt-2" placeholder="Search " />`);
        //     }else{
        //         $(this).html(`<input data-col-indx=${index} hidden />`);
        //     }
        // });
    });
</script>
@endpush