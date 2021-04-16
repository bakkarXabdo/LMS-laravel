
@extends('layouts.master')

@section('PageTitle') كتاب جديد @endsection

@section('content')

<div style="display: inline-block">
    <a href="{{ route('books.importing') }}" class="btn btn-primary">إدخال جدول كُتب</a>
</div>
<form dir="rtl" action="{{ route('books.store') }}" method="post" novalidate="novalidate">
    @if ($errors->any())
        <h4>الرجاء إصلاح الأخطاء التالية</h4>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <h2>إدخال كتاب جديد</h2>
    @endif
    <div class="form-group">
        <label for="Book_InventoryNumber">الشفرة</label>
        <input class="form-control" data-val="true" data-val-required="الشفرة إجبارية." id="Book_InventoryNumber" name="InventoryNumber" type="text" value="{{ old('InventoryNumber') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="Book_InventoryNumber" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Book_Title">العنوان</label>
        <input class="form-control" data-val="true" data-val-length="العنوان يجب أن يكون بين 3 و 400 حروف" data-val-length-max="400" data-val-length-min="3" data-val-required="العنوان إجباري" id="Book_Title" name="Title" type="text" value="{{ old('Title') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="Title" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Book_Authors">المُؤلف</label>
        <input class="form-control" id="Book_Authors" name="Authors" type="text" value="{{ old('Authors') }}">
    </div>
    <div class="form-group">
        <label for="Book_Isbn">Isbn</label>
        <input class="form-control" id="Book_Isbn" name="Isbn" type="text" value="{{ old('Isbn') }}">
    </div>
    <div class="form-group">
        <label for="Book_Price">السعر</label>
        <input class="form-control" id="Book_Price" name="Price" value="{{ old('Price') }}">
    </div>
    <div class="form-group">
        <label for="Book_Publisher">الناشر</label>
        <input class="form-control" id="Book_Publisher" name="Publisher" type="text" value="{{ old('Publisher') }}">
    </div>
    <div class="form-group">
        <label for="Book_ReleaseYear">سنة الإصدار</label>
        <input class="form-control" data-val="true" min="1" data-val-number="The field Year Released must be a number." id="Book_ReleaseYear" name="ReleaseYear" type="number" value="{{ old('ReleaseYear') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="Book_ReleaseYear" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Book_Source">المصدر</label>
        <input class="form-control" id="Book_Source" name="Source" type="text" value="{{ old('Source') }}">
    </div>

    <button type="submit" class="btn btn-primary">إضافة</button>
{{--    <input data-val="true" data-val-number="The field Id must be a number." data-val-required="The Id field is required." id="Book_Id" name="Book.Id" type="hidden" value="">--}}
{{--    <input data-val="true" data-val-number="The field Popularity must be a number." data-val-required="The Popularity field is required." id="Book_Popularity" name="Book.Popularity" type="hidden" value="">--}}
{{--    <input data-val="true" data-val-date="The field DateAdded must be a date." data-val-required="The DateAdded field is required." id="Book_DateAdded" name="Book.DateAdded" type="hidden" value="">--}}
    @csrf
</form>
<a href="{{ route('books.index') }}">Back To List</a>
@endsection
