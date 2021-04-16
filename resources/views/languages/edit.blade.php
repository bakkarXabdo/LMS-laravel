@extends('layouts.master')

@section('PageTitle')
    تعديل لغة
@endsection

@section('content')
    <div dir="rtl">
        <h2>تعديل لغة</h2>
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
                <input class="form-control" id="Code" name="Code" value="{{ old('Code') ?? $language->Code }}">
            </div>
            <div class="form-group">
                <label for="Name">إسم اللغة</label>
                <input class="form-control" id="Name" name="Name" value="{{ old('Name') ?? $language->Name }}">
            </div>
            <input hidden type="hidden" disabled style="display: none" name="{{ BookLanguage::KEY }}" value="{{ $language->getKey() }}" />
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
@endsection
