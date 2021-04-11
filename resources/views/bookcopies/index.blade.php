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
            serverSide: true,
            autoWidth: true,
            processing: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><div class="text-black-50">تحميل...</div> '
            },
            ajax: {
                url: "{{ route('bookcopies.table', ["bookId" => $book->getKey()]) }}",
                method: "POST",
                dataSrc: "data",
                "data": function (d) {
                    d.bookId = '{{ $book->{\App\Models\Book::KEY} }}';
                }
            },
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            columns: [
                {
                    title: "الشفرة",
                    name: "{{ \App\Models\BookCopy::KEY }}",
                    searchable: false,
                    orderable: false,
                    render:function(_,_,copy){
                        let url = '{{ route('bookcopies.show', ":id") }}'.replace(':id', encodeURIComponent(copy.{{ \App\Models\BookCopy::KEY }}));
                        console.log(url);
                        return `<a title="إظهار النسخة" href='${url}'>${copy.{{ \App\Models\BookCopy::KEY }}}</a>`
                    }
                },
                {

                    title: "رقم الجرد",
                    name: "InventoryId",
                    data: "InventoryId",
                    searchable: false,
                    orderable: false
                },
                {
                    title: "مُعار",
                    name: "Rented",
                    data: "Rented",
                    searchable: false,
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
                        let url = "";
                        @if($renting)
                            if (!copy.Rented)
                            {
                                url = '{{ route('rentals.create',[Student::FOREIGN_KEY => $studentId, BookCopy::FOREIGN_KEY => ":id"]) }}'.replace(encodeURIComponent(':id'), copy.Id);
                                choose = `<a href="${url}" class='mx-1 btn btn-success'><i class="fa fa-check"></i> إختيار</a>`;
                            } else {
                                url = '{{ route('rentals.show', ':id') }}'.replace(':id', copy.RentalId);
                                choose = `<a href="${url}" class='mx-1 btn btn-primary'>تفاصيل الإعارة</a>`;
                            }
                        @else
                            url = '{{ route('bookcopies.edit', ':id') }}'.replace(':id', copy.Id);
                            edit = `<a href="${url}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>تعديل</a>`;
                            if(!copy.Rented)
                            {
                                remove = `<a href="#" data-copy-id='${copyId}' class='js-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>حذف</a>`;
                                url = '{{ route('rentals.create',[Student::FOREIGN_KEY => $studentId, BookCopy::FOREIGN_KEY => ":id"]) }}'.replace(encodeURIComponent(':id'), copy.Id);
                                rent = `<a href="${url}" class='mx-1 btn btn-primary'>إعارة</a>`;
                            }
                        @endif
                        return `<span style="display:flex;">${rent+edit+remove+choose}</span>`;
                    }
                }
            ],
            order:[[{{ isset($inventory) ? "1" : "3" }}, "asc"]]
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
