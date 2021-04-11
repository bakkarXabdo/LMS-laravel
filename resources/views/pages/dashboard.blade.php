@extends('layouts.master')
@section('PageTitle') الرئيسية @endsection
@section('content')
    <h1 class="jumbotron text-center">{{config('app.name')}}</h1>

    <div id="chart" style="height: 300px;"></div>
    <div dir="rtl">
        <div class="row">
            <h4>إحصائات</h4>
            <table class="table table-striped table-bordered">
                <tr >
                    <th class="col-sm-2 text-right" dir="rtl">الكتب</th>
                    <td class="col-sm-10">{{ $bookCount }}</td>
                </tr>
                <tr>
                    <th class="col-sm-2 text-right" dir="rtl">النسخ</th>
                    <td class="col-sm-10">{{ $BookCopiesCount }}</td>
                </tr>
                <tr>
                    <th class="col-sm-2 text-right" dir="rtl">الطلاب</th>
                    <td class="col-sm-10">{{ $CustomersCount }}</td>
                </tr>
                <tr>
                    <th class="col-sm-2 text-right" dir="rtl">الإعارات الجارية</th>
                    <td class="col-sm-10">{{ $ActiveRentalsCount }}</td>
                </tr>
                <tr>
                    <th class="col-sm-2 text-right" dir="rtl">الإعارات المنتهية</th>
                    <td class="col-sm-10">{{ $ExpiredRentalsCount }}</td>
                </tr>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('charts')",
            hooks: new ChartisanHooks().colors()
                .responsive()
                .colors()
                .beginAtZero()
                .legend({labels:{
                    fontColor: 'black',
                        fontFamily:'Tajawal',
                        fontSize : 16
                }
                })
                .borderColors()
                .datasets([{
                    type:'line',
                    fill:false,
                    fontFamily:'Tajawal'
                }]),
        });
    </script>
@endpush
