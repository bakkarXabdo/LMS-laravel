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
                <td>{{\Illuminate\Support\Carbon::parse($rental->DateAdded)->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>تاريخ الإنتهاء</th>
                <td>
                    @if($rental->returnDate < 0)
                        <span class="text-danger">إنتهى قبل {{ $rental->returnDate }} أيام</span>
                    @elseif($rental->returnDate == 0)
                        <span class="text-warning"> ينتهي اليوم </span>
                    @else
                        بعد {{ $rental->returnDate }} أيام
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
        <h4>الإجرائات</h4>
        <hr>
        <div class="row" style="margin-left:0">
            <form action="{{ route('rentals.return', $rental->getKey()) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success" href>إرجاع</button>
            </form>
        </div>
    </div>
@endsection
