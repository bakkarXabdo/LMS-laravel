@extends('layouts.master')

@section('PageTitle') تفاصيل الإعارة @endsection

@section('content')

    <div dir="rtl">
        <br>
        <h4>تفاصيل الإعارة</h4>
        <table class="table table-responsive table-bordered">
            <tbody>
            <tr class="d-flex">
                <th class="col-sm-2">الطالب</th>
                <td><a href="{{ route('students.show', $rental->student->getKey()) }}">{{ $rental->student->Name }}</a></td>
            </tr>
            <tr class="d-flex">
                <th class="col-sm-2">رقم الطالب</th>
                <td>{{ $rental->student->getKey() }}</td>
            </tr>
            <tr>
                <th>الشفرة</th>
                <td>{{ $rental->copy->getKey() }}</td>
            </tr>
            <tr>
                <th>العنوان</th>
                <td><a href="{{ route('bookcopies.show', $rental->copy->getKey()) }}">{{ $rental->book->Title }}</a></td>
            </tr>
            <tr>
                <th>تاريخ الإعارة</th>
                <td>{{ $rental->created->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>تاريخ الإنتهاء</th>
                <td>
                    @if($rental->remainingDays < 0)
                        <span class="text-danger"> قبل {{ day_plural_ar($rental->remainingDays) }}</span>
                    @elseif($rental->remainingDays == 0)
                        <span class="text-warning"> اليوم </span>
                    @else
                        بعد {{ day_plural_ar($rental->remainingDays) }}
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
        <h4>الإجرائات</h4>
        <hr>
        <div class="row" style="margin-left:0">
            <a href="#" class="btn btn-success" onclick="returnRental()">إرجاع</a>
            <a href="#" class="btn btn-warning" onclick="cancelRental()">إلغاء الإعارة</a>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function returnRental()
        {
            bootbox.dialog({
                title: "تأكيد الإجراء",
                message: `<span>هل تريد فعلا إرجاع النسخة {{ $rental->copy->getKey() }} </span>`,
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'إرجاع',
                        className: 'btn-warning',
                        callback: function () {
                            $.ajax({
                                url: "{{ route('rentals.return', $rental->getKey()) }}",
                                method: "POST",
                                dataType: "json",
                                success: function (data) {
                                    if (data.success) {
                                        toastr.success(data.message);
                                        window.location.href = '{{ route('rentals.index') }}';
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
        }
        function cancelRental()
        {
            bootbox.dialog({
                title: "تأكيد الإجراء",
                message: `<span>هل تريد فعلا إلغاء الإعارة</span>`,
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'نعم',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: "{{ route('rentals.destroy', $rental->getKey()) }}",
                                method: "POST",
                                data:{
                                    _method: "DELETE"
                                },
                                dataType: "json",
                                success: function (data) {
                                    if (data.success) {
                                        toastr.success(data.message);
                                        window.location.href = '{{ route('rentals.index') }}';
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
        }
    </script>
@endpush
