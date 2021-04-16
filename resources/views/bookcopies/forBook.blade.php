@extends('layouts.master')

@section('PageTitle')
    {{ " " . $book->Title . " "}}نسخ الكتاب
@endsection

@section('content')
    <div class="container" dir="rtl">
        <h3> نسخ الكتاب  <a href="{{ route('books.show', $book->getKey()) }}">{{ $book->Title }}</a></h3>
        <a href="{{ route('bookcopies.create', $book->getKey()) }}" class="btn btn-primary">إضافة نسخة</a>
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
            ajax: {
                url: "{{ route('bookcopies.table', ["bookId" => $book->getKey()]) }}",
                method: "POST",
                dataSrc: "data",
                "data": function (d) {
                    d.bookId = '{{ $book->{\App\Models\Book::KEY} }}';
                }
            },
            columns: [
                {
                    title: "الشفرة",
                    name: "{{ \App\Models\BookCopy::KEY }}",
                    searchable: true,
                    orderable: true,
                    render:function(_,_,copy){
                        let url = '{{ route('bookcopies.show', ":id") }}'.replace(':id', copy.{{ \App\Models\BookCopy::KEY }});
                        return `<a title="إظهار النسخة" href='${url}'>${copy.{{ \App\Models\BookCopy::KEY }}}</a>`
                    }
                },
                {

                    title: "رقم الجرد",
                    name: "InventoryId",
                    data: "InventoryId",
                    searchable: true,
                    orderable: true
                },
                {
                    title: "مُعار",
                    name: "Rented",
                    data: "Rented",
                    searchable: false,
                    orderable: true,
                    render: function (rented, _, copy) {
                        if (rented) {
                            let url = '{{ route('rentals.show', ':id') }}'.replace(':id', copy.RentalId);
                            return `<a title="View rental: ${"الطالب#" + copy.Student.{{ \App\Models\Student::KEY }} + "(" + copy.Student.Name + ")"}" href="${url}">نعم</a>`;
                        }
                        return "لا";
                    }
                },
                {
                    title: "العمليات",
                    data: "{{ \App\Models\BookCopy::KEY }}",
                    orderable: false,
                    searchable: false,
                    width:1,
                    render: function (copyId,_,copy) {
                        var edit = remove = rent = choose = "";
                        let url = '{{ route('bookcopies.edit', ':id') }}'.replace(':id', copy.Id);
                        edit = `<a href="${url}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>تعديل</a>`;
                        if(!copy.Rented)
                        {
                            remove = `<a href="#" data-copy-id='${copyId}' class='js-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>حذف</a>`;
                            url = '{{ route('rentals.create',[BookCopy::FOREIGN_KEY => ":id"]) }}'.replace(encodeURIComponent(':id'), copy.Id);
                            rent = `<a href="${url}" class='mx-1 btn btn-primary'>إعارة</a>`;
                        }
                        return `<span style="display:flex;">${rent+edit+remove+choose}</span>`;
                    }
                },
            ],
        });
        $("#js-copies-table").on("click", ".js-delete", function () {
            var button = $(this);
            bootbox.dialog({
                title: "Confirm Your Action",
                message: '<span>حذف النسخة؟</span>',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'حذف',
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
                                },

                            })
                        }
                    },
                    cancel: {
                        label: 'إلغاء',
                        className: 'btn-secondary',
                        callback: function () {
                            console.log("Operation Cancelled");
                        }
                    }

                }
            });
            return false;
        });
    });
</script>
@endpush
