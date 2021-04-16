@extends('layouts.master')
@section('PageTitle') الفئات @endsection
@section('content')
    <div dir="rtl">
        <a href="{{  route('categories.create') }}" class="btn btn-primary">فئة جديدة</a>
        <div style="margin-top: 2rem;">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width: 10%;" class="text-right">الإسم</th>
                    <th style="width: 10%;" class="text-right" dir="ltr">الرمز</th>
                    <th style="width: 10%;" class="text-right" dir="ltr">عدد الكتب</th>
                    <th style="width: 10%;" class="text-right" dir="ltr">عدد النسخ</th>
                    <th style="width: 40%;" class="text-right" dir="ltr">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($categories as $key => $category)
                    <tr>
                        <td style="font-size: 1.6rem">{{ $category->Name }}</td>
                        <td style="font-size: 1.5rem">{{ $category->Code }}</td>
                        <td style="font-size: 1.6rem">{{ $category->books()->count() }}</td>
                        <td style="font-size: 1.5rem">{{ $category->copies()->count() }}</td>
                        <td style="font-size: 1.5rem">
                            <form method="POST" action="{{ route('categories.destroy', $category->getKey()) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="999">لا توجد فئات</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
