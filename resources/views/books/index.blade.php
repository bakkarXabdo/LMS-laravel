@extends('layouts.master')

@section('PageTitle') الكُتب @endsection

@section('content')

<div class="container" dir="rtl">
    <h3>قائمة الكُتب</h3>
    <div class="row mb-2" style="margin-bottom: 4px;">
        <div style="display: inline-block">
            <a href="{{ route('books.create') }}" class="btn btn-primary">إضافة كِتاب </a>
        </div>
        <div style="display: inline-block">
            <a href="{{ route('books.export') }}" class="btn btn-primary">إستخراج الكُتب</a>
        </div>
        <div style="display: inline-block">
            <a href="{{ route('bookcopies.export') }}" class="btn btn-primary">إستخراج النُسخ</a>
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
            ajax: {
                url: "{{ route('books.table') }}",
                method: "POST",
                dataSrc: "data",
                @if($choosing)
                data:function(d){
                    d.choosing = true;
                }
                @endif
            },

            columns: [
                {
                    title: "الشفرة",
                    name:"{{ \App\Models\Book::KEY }}",
                    orderSequence: [ "desc", "asc" ],
                    data: '{{ \App\Models\Book::KEY }}'
                },
                {
                    title: "العنوان",
                    name:"Title",
                    orderSequence: [ "desc", "asc" ],
                    render: function (_, _, book) {
                        let url = '{{ route('books.show', ':Id') }}'.replace(':Id', book.InventoryNumber);
                        return `<a href='${url}' title='#${book.Id}'> ${book.Title} </a>`;
                    }
                },
                {
                    title: "النُسخ",
                    name:"NumberInStock",
                    data: "NumberInStock",
                    orderSequence: [ "desc", "asc" ],
                    searchable: false,
                    render: function (_, _, book) {
                        if (book.NumberInStock > 0) {
                            let url = '{{ route("bookcopies.forBook", ":id") }}'.replace(':id', book.InventoryNumber);
                            return `<a dir='rtl' title="view Copies" href="${url}">${book.NumberInStock + " "} نسخة  </a> `;
                        }else return `<span dir='rtl' class="text-danger">لا يوجد</span>`;
                    }
                },
                {
                    title: "النُسخ المُعارة",
                    name: "RentalsCount",
                    data: "RentalsCount",
                    orderSequence: [ "desc", "asc" ],
                    searchable: false,
                    render: function (_, _, book) {
                        if (book.RentalsCount > 0) {
                            let url = '{{ route('rentals.forbook', ':Id') }}'.replace(':Id', book.InventoryNumber);
                            return `<a dir="rtl" title="View Rented Books" href="${url}">${book.RentalsCount} <span class="v-only"> نسخة</span></a>`;
                        } else return 0;
                    }
                },
                {
                    title: "الإجرائات",
                    data: "InventoryNumber",
                    orderable: false,
                    width: 1,
                    search:true,
                    print:false,
                    render: function (Id,_,book) {
                        var edit = remove = choose = url = "";
                        @if (!isset($choosing) || !$choosing)
                            url = '{{ route('books.edit', ':id') }}'.replace(':id', Id);
                            edit = `<a href="${url}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>تعديل</a>`;
                            remove = `<a href="#" data-book-title="${book.Title}" data-book-id='${Id}' class='js-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>حذف</a>`;
                        @else
                            url = '{{ route('bookcopies.choose', ['bookId'=>':id', 'studentId'=>$studentId]) }}'.replace( encodeURIComponent(':id'), Id);
                            if(book.NumberAvailable > 0)
                                choose = `<a href="${url}" class="mx-1 btn btn-success"><i class="fa fa-check"></i> إختيار</a>`;
                        @endif
                        return `<span style="display:flex">${edit + remove + choose}</span>`;
                    }
                }
            ]
        });

        $("#js-books-table").on("click", ".js-delete", function () {
            var button = $(this);
            bootbox.dialog({
                title: "تأكيد الحذف",
                message: '<span>هل تريد فعلا حذف <strong> ' + button.data('book-title') + ' </strong> و كل نُسخِهِ؟</span>',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'حذف',
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
                        label: 'إلغاء',
                        className: 'btn-secondary'
                    }
                }
            });
            return false;
        });
    });
</script>
@endpush
