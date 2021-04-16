@extends('layouts.master')

@section('PageTitle') لغة جديدة @endsection

@section('content')
    <div dir="rtl">
        <h2>لغة جديدة </h2>
        @if ($errors->any())
            <div class="alert alert-danger" style="border:none;background: linear-gradient(45deg, #ff684fc7, #ff0000)">
                <div>
                    الرجاء إصلاح المشاكل الآتية
                </div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('languages.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="Code">رمز اللغة</label>
                <input class="form-control" id="Code" name="Code" value="{{ old('Code') }}">
            </div>
            <div class="form-group">
                <label for="Name">إسم اللغة</label>
                <input class="form-control" id="Name" name="Name" value="{{ old('Name') }}">
            </div>
            <button type="submit" class="btn btn-primary">إضافة</button>
        </form>
    </div>
@endsection
