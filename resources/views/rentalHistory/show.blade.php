@extends('layouts.master')

@section('PageTitle') Rental History @endsection


@section('content')
    <div dir="rtl" class="container body-content">
        <h2>الإعارة #{{ $history->getKey() }}</h2>
        <h4>تفاصيل الإعارة</h4>
        <table class="table table-responsive table-bordered">
            <tbody>
            <tr class="d-flex">
                <th class="col-sm-2">رقم الطالب</th>
                <td class="col-sm-10">{{ $history->StudentId }}</td>
            </tr>
            <tr class="d-flex">
                <th class="col-sm-2">إسم الطالب</th>
                <td class="col-sm-10">{{ $history->StudentName }}</td>
            </tr>
            <tr>
                <th>شفرة النسخة</th>
                <td>{{ $history->BookCopyId }}</td>
            </tr>
            <tr>
                <th>عنوان الكتاب</th>
                <td>{{ $history->BookTitle }}</td>
            </tr>
            <tr>
                <th>إنشاء الإعارة</th>
                <td>{{ $history->RentalCreatedAt }}</td>
            </tr>
            <tr>
                <th>إنتهاء الإعارة</th>
                <td>{{ $history->RentalExpiresAt }}</td>
            </tr>
            <tr>
                <th>تاريخ الإرجاع</th>
                <td>{{ $history->RentalReturnedAt }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
