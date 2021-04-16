
@extends('layouts.master')

@section('PageTitle') تعديل - {{ $book->Title }} @endsection

@section('content')
    <div dir="rtl">
        <h2>تعديل الكتاب: {{ $book->Title }}</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('books.update', $book->getKey()) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="Book_ClassCode">الشفرة</label>
                <input class="form-control" required type="text" name="{{ Book::KEY }}" value="{{ $book->getKey() }}">
            </div>
            <div class="form-group">
                <label for="Book_Title">العنوان</label>
                <input class="form-control" required name="Title" type="text" value="{{ $book->Title }}">
            </div>
            <div class="form-group">
                <label for="Book_Authors">المؤلف</label>
                <input class="form-control" id="Book_Authors" name="Author" type="text" value="{{ $book->Author }}">
            </div>
            <div class="form-group">
                <label for="Book_Isbn">Isbn</label>
                <input class="form-control" id="Book_Isbn" name="Isbn" type="text" value="{{ $book->Isbn }}">
            </div>
            <div class="form-group">
                <label for="Book_Price">السعر</label>
                <input class="form-control" id="Book_Price" name="Price" type="text" value="{{ $book->Price }}">
            </div>
            <div class="form-group">
                <label for="Book_Publisher">الناشر</label>
                <input class="form-control" id="Book_Publisher" name="Publisher" type="text" value="{{ $book->Publisher }}">
            </div>
            <div class="form-group">
                <label for="Book_ReleaseYear">سنة الإصدار</label>
                <input class="form-control" id="Book_ReleaseYear" name="ReleaseYear" type="number" value="{{ $book->ReleaseYear }}">
            </div>
            <div class="form-group">
                <label for="Book_Source">المصدر</label>
                <input class="form-control" id="Book_Source" name="Source" type="text" value="{{ $book->Source }}">
            </div>

            <button type="submit" class="btn btn-primary">حِفظ</button>
            <input type="hidden" hidden style="display: none" name='current_key' value="{{ $book->getKey() }}">
        </form>
        <a href="{{ route('books.index') }}">الرجوع إلى القائمة</a>
    </div>

@endsection


