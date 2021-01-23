@extends('layouts.master')

@section('PageTitle') Inventory @endsection

@section('content')
    <h3>Library Inventory</h3>
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-2 pl-0">
                <a href="{{ route('inventory.create') }}" class="btn btn-primary">Add Inventory</a>
            </div>
        </div>
    </div>
    <style>
        #js-inventory-table tfoot tr {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
    <table class="table table-bordered" id="js-inventory-table"></table>
@endsection

@push('scripts')
    <script>
        let table;
        let jst = $("#js-inventory-table");
        let url;
        $(document).ready(function () {
            table = jst.DataTable({
                dom:'lrtip',
                serverSide: true,
                autoWidth: true,
                processing: true,
                search:false,
                searchable:false,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><div class="sr-only">Loading...</div> ',
                    searchPlaceholder: "Shelf/Column/Row",
                    emptyTable: `No data. Make sure you use the pattern '<span class="text-success" style="font-weight:bold">Shelf/Column/Row</span>' for searching ex: 1/5/6`
                },
                ajax: {
                    url: "/inventory/table",
                    method: "POST"
                },
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                columns: [
                    {
                        title: "Location - Shelf",
                        name: "Shelf",
                        data: "Shelf",
                        searchable: true
                    },
                    {
                        title: "Location - Column",
                        name: "Column",
                        data: "Column",
                        searchable: true
                    },
                    {
                        title: "Location - Row",
                        name: "Row",
                        data: "Row",
                        searchable:true
                    },
                    {
                        title: "Size",
                        name: "Size",
                        data: "Size",
                        searchable: false,
                        render: (size) => size + " Copies"
                    },
                    {
                        title: "Stored Copies",
                        name: "Copies",
                        data: "Copies",
                        searchable: false,
                        render: function (Stored, _, inventory) {
                            url = '{{ route('bookcopies.forinventory', ':id') }}'.replace(':id', inventory.Id);
                            if (Stored == 1) {
                                return `<a title="View" href="${url}">1 <span class="v-only">Copy</span></a>`;
                            } else if (Stored <= 0) {
                                return "<span class='v-only'>No Copies</span><span class='p-only'>0</span>";
                            } else {
                                return `<a title="View" href="${url}">${Stored} <span class='v-only'>Copies</span></a>`;
                            }
                        }
                    },
                    {
                        title: "Actions",
                        data: "Id",
                        orderable: false,
                        searchable: false,
                        width:1,
                        render: function (Id) {
                            url = '{{ route('inventory.show', ':id') }}'.replace(':id', Id);
                            return `<a href="${url}" class="mx-1 btn btn-primary">View</a>`;
                        }
                    }
                ],
                order:[[4, "asc"]],
            });
            jst.append('<tfoot class="d-flex"></tfoot>');
            jst.find('thead th').each(function (index) {
                if(index < 3) {
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