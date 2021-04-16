
@extends('layouts.master')

@section('PageTitle') تعديل النسخة {{ $copy->getKey() }} @endsection

@section('content')
<form dir="rtl" action="{{ route('bookcopies.update', $copy->getKey()) }}" method="post" novalidate="novalidate">
    @method('PUT')
    <h3>تعديل النسخة</h3>
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
        <input autofocus dir="ltr" class="form-control" id="Id" name="Id" type="text" value="{{ old('Id') ?? $copy->getKey() }}">
    </div>
    <div class="form-group">
        <label for="InventoryId">رقم الجرد</label>
        <input class="form-control" id="InventoryId" name="InventoryId" value="{{ old('InventoryId') ?? $copy->InventoryId }}">
    </div>
    <input type="hidden" hidden style="display: none" name='current_key' value="{{ $copy->getKey() }}">
    <input type="hidden" hidden style="display: none" name='BookId' value="{{ $copy->BookId }}">
    <button type="submit" class="btn btn-primary">حفظ</button>
</form>
@endsection
