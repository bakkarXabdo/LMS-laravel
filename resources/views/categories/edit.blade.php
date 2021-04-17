@extends('layouts.master')

@section('PageTitle')
    تعديل فئة
@endsection

@section('content')
    <div dir="rtl">
        <h2>تعديل فئة</h2>
        @if ($errors->any())
            <div class="alert alert-danger" style="border:none;background: linear-gradient(45deg, #ff684fc7, #ff0000)">
                <div>
                    الرجاء إصلاح المشاكل الآتية
                </div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form onsubmit="submitted()" action="{{ route('languages.update', $category->getKey()) }}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="Code">رمز الفئة</label>
                <input onfocus="warn()" class="form-control" required id="Code" name="Code" value="{{ old('Code') ?? $category->Code }}">
            </div>
            <div class="form-group">
                <label for="Name">إسم الفئة</label>
                <input class="form-control" id="Name" required name="Name" value="{{ old('Name') ?? $category->Name }}">
            </div>
            <input hidden type="hidden" disabled style="display: none" name="{{ Category::KEY }}" value="{{ $category->getKey() }}" />
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        var oldVal = '{{ $language->Code }}';
        var warned = false;
        function warn()
        {
            if(!warned)
            {
                bootbox.alert({
                    message: '({{ ' نُسخة ' . $language->books()->count() }})تحذير: تغيير رمز الفئة سيغير ايضا جميع شفرات النُسخ الخاصة بهذه الفئة',
                    'locale' : 'ar',
                    'backdrop': true
                });
                warned = true;
            }
        }
        function submitted()
        {
            if(warned)
            {
                if($('#Code').val() !== oldVal)
                {
                    bootbox.dialog({
                        message: 'الرجاء الإنتضار, جاري تغيير شفرات الكٌتب, هذه العملية لا يمكن إيقافها',
                        closeButton: false,
                        'backdrop': false
                    });
                }
            }
        }
    </script>
@endpush
