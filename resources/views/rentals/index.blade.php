@extends('layouts.master')



@section('PageTitle') الإعارات @endsection
@section('content')
    <div dir="rtl">
        @if ($book != null)
            <h3> الإعارات الجارية للكتاب {{ $book->Title }} (#<a href="{{ route('books.show', $book->getKey()) }}">{{ $book->getKey() }}</a>)</h3>
            <div class="container">
                <a class="btn btn-primary" href="{{ route('bookcopies.choose', ["bookId" => $book->getKey()]) }}">إعارة جديدة</a>
            </div>
        @elseif($student != null)
            <h3>الإعارات الجارية للطالب {{ $student->Name }} (#<a href="{{ route('students.show', $student->getKey()) }}">{{ $student->getKey() }}</a>)</h3>
            <div class="container">
                <a class="btn btn-primary" href="{{ route('rentals.create', ["studentId" => $student->getKey()]) }}">إعارة جديدة</a>
            </div>
        @else
            <h3>الإعارات الجارية</h3>
            <div class="container">
                    <a class="btn btn-primary" href="{{ route('rentals.create') }}">إعارة جديدة</a>
            </div>
        @endif
    </div>
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
                ajax: {
                    url: "{{ route('rentals.table') }}",
                    method: "POST",
                    dataSrc: "data",
                    "data": function (d) {
                        @if($book != null)
                            d.bookId = '{{ $book->getKey() }}';
                        @endif
                        @if($student != null)
                            d.studentId = '{{ $student->getKey() }}';
                        @endif
                    }
                },
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                columns: [
                    {
                        title: "رقم الطالب",
                        name: "StudentId",
                        data: 'StudentId',
                        orderable:false,
                        searchable:true,
                        width: '90',
                    },
                    {
                        title: "الطالب",
                        name: "Name",
                        width: 80,
                        orderable:false,
                        searchable:true,
                        render: function(_,_,rental){
                            url = '{{ route('students.show', ':id') }}'.replace(':id', rental.StudentId);
                            return `<a title="${rental.StudentId}" href="${url}">${rental.StudentName}</a`;
                        }
                    },
                    {
                        title: "النُسخة",
                        name: "{{ \App\Models\Rental::TABLE . "." . \App\Models\BookCopy::FOREIGN_KEY }}",
                        data: "{{ \App\Models\BookCopy::FOREIGN_KEY }}",
                        searchable:true,
                        orderable: true,
                        width: '50',
                        render:function(copyId,__,rental){
                            url = '{{ route('bookcopies.show', ':id') }}'.replace(':id', copyId);
                            return `<a title="إظهار النسخة" href="${url}">${copyId}</a>`;
                        }
                    },
                    {
                        title: "الكِتاب",
                        name: "BookTitle",
                        width: '30%',
                        data: "{{ \App\Models\Book::FOREIGN_KEY }}",
                        searchable:true,
                        orderable: true,
                        render:function(bookId,__,rental){
                            url = '{{ route('books.show', ':id') }}'.replace(':id', bookId);
                            return `<a title="إظهار الكتاب" href="${url}">${rental.BookTitle}</a>`;
                        }
                    },
                    {
                        title: "تاريخ الإعارة",
                        name: "{{ \App\Models\Rental::TABLE . "." . \App\Models\Rental::CREATED_AT}}",
                        data: "ar_created_at",
                        orderable:true,
                        width: 50,
                        'createdCell':  function (td, cellData, rowData, row, col) {
                            $(td).attr('dir', 'rtl');
                        }
                    },
                    {
                        title: "الأيام المتبقية",
                        name: "RemainingDays",
                        data: "RemainingDays",
                        width: '70',
                        searchable: false,
                        orderable: true,
                        render: function(days){
                            let dayText;
                            let late = days < 0 ? " متأخر ب" : 'متبقي';
                            let dayClass = days <= 0 ? 'text-danger' : '';
                            days = Math.abs(days);
                            if(days === 0)
                            {
                                dayText = "ينتهي اليوم"
                            }else if(days === 1)
                            {
                                dayText = `${late} يوم واحد`;
                            }else if(days === 2){
                                dayText = `${late} يومين`;
                            }else if(days <= 10){
                                dayText = `${late} ${days} أيام`;
                            }else{
                                dayText = `${late} ${days} يوما`;
                            }
                            return `<span class='${dayClass}'>  ${dayText}</span>`;
                        }
                    },
                    {
                        title: "الإجرائات",
                        orderable: false,
                        searchable: false,
                        data:"{{ \App\Models\Rental::KEY }}",
                        width:1,
                        render: function (rentalId,_,rental) {
                            let url = '{{ route('rentals.show', ":id") }}'.replace(':id', rentalId);
                            actions = `<a href="${url}" class="mx-1 btn btn-success">إضهار</a>`;
                            actions += `<a href="#" data-rental-id="${rentalId}" data-bookcopy-id="${rental.{{ \App\Models\BookCopy::FOREIGN_KEY }}}" class="js-confirm mx-1 btn btn-primary">إرجاع</a>`;
                            return `<span style="display:flex;">${actions}</span>`;
                        }
                    }
                ],
                order:[[5, "asc"]]
            });
            jst.on("click", ".js-confirm", function () {
                var button = $(this);
                bootbox.dialog({
                    title: "تأكيد الإجراء",
                    message: `<span>هل تريد فعلا إرجاع النسخة ${button.data("bookcopy-id")} </span>`,
                    backdrop:true,
                    buttons: {
                        confirm: {
                            label: 'إرجاع',
                            className: 'btn-warning',
                            callback: function () {
                                $.ajax({
                                    url: "{{ route('rentals.return', ':id') }}".replace(':id', button.data("rental-id")),
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
                            label: 'إلغاء',
                            className: 'btn-secondary'
                        }

                    }
                });
                return false;
            });
            jst.append('<tfoot class="d-flex"></tfoot>');
            jst.find('thead th').each(function (index) {
                if(index < 3) {
                    jst.find('tfoot').append(`<th></th>`);
                }
            });
            jst.find('tfoot th').each(function (index) {
                $(this).html(`<input data-col-indx=${index} type="text" style="width: 100%" class="form-control d-flex px-1 mt-2" placeholder="بحث " />`);
            });
            $('input', 'tfoot th').on( 'keyup', function () {
                table.columns($(this).data('col-indx')).search($(this).val()).draw();
            } );
        });
    </script>
@endpush
