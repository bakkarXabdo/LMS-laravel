@extends('layouts.master')

@section('PageTitle') الطالب {{ $student->Name }} @endsection

@section('content')
    <div dir="rtl" class="container body-content">
        <h2>{{ $student->Name }}</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h4>معلومات الطالب</h4>
        <table class="table table-responsive table-bordered">
            <tbody>
                <tr class="d-flex">
                    <th class="col-sm-2">الإسم</th>
                    <td class="col-sm-10">{{ $student->Name }}</td>
                </tr>
                <tr>
                    <th>رقم البطاقة</th>
                    <td>{{ $student->getKey() }}</td>
                </tr>
                <tr>
                    <th>التخصص</th>
                    <td>{{ $student->Speciality }}</td>
                </tr>
                <tr>
                    <th>تاريخ الميلاد</th>
                    <td>{{ $student->BirthDate->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>عدد الإعارات الإجمالية</th>
                    <td>{{ $student->TotalRentals }}</td>
                </tr>
                <tr>
                    <th>الإعارات الجارية</th>
                    <td>
                        @if($student->rentals->count() === 0 )
                            0
                        @else
                            <a href="{{ route('rentals.forstudent', $student->getKey()) }}">{{ $student->rentals->count() }} كِتاب</a>
                        @endif
                    </td>
                </tr>
            @if(Cache::has("student-password"))
                <tr style="background: rgb(212 189 107)">
                    <th>إسم المستخدم</th>
                    <td style="font: 1.5rem">
                        {{ $student->user->username }}
                    </td>
                </tr>
                <tr style="background: rgb(212 189 107)">
                    <th>كلمة السر</th>
                    <td style="font: 1.5rem">
                        {{ Cache::pull("student-password") }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <h4>الإجرائات</h4>
        <hr>
        <div class="row" style="margin-left:0">
            <a class="btn btn-primary" href="{{ route('rentals.create', [Student::urlname() => $student->getKey()]) }}">إعارة</a>
            @if($student->rentalHistories()->count() > 0)
                <a href="{{ route('history.index', [Student::FOREIGN_KEY => $student->getKey()]) }}" class="btn btn-primary">إضهار أرشيف الإعارات</a>
            @endif
            <a class="btn btn-primary" href="{{ route('students.edit', $student->getKey()) }}">تعديل</a>
            @if(!Cache::has("student-password"))
                <form style="display: inline-block;" method="post" action="{{ route('students.changePassword', $student->getKey()) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">تغيير كلمة السر</button>
                </form>
            @endif
            <a id="delete-student" href="#" class="btn btn-danger">حذف</a>

        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $("#delete-student").on("click",  function () {
            var button = $(this);
            bootbox.dialog({
                title: "تأكيد العملية",
                message: `<span> هل تريد فعلا حذف الطالب <strong>{{ $student->Name  }}</strong> ؟</span>`,
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'حذف',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('students.destroy', $student->getKey()) }}',
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
