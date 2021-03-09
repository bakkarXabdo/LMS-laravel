
@extends('layouts.master')

@section('PageTitle') تعديل - {{ $Title }} @endsection

@section('content')
    <h2>تعديل الكتاب: {{ $Title }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('books.update', $book->getKey()) }}" method="post" novalidate="novalidate">
        @method('PUT')
        <div class="form-group">
            <label for="Book_Title">العنوان</label>
            <input class="form-control" data-val="true" data-val-length="Title must be 3-400 Long" data-val-length-max="400" data-val-length-min="3" data-val-required="The Title field is required." id="Book_Title" name="Title" type="text" value="{{ $Title }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Title" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_Authors">المؤلف</label>
            <input class="form-control" id="Book_Authors" name="Author" type="text" value="{{ $Author }}">
        </div>
        <div class="form-group">
            <label for="Book_Isbn">Isbn</label>
            <input class="form-control" id="Book_Isbn" name="Isbn" type="text" value="{{ $Isbn }}">
        </div>
        <div class="form-group">
            <label for="Book_Price">السعر</label>
            <input class="form-control" id="Book_Price" name="Price" type="number" value="{{ $Price }}">
        </div>
        <div class="form-group">
            <label for="Book_Publisher">الناشر</label>
            <input class="form-control" id="Book_Publisher" name="Publisher" type="text" value="{{ $Publisher }}">
        </div>
        <div class="form-group">
            <label for="Book_ReleaseYear">سنة الإصدار</label>
            <input class="form-control" data-val="true" data-val-number="The field Year Released must be a number." data-val-required="The Year Released field is required." id="Book_ReleaseYear" name="ReleaseYear" type="number" value="{{ $ReleaseYear }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Book_ReleaseYear" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_Source">المصدر</label>
            <input class="form-control" id="Book_Source" name="Source" type="text" value="{{ $Source }}">
        </div>
        <div class="form-group">
            <label for="Book_ClassCode">الشفرة</label>
            <input class="form-control" data-val="true" data-val-number="The field ClassCode must be a number." data-val-required="The ClassCode field is required." id="Book_ClassCode" name="ClassCode" type="text" value="{{ $ClassCode }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="ClassCode" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_CategoryId">الفئة</label>
            <select class="form-control" data-val="true" data-val-number="The field CategoryId must be a number." data-val-required="The Category field is required." id="Book_CategoryId" name="CategoryId">
                @foreach($categories as $category)
                    <option {{ $category->getKey()==$book->$CategoryId ? "selected" : "" }} value="{{ $category->getKey() }}">{{ $category->Name }}</option>
                @endforeach
            </select>
            <span class="field-validation-valid text-danger" data-valmsg-for="ClassId" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_LanguageId">اللُغة</label>
            <select class="form-control" data-val="true" data-val-number="The field LanguageId must be a number." data-val-required="The Language field is required." id="Book_LanguageId" name="LanguageId">
                @foreach($languages as $language)
                    <option {{ $language->getKey()==$book->$LanguageId ? "selected" : "" }} value="{{ $language->getKey() }}">{{ $language->Name }}</option>
                @endforeach
            </select>
            <span class="field-validation-valid text-danger" data-valmsg-for="LanguageId" data-valmsg-replace="true"></span>
        </div>
        <button type="submit" class="btn btn-primary">حِفظ</button>
        <input name="{{ \App\Models\Book::KEY }}" type="hidden" value="{{ $book->getKey() }}">
        @csrf
    </form>
    <a href="{{ route('books.index') }}">الرجوع إلى القائمة</a>
@endsection