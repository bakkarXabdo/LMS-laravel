@extends('layouts.master')

@section('content')
    <form action="{{ route('books.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input class="form-control" type="file" id="formFile">
        </div>
    </form>
@endsection

@push('scripts')
    <script>


    </script>
@endpush