@extends('layouts.master')
@section('PageTitle') اللغات @endsection
@section('content')
    <div dir="rtl">
        <a href="{{  route('languages.create') }}" class="btn btn-primary">لغة جديدة</a>
        <div style="margin-top: 2rem;">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width: 10%;" class="text-right">الإسم</th>
                    <th style="width: 10%;" class="text-right" dir="ltr">الرمز</th>
                    <th style="width: 40%;" class="text-right" dir="ltr">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($languages as $key => $language)
                    <tr>
                        <td style="font-size: 1.6rem">{{ $language->Name }}</td>
                        <td style="font-size: 1.5rem">{{ $language->Code }}</td>
                        <td style="font-size: 1.5rem">
                            <form method="POST" action="{{ route('languages.destroy', $language->getKey()) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="999">لا توجد لغات</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
