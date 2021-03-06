@extends('layouts.master')

@section('PageTitle')
    تعديل لغة
@endsection

@section('content')
    <div dir="rtl">
        <h2>تعديل لغة</h2>
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
        <form onsubmit="submitted()" action="{{ route('languages.update', $language->getKey()) }}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="Code">رمز اللغة</label>
                <input onfocus="warn()" class="form-control" id="Code" name="Code" value="{{ old('Code') ?? $language->Code }}">
            </div>
            <div class="form-group">
                <label for="Name">إسم اللغة</label>
                <input class="form-control" id="Name" name="Name" value="{{ old('Name') ?? $language->Name }}">
            </div>
            <input hidden type="hidden" disabled style="display: none" name="{{ App\Models\BookLanguage::KEY }}" value="{{ $language->getKey() }}" />
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
        </div>
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
                    message: '({{ $language->books()->count() . ' نُسخة ' }})تحذير: تغيير رمز اللغة سيغير ايضا جميع شفرات النُسخ الخاصة بهذه اللغة',
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
