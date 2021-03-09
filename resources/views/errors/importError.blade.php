@extends('layouts.master')
@section('PageTitle') خطأ إدخال بيانات @endsection

@push('src')
    <style>
        thead tr:first-child th { position: sticky; top: 0; }
    </style>
@endpush
@section('content')
    <div dir="rtl" class="text-right" style="margin-top: 3rem;">
        <div style="font-size: 1.7rem">
            {{ $headMessage ?? "" }}
            @if(isset($code))
                <br><br>
                <pre dir="ltr" class="text-left">
                    <code dir="ltr" class="text-left">
                        {{ $code }}
                    </code>
                </pre>
            @endif
        </div>
        @if(isset($errors) && count($errors) > 0)
        <div>
            <h4 class="text-danger">الرجاء إصلاح الأخطاء التالية ({{ count($errors) }}) !</h4>
        </div>
        <hr/>
        <div style="margin-top: 2rem;">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width: 20%;" class="text-right">السطر</th>
                    <th style="width: 50%;" class="text-right">الخطأ</th>
                    <th style="width: 10%;" class="text-right">العمود</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($errors as $key => $error)
                    <tr>
                        <td style="font-size: 1.5rem">{{ $error['line'] }}</td>
                        <td style="font-size: 1.6rem">{{ $error['message'] }}</td>
                        <td>{{ $error['column'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @if(isset($warnings) && count($warnings) > 0)
            @if(count($errors) > 0)
                <hr/><br>
            @endif
            <div>
                <h4 class="text-warning">الرجاء مراجعة التحذيرات التالية ({{ count($warnings) }}) !</h4>
            </div>
            <hr/>
            <div style="margin-top: 2rem;">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 20%;" class="text-right">السطر</th>
                        <th style="width: 50%;" class="text-right">الملاحظة</th>
                        <th style="width: 10%;" class="text-right">العمود</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($warnings as $key => $warning)
                        <tr>
                            <td style="font-size: 1.5rem">{{ $warning['line'] }}</td>
                            <td style="font-size: 1.6rem">{{ $warning['message'] }}</td>
                            <td>{{ $warning['column'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection