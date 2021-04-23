@extends('layouts.master')

@section('PageTitle') الطُلاب @endsection


@section('content')
    <div class="container" dir="rtl">
        <h3>قائمة الطلبة</h3>
        <a href="{{ route('students.create') }}" class="btn btn-primary">إضافة طالب</a>
    </div>
    <div class="container" dir="ltr">
        <table class="table table-bordered" id="js-students-table"></table>
    </div>
@endsection

@push('scripts')
<script>
    let table;
    let url;
    let jst = $("#js-students-table")
    $(document).ready(function () {
        table = jst.DataTable({
            dom:'lrtip',
            ajax: {
                url: "{{ route('students.table') }}",
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
                    title: "الرقم",
                    name:"{{ \App\Models\Student::KEY }}",
                    data: "{{ \App\Models\Student::KEY }}",
                    searchable: true,
                    orderable: false
                },
                {
                    title:"الطالب",
                    searchable: true,
                    name: "Name",
                    render: function (_,_, student) {
                        url = '{{ route('students.show', ':id') }}'.replace(':id', student.{{ \App\Models\Student::KEY }});
                        return `<a href='${url}' title='View This Customer'> ${student.Name} </a>`;
                    }
                },
                {
                    title: "الإعارات الجارية",
                    name:"RentalsCount",
                    orderable:true,
                    render: function (_, _, student) {
                        if (student.RentalsCount > 0) {
                            url = '{{ route('rentals.forstudent', ':id') }}'.replace(':id', student.{{ \App\Models\Student::KEY }});
                            return `<a href='${url}'>${student.RentalsCount} كتاب <a/>`;
                        }
                        return "0";
                    }
                },
                {
                    title: "الإعارات الكلية",
                    name:"TotalRentals",
                    data: "TotalRentals",
                    orderable:true
                },
                {
                    title: "الإجرائات",
                    data: "{{ \App\Models\Student::KEY }}",
                    orderable: false,
                    searchable: false,
                    width: 1,
                    render: function (StudentId) {
                        let actions="";
                        @if(isset($renting) && $renting)
                            url = '{{ route('rentals.create', ['copyId' => $copyId, 'studentId' => ':id']) }}'.replace(encodeURIComponent(':id'), StudentId)
                            actions += `<a href="${url}" class="mx-1 btn btn-success"><i class="fa fa-check"></i> إختيار</a>`;
                        @else
                            url = '{{ route('students.edit', ':id') }}'.replace(':id', StudentId);
                        actions += `<a href="${url}" class="mx-1 btn btn-primary"><i class="fa fa-edit"></i>تعديل</a>`;
                        actions += `<a href="#" data-student-id='${StudentId}' class='js-student-delete mx-1 btn btn-danger'><i class="fa fa-trash"></i>حذف</a>`;
                        @endif
                            return `<span style="display:flex">${actions}</span>`;
                    }
                }
            ],
            order: [[1, "desc"]]
        });
        jst.on("click", ".js-student-delete", function () {
            var button = $(this);
            bootbox.dialog({
                title: "تأكيد",
                message: '<span>هل تريد بالفعل حذف الطالب <strong>" ' + button.parents('tr').children().first().find("a").text() + '"</strong> ?</span>',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'حذف',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: "{{ route('students.destroy', ':id') }}".replace(':id', button.data("student-id")),
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
                        label: 'إلغاء',
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
            if(index < 2)
            $(this).html(`<input data-col-indx=${index} type="text" style="width: 100%" class="form-control d-flex px-1 mt-2" placeholder="بحث" />`);
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
