@extends('layouts.master')

@section('PageTitle') الطالب {{ $Name }} @endsection


@section('content')
    <div class="container body-content">
        <h2>{{ $Name }}</h2>
        <h4>معلومات الطالب</h4>
        <table class="table table-responsive table-bordered">
            <tbody>
                <tr class="d-flex">
                    <th class="col-sm-2">الإسم</th>
                    <td class="col-sm-10">{{ $Name }}</td>
                </tr>
                <tr>
                    <th>تاريخ الميلاد</th>
                    <td>{{ \Carbon\Carbon::parse()->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>الرقم</th>
                    <td>{{ $student->getKey() }}</td>
                </tr>
                <tr>
                    <th>إجمالي الكُتب المُعارة</th>
                    <td>{{ $TotalRentals }}</td>
                </tr>
                <tr>
                    <th>الكُتب المُعارة</th>
                    <td>
                        @if($RentalCount === 0 )
                            0
                        @else
                            <a href="{{ route('rentals.forcustomer', $student->getKey()) }}">{{ $RentalCount }} كِتاب</a>
                        @endif
                    </td>
                </tr>
            @if(\Illuminate\Support\Facades\Cache::has("student-password"))
                <tr style="background: rgb(212 189 107)">
                    <th>كلمة السر</th>
                    <td>
                        {{ \Illuminate\Support\Facades\Cache::pull("student-password") }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <h4>الإجرائات</h4>
        <hr>
        <div class="row" style="margin-left:0">
            <a class="btn btn-primary" href="{{ route('students.edit', $Id) }}">تعديل</a>
            <a class="btn btn-primary" href="{{ route('rentals.create', ["studentId" => $Id]) }}">إعارة</a>
            @if(!\Illuminate\Support\Facades\Cache::has("customer-password"))
                <form style="display: inline-block;" method="post" action="{{ route('students.changePassword', $Id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">تغيير كلمة السر</button>
                </form>
            @endif
            <a id="delete-customer" href="#" class="btn btn-danger">حذف</a>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $("#delete-customer").on("click",  function () {
            var button = $(this);
            bootbox.dialog({
                title: "تأكيد العملية",
                message: `<span> هل تريد فعلا حذف الطالب <strong>{{ $Name  }}</strong> ؟</span>`,
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'حذف',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('students.destroy', $Id) }}',
                                data:{
                                    _method: "DELETE"
                                },
                                method: "POST",
                                dataType:"json",
                                success: function (data) {
                                    if (data.success) {
                                        toastr.success(data.message);
                                        location.href = document.referrer;
                                    } else {
                                        toastr.error(data.message);
                                    }
                                }
                            })
                        }
                    },
                    cancel: {
                        label: 'إلغاء',
                        className: 'btn-secondary',
                    }
                }
            });
            return false;
        });
    </script>
@endpush