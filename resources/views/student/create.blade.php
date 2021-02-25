@extends('layouts.master')

@section('PageTitle') طالب جديد @endsection

@section('content')
    <div dir="rtl">
        <h2>طالب جديد</h2>
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
        <form action="{{ route('students.store') }}" method="post" novalidate="novalidate">
            @csrf
            <div class="form-group">
                <label for="{{ \App\Models\Student::KEY }}">رقم الطالب</label>
                <input class="form-control" id="{{ \App\Models\Student::KEY }}" name="{{ \App\Models\Student::KEY }}" value="{{ old(\App\Models\Student::KEY) }}">
            </div>
            <div class="form-group">
                <label for="Name">الإسم الكامل</label>
                <input class="form-control" data-val="true" data-val-length="الإسم يجب أن يكون بين 3 و 400 حرف" data-val-length-max="400" data-val-length-min="3" data-val-required="الإسم إجباري" id="Name" name="Name" type="text" value="{{ old('Name') }}">
                <span class="field-validation-valid text-danger" data-valmsg-for="Name" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label for="Speciality">التخصص</label>
                <input class="form-control" id="Speciality" name="Speciality" value="{{ old('Speciality') }}">
            </div>
            <div class="form-group">
                <label for="BirthDate">تاريخ الميلاد</label>
                <input class="form-control" id="BirthDate" name="BirthDate" type="date" value="{{ old('BirthDate') }}">
                <span class="field-validation-valid text-danger" data-valmsg-for="BirthDate" data-valmsg-replace="true"></span>
            </div>

            <button type="submit" class="btn btn-primary">إضافة</button>
        </form>
        <div style="padding-top: 10px;">
            <a href="{{ route('students.index') }}">الرجوع إلى القائمة</a>
        </div>
    </div>
@endsection
