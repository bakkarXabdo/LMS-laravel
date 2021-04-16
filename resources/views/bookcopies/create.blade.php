
@extends('layouts.master')

@section('PageTitle') Create Copy @endsection

@section('content')

    <form dir="rtl" action="{{ route('bookcopies.store') }}" method="post" novalidate="novalidate">
        <h3>نسخة جديدة</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                الرجاء مراجعة الأخطاء التالية
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @csrf
        <div class="form-group">
            <label for="Id">الشفرة</label>
            <input autofocus dir="ltr" class="form-control" id="Id" name="Id" type="text" value="{{ old('Code') ?? (request()->has('bookId') ? request('bookId')."/" : '') }}">
        </div>
        <div class="form-group">
            <label for="InventoryId">رقم الجرد</label>
            <input class="form-control" id="InventoryId" name="InventoryId" value="{{ old('InventoryId') }}">
        </div>
        <input hidden name="BookId" value="{{ request()->get('bookId') }}"/>
        <button type="submit" class="btn btn-primary">إضافة</button>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const input = $("#Id");
            const len = input.val().length;
            input[0].focus();
            input[0].setSelectionRange(len, len);
        });
    </script>
@endsection
