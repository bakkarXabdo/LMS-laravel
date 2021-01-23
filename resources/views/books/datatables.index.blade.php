@extends('layouts.master')

@section('PageTitle') Book List @endsection

@section('content')
    <h3>Available Books</h3>
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-2 pl-0">
                <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
            </div>
        </div>
    </div>
    {{ $dataTable->table() }}
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush