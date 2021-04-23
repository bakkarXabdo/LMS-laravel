@extends('layouts.master')

@section('PageTitle') الإعارات الجارية @endsection
@section('content')
    <div dir="rtl">
        <h3 >الإعارات الجارية ل {{ Auth::user()->Name }}</h3>
        <table style="margin-top: 2rem" class="table table-bordered" >
            <thead>
                <tr>
                    <th class="text-right">الشفرة</th>
                    <th class="text-right">الكتاب</th>
                    <th class="text-right">تاريخ الإعارة</th>
                    <th class="text-right">تاريخ الإرجاع</th>
                    <th class="text-right">الأيام المتبقية</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rentals as $rental)
                    <tr>
                        <td>{{ $rental->book->getKey() }}</td>
                        <td>{{ $rental->book->Title }}</td>
                        <td dir="rtl">{{ $rental->created->arabicDateWithTime() }}</td>
                        <td>{{ $rental->ExpiresAt->arabicDateWithTime() }}</td>
                        <td>{!! $rental->remainingDaysSpan !!}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="999">لا توجد إعارات جارية</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
