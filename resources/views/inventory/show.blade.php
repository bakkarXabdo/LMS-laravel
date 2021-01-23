@extends('layouts.master')
@section('PageTitle') Inventory Details @endsection

@section('content')
    <h3>Inventory Details</h3>
    <table class="table table-responsive table-bordered">
        <tr>
            <th class="col-sm-2">Shelf</th>
            <td class="col-sm-10">{{ $Shelf }}</td>
        </tr>
        <tr>
            <th>Column</th>
            <td>{{ $Column }}</td>
        </tr>
        <tr>
            <th>Row</th>
            <td>{{ $Row }}</td>
        </tr>
        <tr>
            <th>Size</th>
            <td>{{ $Size }}</td>
        </tr>
        <tr>
            <th>Stored Copies</th>
            <td>
                @if ($Copies == 0)
                    0 Copies
                @else
                    <a href="{{ route('bookcopies.forinventory', $Id) }}">{{ $Copies }} {{ $Copies > 1 ? "Copies" : "Copy"}}</a>
                @endif
            </td>
        </tr>
    </table>
    <h4>Actions</h4>
    <hr />
    <div class="row" style="margin-left:0">
            <a class="btn btn-primary" href="{{ route('inventory.edit', $Id) }}">Edit</a>
            <a class="btn btn-danger" id="js-delete" href="#">Delete</a>
    </div>
@endsection
@push('scripts')
    <script>
        $("#js-delete").on("click",  function () {
            var button = $(this);
            @if($Copies > 0)
            bootbox.dialog({
                title: "Error",
                message:
                    `<span>This Inventory Has <a href="{{ route('bookcopies.forinventory', $Id) }}">{{ $Copies }} {{ $Copies > 1 ? "Copies" : "Copy" }} </a>, Yout must empty it first</span>`,
                backdrop:true,
                buttons: {
                    cancel: {
                        label: 'Close',
                        className: 'btn btn-primary',
                        callback: function () {
                            console.log("Operation Cancelled");
                        }
                    }
                },
                onEscape: function () {
                    console.log("Operation Escaped");
                }
            });
            @else
                bootbox.dialog({
                    title: "Confirm Your Action",
                    message: `Remove Inventory ({{ $Shelf."/".$Column."/".$Row }}) ?`,
                    backdrop:true,
                    buttons: {
                        confirm: {
                            label: 'Delete',
                            className: 'btn-danger',
                            callback: function () {
                                $.ajax({
                                    url: '{{ route('inventory.destroy', $Id) }}',
                                    data:{
                                        _method: "DELETE"
                                    },
                                    method: "POST",
                                    dataType:"json",
                                    success: function (data) {
                                        if (data.success) {
                                            toastr.success(data.message);
                                            window.location.href = '{{ route('books.index') }}';
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
            @endif
            return false;
        });
    </script>
@endpush