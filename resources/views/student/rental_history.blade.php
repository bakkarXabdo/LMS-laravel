@extends('layouts.master')

@section('PageTitle') أرشيف الإعارات @endsection
@section('content')
    <div dir="rtl">
        <h3 >أرشيف الإعارات الخاص ب {{ Auth::user()->Name }}</h3>
        <table style="margin-top: 2rem" class="table table-bordered" >
            <thead>
                <tr>
                    <th class="text-right">الشفرة</th>
                    <th class="text-right">الكتاب</th>
                    <th class="text-right">مدة الإعارة</th>
                    <th class="text-right">تاريخ الإعارة</th>
                    <th class="text-right">تاريخ الإنتهاء</th>
                    <th class="text-right">تاريخ الإرجاع</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                    <tr>
                        <td>{{ $history->book->getKey() ?? 'غير معروف' }}</td>
                        <td>{{ $history->book->Title ?? 'غير معروف'}}</td>
                        <td>{{ ar_plural_days($history->rentalDuration) }}</td>
                        <td>{{ $history->RentalExpiresAt->arabicDateWithTime()}}</td>
                        <td>{{ $history->RentalCreatedAt->arabicDateWithTime()}}</td>
                        <td dir="rtl">{{ $history->created->arabicDateWithTime()}}</td>

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
