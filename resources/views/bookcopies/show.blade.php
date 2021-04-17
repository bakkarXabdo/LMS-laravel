@extends('layouts.master')

@section('PageTitle') {{ $copy->book->Title }} @endsection

@section('content')
    <div dir="rtl">
        <h2>معلومات النُسخة {{ $copy->getKey() }}</h2>
        <table class="table table-responsive table-bordered">
            <tbody>
                <tr class="d-flex">
                    <th class="col-sm-2">الكِتاب</th>
                    <td class="col-sm-10">
                        <a href="{{ route('books.show', $copy->book->getKey()) }}">{{ $copy->book->Title }}</a>
                    </td>
                </tr>
                <tr class="d-flex">
                    <th class="col-sm-2">عدد الإعارات الإجمالية</th>
                    <td class="col-sm-10">{{ $copy->TotalRentals }}</td>
                </tr>
                @isset($copy->InventoryId)
                    <tr class="d-flex">
                        <th class="col-sm-2">رقم الجرد</th>
                        <td class="col-sm-10">{{ $copy->InventoryId }}</td>
                    </tr>
                @endisset
                <tr>
                    <th>مُعارة</th>
                    <td>
                        @if($copy->rental)
                            <a title="تفاصيل الإعارة" href="{{ route('rentals.show', $copy->rental->getKey()) }}">مُعارة</a>
                            إلى الطالب
                            <a title="تفاصيل الطالب" href="{{ route('students.show', $copy->rental->student->getKey()) }}">
                                {{ $copy->rental->student->getKey() }} ({{ $copy->rental->student->Name }})
                            </a>
                        @else
                            لا
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <h4>الإجرائات</h4>
        <hr>
        <div class="row" style="margin-left:0">
            <a class="btn btn-primary" href="{{ route('bookcopies.edit', $copy->getKey()) }}">تعديل</a>
            @if(!$copy->rental)
                <a class="btn btn-primary" href="{{ route('rentals.create', ["copyId" => $copy->getKey()]) }}">إعارة</a>
                <a class="btn btn-danger" id="copy-delete" href="#">حذف</a>
            @else
                <form style="display: inline-block" action="{{ route('rentals.return', $copy->rental->getKey()) }}" method="post">
                    @csrf
                    <button style="display: inline-block" class="btn btn-warning" type="submit">إرجاع</button>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("#copy-delete").on("click",  function () {
            bootbox.dialog({
                title: "تأكيد العملية",
                message: 'حذف النُسخة {{ $copy->getKey() }}?',
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'حذف',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('bookcopies.destroy', $copy->getKey()) }}',
                                data:{
                                    _method: "DELETE"
                                },
                                method: "POST",
                                dataType:"json",
                                success: function (data) {
                                    if (data.success) {
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
    </script>
@endpush
