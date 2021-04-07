@extends('layouts.master')

@section('PageTitle') الأرشيف @endsection


@section('content')
    <div dir="rtl" class="container body-content" style="padding-top: 2rem">
        <h2>الأرشيف</h2>
        <hr/>
        <a class="btn btn-primary" href="{{ route('history.export') }}">إستخراج</a>
        <div style="margin-top: 2rem;">
            <table class="table table-bordered table-hover">
                <div style="padding: 10px;"  class="text-right" dir="ltr">
                    إضهار {{ $results->count() }} من أصل {{ $results->total() }} نتيجة
                </div>
                <thead>
                    <tr>
                        <th style="width: auto;" class="text-right" dir="ltr">الشفرة</th>
                        <th style="width: auto;" class="text-right">العنوان</th>
                        <th style="width: auto;" class="text-right">رقم الطالب</th>
                        <th style="width: auto;" class="text-right">الطالب</th>
                        <th style="width: auto;" class="text-right">تاريخ الإعارة</th>
                        <th style="width: auto;" class="text-right">تاريخ إنتهاء الإعارة</th>
                        <th style="width: auto;" class="text-right">تاريخ الإرجاع</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($results as $history)
                    <tr>
                        <td>{{ $history->BookCopyId }}</td>
                        <td>{{ $history->BookTitle }}</td>
                        <td>{{ $history->StudentId }}</td>
                        <td>{{ $history->StudentName }}</td>
                        <td>{{ $history->RentalCreatedAt }}</td>
                        <td>{{ $history->RentalExpiresAt }}</td>
                        <td>{{ $history->RentalReturnedAt }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="99">لا توجد نتائج</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div>
                <div style="padding: 10px;"  class="text-center" dir="ltr">
                    {{$results->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
