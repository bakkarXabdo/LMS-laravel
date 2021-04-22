@extends('layouts.master')

@section('PageTitle') إستخراج الأرشيف @endsection

@section('content')
    <div class="container" dir="rtl"  style="margin-top: 3rem">
        <form action="{{ route('history.exporting') }}" method="post">
            @csrf
            <h2>إستخراج الأرشيف</h2>
            <hr/>
            <div class="form-group">
                <label for="start">إبتداءا من</label>
                <input class="form-control" id="start" type="date" name="start" value="{{ \Carbon\Carbon::parse($starting)->format('Y-m-d') }}"/>
            </div>
            <div class="form-group">
                <label for="start">إلى غاية</label>
                <input class="form-control" id="start" type="date" name="end" value="{{ \Carbon\Carbon::parse($ending)->format('Y-m-d') }}"/>
            </div>
            <button type="submit" class="btn btn-primary">إستخراج</button>
        </form>
    </div>
@endsection
