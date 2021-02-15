
@extends('layouts.master')

@section('PageTitle') Create Copy {{ $book->Title }} @endsection

@section('content')
    <h3>New Copy For <a href="{{ route('books.show', $book->Id) }}">{{ $book->Title }}</a></h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            Please Fix These Errors-
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('bookcopies.create', ["bookId" => $book->getKey()]) }}" method="post" novalidate="novalidate">
        @csrf
        <div class="form-group">
            <label for="Shelf">Shelf</label>
            <input class="form-control" data-val="true" data-val-number="The field Shelf must be a number." data-val-required="The Shelf field is required." id="Shelf" name="Shelf" type="number" value="{{ old('Shelf') }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Shelf" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Column">Column</label>
            <input class="form-control" data-val="true" data-val-number="The field Column must be a number." data-val-required="The Column field is required." id="Column" name="Column" type="number" value="{{ old('Column') }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Column" data-valmsg-replace="true"></span>
        </div>
        <div class="form-group">
            <label for="Row">Row</label>
            <input class="form-control" data-val="true" data-val-number="The field Row must be a number." data-val-required="The Row field is required." id="Row" name="Row" type="number" value="{{ old('Row') }}">
            <span class="field-validation-valid text-danger" data-valmsg-for="Row" data-valmsg-replace="true"></span>
        </div>
        <input hidden name="BookId" value="{{ $book->getKey() }}">
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
@endsection