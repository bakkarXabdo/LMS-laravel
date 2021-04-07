@extends('layouts.master')
@section('PageTitle') DashBoard @endsection
@section('content')
    <h1 class="jumbotron text-center">{{config('app.name')}}</h1>

    <div id="chart" style="height: 300px;"></div>
    <div class="row">
        <h4>Latest Statistics</h4>
        <table class="table table-striped table-bordered">
            <tr>
                <th class="col-sm-2">Books</th>
                <td class="col-sm-10">{{ $bookCount }}</td>
            </tr>
            <tr>
                <th class="col-sm-2">Book Copies</th>
                <td class="col-sm-10">{{ $BookCopiesCount }}</td>
            </tr>
            <tr>
                <th class="col-sm-2">Customers</th>
                <td class="col-sm-10">{{ $CustomersCount }}</td>
            </tr>
            <tr>
                <th class="col-sm-2">Active Rentals</th>
                <td class="col-sm-10">{{ $ActiveRentalsCount }}</td>
            </tr>
            <tr>
                <th class="col-sm-2">Expired Rentals</th>
                <td class="col-sm-10">{{ $ExpiredRentalsCount }}</td>
            </tr>
            <tr>
                <th class="col-sm-2">Most Rentals per Customer</th>
                <td class="col-sm-10">{{ $MaxRentedCustomer }}</td>
            </tr>
        </table>
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
