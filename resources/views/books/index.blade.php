@extends('layouts.master')

@section('PageTitle') الكُتب @endsection

@section('content')
<h3>قائمة الكُتب</h3>
<div class="container">
    <div class="row mb-2" style="margin-bottom: 4px;">
        <div style="display: inline-block">
            <a href="{{ route('books.create') }}" class="btn btn-primary">أضف كتاب</a>
        </div>
        <div style="display: inline-block">
            <a href="{{ route('books.importing') }}" class="btn btn-primary">إضافة جدول كُتب</a>
        </div>
        <div style="display: inline-block">
            <a href="{{ route('books.export') }}" class="btn btn-primary">إستخراج الكتب</a>
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
             lang: 'ar',
            language: {
                "emptyTable": "ليست هناك بيانات متاحة في الجدول",
                "loadingRecords": "جارٍ التحميل...",
                "lengthMenu": "أظهر _MENU_ مدخلات",
                "zeroRecords": "لم يعثر على أية سجلات",
                "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "infoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "infoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "search": "ابحث:",
                "paginate": {
                    "first": "الأول",
                    "previous": "السابق",
                    "next": "التالي",
                    "last": "الأخير"
                },
                "aria": {
                    "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                    "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
                },
                "select": {
                    "rows": {
                        "_": "%d قيمة محددة",
                        "0": "",
                        "1": "1 قيمة محددة"
                    },
                    "1": "%d سطر محدد",
                    "_": "%d أسطر محددة",
                    "cells": {
                        "1": "1 خلية محددة",
                        "_": "%d خلايا محددة"
                    },
                    "columns": {
                        "1": "1 عمود محدد",
                        "_": "%d أعمدة محددة"
                    }
                },
                "buttons": {
                    "print": "طباعة",
                    "copyKeys": "زر <i>ctrl<\/i> أو <i>⌘<\/i> + <i>C<\/i> من الجدول<br>ليتم نسخها إلى الحافظة<br><br>للإلغاء اضغط على الرسالة أو اضغط على زر الخروج.",
                    "copySuccess": {
                        "_": "%d قيمة نسخت",
                        "1": "1 قيمة نسخت"
                    },
                    "pageLength": {
                        "-1": "اظهار الكل",
                        "_": "إظهار %d أسطر"
                    },
                    "collection": "مجموعة",
                    "copy": "نسخ",
                    "copyTitle": "نسخ إلى الحافظة",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pdf": "PDF",
                    "colvis": "إظهار الأعمدة",
                    "colvisRestore": "إستعادة العرض"
                },
                "autoFill": {
                    "cancel": "إلغاء",
                    "info": "مثال عن الملئ التلقائي",
                    "fill": "املأ جميع الحقول بـ <i>%d&lt;\\\/i&gt;<\/i>",
                    "fillHorizontal": "تعبئة الحقول أفقيًا",
                    "fillVertical": "تعبئة الحقول عموديا"
                },
                "searchBuilder": {
                    "add": "اضافة شرط",
                    "clearAll": "ازالة الكل",
                    "condition": "الشرط",
                    "data": "المعلومة",
                    "logicAnd": "و",
                    "logicOr": "أو",
                    "title": [
                        "منشئ البحث"
                    ],
                    "value": "القيمة",
                    "conditions": {
                        "date": {
                            "after": "بعد",
                            "before": "قبل",
                            "between": "بين",
                            "empty": "فارغ",
                            "equals": "تساوي",
                            "not": "ليس",
                            "notBetween": "ليست بين",
                            "notEmpty": "ليست فارغة"
                        },
                        "number": {
                            "between": "بين",
                            "empty": "فارغة",
                            "equals": "تساوي",
                            "gt": "أكبر من",
                            "gte": "أكبر وتساوي",
                            "lt": "أقل من",
                            "lte": "أقل وتساوي",
                            "not": "ليست",
                            "notBetween": "ليست بين",
                            "notEmpty": "ليست فارغة"
                        },
                        "string": {
                            "contains": "يحتوي",
                            "empty": "فاغ",
                            "endsWith": "ينتهي ب",
                            "equals": "يساوي",
                            "not": "ليست",
                            "notEmpty": "ليست فارغة",
                            "startsWith": " تبدأ بـ "
                        }
                    },
                    "button": {
                        "0": "فلاتر البحث",
                        "_": "فلاتر البحث (%d)"
                    },
                    "deleteTitle": "حذف فلاتر"
                },
                "searchPanes": {
                    "clearMessage": "ازالة الكل",
                    "collapse": {
                        "0": "بحث",
                        "_": "بحث (%d)"
                    },
                    "count": "عدد",
                    "countFiltered": "عدد المفلتر",
                    "loadMessage": "جارِ التحميل ...",
                    "title": "الفلاتر النشطة"
                },
                "searchPlaceholder": "ابحث ...",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><div class="text-black-50">تحميل...</div>'
            },
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "الكل"]],
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
                        let url = '{{ route('books.show', ':Id') }}'.replace(':Id', book.EncodedKey);
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
                            let url = '{{ route('bookcopies.index', ["book" => ':id']) }}'.replace(encodeURIComponent(':id'), book.EncodedKey);
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
                            let url = '{{ route('rentals.forbook', ':Id') }}'.replace(':Id', book.EncodedKey);
                            return `<a dir="rtl" title="View Rented Books" href="${url}">${book.RentalsCount} <span class="v-only"> نسخة</span></a>`;
                        } else return 0;
                    }
                },
                {
                    title: "الإجرائات",
                    data: "EncodedKey",
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
