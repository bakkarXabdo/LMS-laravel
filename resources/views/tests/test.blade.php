@extends('layouts.master')

@section('content')
    <br>
    <h1> Graphs </h1>
    <div id="chart" style="height: 400px;"></div>
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
                .borderColors()
                .datasets([{type:'line', fill:false}])
        });
    </script>
@endpush