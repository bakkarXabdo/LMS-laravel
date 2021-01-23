
@extends('layouts.master')

@section('PageTitle') Edit - {{ $Title }} @endsection

@section('content')
    <h2>Edit Book: {{ $Title }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('books.update', $Id) }}" method="post" novalidate="novalidate">
        @method('PUT')
        <div class="form-group">
            <label for="Book_Title">Title</label>
            <input class="form-control" data-val="true" data-val-length="Title must be 3-400 Long" data-val-length-max="400" data-val-length-min="3" data-val-required="The Title field is required." id="Book_Title" name="Title" type="text" value="{{ $Title }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Title" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_Authors">Authors</label>
            <input class="form-control" id="Book_Authors" name="Authors" type="text" value="{{ $Authors }}">
        </div>
        <div class="form-group">
            <label for="Book_Isbn">Isbn</label>
            <input class="form-control" id="Book_Isbn" name="Isbn" type="text" value="{{ $Isbn }}">
        </div>
        <div class="form-group">
            <label for="Book_Price">Price</label>
            <input class="form-control" id="Book_Price" name="Price" type="number" value="{{ $Price }}">
        </div>
        <div class="form-group">
            <label for="Book_Publisher">Publisher</label>
            <input class="form-control" id="Book_Publisher" name="Publisher" type="text" value="{{ $Publisher }}">
        </div>
        <div class="form-group">
            <label for="Book_ReleaseYear">Year Released</label>
            <input class="form-control" data-val="true" data-val-number="The field Year Released must be a number." data-val-required="The Year Released field is required." id="Book_ReleaseYear" name="ReleaseYear" type="number" value="{{ $ReleaseYear }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Book_ReleaseYear" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_Source">Source</label>
            <input class="form-control" id="Book_Source" name="Source" type="text" value="{{ $Source }}">
        </div>
        <div class="form-group">
            <label for="Book_ClassCode">ClassCode</label>
            <input class="form-control" data-val="true" data-val-number="The field ClassCode must be a number." data-val-required="The ClassCode field is required." id="Book_ClassCode" name="ClassCode" type="text" value="{{ $ClassCode }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="ClassCode" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_CategoryId">Category</label>
            <select class="form-control" data-val="true" data-val-number="The field CategoryId must be a number." data-val-required="The Category field is required." id="Book_CategoryId" name="CategoryId">
                @foreach($categories as $category)
                    <option {{ $category->Id==$book->$CategoryId ? "selected" : "" }} value="{{ $category->Id }}">{{ $category->Name }}</option>
                @endforeach
            </select>
            <span class="field-validation-valid text-danger" data-valmsg-for="ClassId" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Book_LanguageId">Language</label>
            <select class="form-control" data-val="true" data-val-number="The field LanguageId must be a number." data-val-required="The Language field is required." id="Book_LanguageId" name="LanguageId">
                @foreach($languages as $language)
                    <option {{ $language->Id==$book->$LanguageId ? "selected" : "" }} value="{{ $language->Id }}">{{ $language->Name }}</option>
                @endforeach
            </select>
            <span class="field-validation-valid text-danger" data-valmsg-for="LanguageId" data-valmsg-replace="true"></span>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <input name="Id" type="hidden" value="{{ $Id }}">
        @csrf
    </form>
    <a href="{{ route('books.index') }}">Back To List</a>
@endsection