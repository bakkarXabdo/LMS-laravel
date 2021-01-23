
@extends('layouts.master')

@section('PageTitle') New Book @endsection

@section('content')
<h2>New Book</h2>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('books.store') }}" method="post" novalidate="novalidate">
    <div class="form-group">
        <label for="Book_Title">Title</label>
        <input class="form-control" data-val="true" data-val-length="Title must be 3-400 Long" data-val-length-max="400" data-val-length-min="3" data-val-required="The Title field is required." id="Book_Title" name="Title" type="text" value="{{ old('Title') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="Title" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Book_Authors">Authors</label>
        <input class="form-control" id="Book_Authors" name="Authors" type="text" value="{{ old('Authors') }}">
    </div>
    <div class="form-group">
        <label for="Book_Isbn">Isbn</label>
        <input class="form-control" id="Book_Isbn" name="Isbn" type="text" value="{{ old('Isbn') }}">
    </div>
    <div class="form-group">
        <label for="Book_Price">Price</label>
        <input class="form-control" id="Book_Price" name="Price" type="number" value="{{ old('Price') }}">
    </div>
    <div class="form-group">
        <label for="Book_Publisher">Publisher</label>
        <input class="form-control" id="Book_Publisher" name="Publisher" type="text" value="{{ old('Publisher') }}">
    </div>
    <div class="form-group">
        <label for="Book_ReleaseYear">Year Released</label>
        <input class="form-control" data-val="true" data-val-number="The field Year Released must be a number." data-val-required="The Year Released field is required." id="Book_ReleaseYear" name="ReleaseYear" type="number" value="{{ old('ReleaseYear') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="Book_ReleaseYear" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Book_Source">Source</label>
        <input class="form-control" id="Book_Source" name="Source" type="text" value="{{ old('Source') }}">
    </div>
    <div class="form-group">
        <label for="Book_ClassCode">ClassCode</label>
        <input class="form-control" data-val="true" data-val-number="The field ClassCode must be a number." data-val-required="The ClassCode field is required." id="Book_ClassCode" name="ClassCode" type="text" value="{{ old('ClassCode') }}">
        <span class="field-validation-valid text-danger" data-valmsg-for="ClassCode" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Book_CategoryId">Category</label>
        <select class="form-control" data-val="true" data-val-number="The field CategoryId must be a number." data-val-required="The Category field is required." id="Book_CategoryId" name="CategoryId">
            <option value="">Select Category</option>
            @if(old())
                @foreach($categories as $category)
                    <option {{ $category->Id==old('CategoryId') ? "selected" : "" }} value="{{ $category->Id }}">{{ $category->Name }}</option>
                @endforeach
            @else
                @foreach($categories as $category)
                    <option value="{{ $category->Id }}">{{ $category->Name }}</option>
                @endforeach
            @endif
        </select>
        <span class="field-validation-valid text-danger" data-valmsg-for="ClassId" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Book_LanguageId">Language</label>
        <select class="form-control" data-val="true" data-val-number="The field LanguageId must be a number." data-val-required="The Language field is required." id="Book_LanguageId" name="LanguageId">
            <option value="">Select Language</option>
            @if(old())
                @foreach($languages as $language)
                    <option {{ $language->Id==old('LanguageId') ? "selected" : "" }} value="{{ $language->Id }}">{{ $language->Name }}</option>
                @endforeach
            @else
                @foreach($languages as $language)
                    <option value="{{ $language->Id }}">{{ $language->Name }}</option>
                @endforeach
            @endif
        </select>
        <span class="field-validation-valid text-danger" data-valmsg-for="LanguageId" data-valmsg-replace="true"></span>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
{{--    <input data-val="true" data-val-number="The field Id must be a number." data-val-required="The Id field is required." id="Book_Id" name="Book.Id" type="hidden" value="">--}}
{{--    <input data-val="true" data-val-number="The field Popularity must be a number." data-val-required="The Popularity field is required." id="Book_Popularity" name="Book.Popularity" type="hidden" value="">--}}
{{--    <input data-val="true" data-val-date="The field DateAdded must be a date." data-val-required="The DateAdded field is required." id="Book_DateAdded" name="Book.DateAdded" type="hidden" value="">--}}
    @csrf
</form>
<a href="{{ route('books.index') }}">Back To List</a>
@endsection