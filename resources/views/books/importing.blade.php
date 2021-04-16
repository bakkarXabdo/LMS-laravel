@extends('layouts.master')

@section('PageTitle') {{ !isset($errors) || count($errors) === 0 ? "إدخال ملف إكسل" : " نتيجة الإدخال" }} @endsection

@section('content')
<div class="container" dir="rtl"  style="margin-top: 3rem">
    <h3>إدخال كُتب</h3>
    <hr/>
    <form id="form"
          action="{{ route('books.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label style="font-size: 1.5rem; font-weight: bold" title="اختر ملف" class="btn btn-success" for="data">اختر ملف</label>
            <input style="display: none" id="data" type="file" name="data" >
        </div>
        <div class="form-group">
            <label style="font-size: 1.5rem; font-weight: bold" for="startOffset">بداية البيانات</label>
            <input class="form-control" id="startOffset" value="2" min="1" type="number" name="startOffset">
        </div>
        <div class="">
            <input class="" id="unique"  type="checkbox" name="unique">
            <label style="font-size: 1.5rem;font-weight: bold" for="unique">تخطي النُسخ المُكررة في الملف</label>
        </div>
        <hr/>
        <h4 style="margin-top: 5px">موقع الأعمدة</h4>
        <div class="form-group mt-2">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-right">العمود</th>
                        <th class="text-right">الموضع</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold">الجرد</td>
                        <td style="padding: 0"><input placeholder="اترك الحقل فارغ لتجاهل العمود" class="form-control" style="width: 100%;max-width: none;height: 100%;max-height: none;" name="pos[InventoryId]" value="2"></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">الشفرة</td>
                        <td style="padding: 0"><input placeholder="إجباري" class="form-control" style="width: 100%;max-width: none;height: 100%;max-height: none;" name="pos[Code]" value="3"></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">العنوان</td>
                        <td style="padding: 0"><input placeholder="إجباري" class="form-control" style="width: 100%;max-width: none;height: 100%;max-height: none;" name="pos[Title]" value="4"></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">المؤلف</td>
                        <td style="padding: 0"><input placeholder="إجباري" class="form-control" style="width: 100%;max-width: none;height: 100%;max-height: none;" name="pos[Author]" value="5"></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">الناشر</td>
                        <td style="padding: 0"><input placeholder="اترك الحقل فارغ لتجاهل العمود" class="form-control" style="width: 100%;max-width: none;height: 100%;max-height: none;" name="pos[Publisher]" value=""></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">سنة النشر</td>
                        <td style="padding: 0"><input placeholder="اترك الحقل فارغ لتجاهل العمود" class="form-control" style="width: 100%;max-width: none;height: 100%;max-height: none;" name="pos[ReleaseYear]" value=""></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">السعر</td>
                        <td style="padding: 0"><input placeholder="اترك الحقل فارغ لتجاهل العمود" class="form-control" style="width: 100%;max-width: none;height: 100%;max-height: none;" name="pos[Price]" value=""></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="alert alert-info" style="color: #131211; font-weight: bold">
            <strong style="color: #813c00">ملاحظة!<br></strong> عملية إدخال المعلومات قد تستغرق عدة دقائق
        </div>
        <div class="form-group mt-2">
            <button onclick="this.disabled = true;document.getElementById('form').submit();" type="submit" class="btn btn-primary">إدخال</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
        // $(document).ready(function(){
        //     $("input[type=file]").prettyFile({
        //         'text' : "إختر ملفات"
        //     });
        // });
    </script>
@endpush
