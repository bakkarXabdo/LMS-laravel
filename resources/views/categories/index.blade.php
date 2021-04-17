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
                    <th style="width: 10%;" class="text-right" dir="ltr">عدد الإعارات الجارية</th>
                    <th style="width: 40%;" class="text-right" dir="ltr">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($categories as $key => $category)
                    <tr>
                        <td style="font-size: 1.6rem">{{ $category->Name }}</td>
                        <td style="font-size: 1.5rem">{{ $category->Code }}</td>
                        <td class='bookCount' style="font-size: 1.6rem">{{ $category->books()->count() }}</td>
                        <td class='copyCount' style="font-size: 1.5rem">{{ $category->copies()->count() }}</td>
                        <td class='rentalCount' style="font-size: 1.5rem">{{ $category->rentals()->count() }}</td>
                        <td style="font-size: 1.5rem">
                            <form hidden method="POST" action="{{ route('categories.destroy', $category->getKey()) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a href="#" data-books-count="{{ $category->books()->count() }}" data-id='{{ $category->getKey() }}' class="btn btn-danger delete">حذف</a>
                            <a href="{{ route('categories.edit', $category->getKey()) }}" class="btn btn-primary">تعديل</a>
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

@push('scripts')
    <script>
        $(document).ready(function () {
            $(".delete").click(function () {
                let button = $(this);
                let id = button.data('id');
                let bookCount = button.parents('tr').find('.bookCount').text();
                let copyCount = button.parents('tr').find('.copyCount').text();
                if(button.data('books-count') > 0){
                    bootbox.dialog({
                        title: "تأكيد الحذف",
                        message: `هل تريد فعلا حذف هذه اللغة <span style="color: red">و ${bookCount} كتاب و ${copyCount} نُسخة</span> المتعلقة بها`,
                        backdrop:true,
                        buttons: {
                            confirm: {
                                label: 'حذف',
                                className: 'btn-danger',
                                callback: () => sendDelete(id)
                            },
                            cancel: {
                                label: 'إلغاء',
                                className: 'btn-secondary'
                            }
                        }
                    });
                }else{
                    button.parent().find('form').submit();
                }
            });
        });
        function sendDelete(id)
        {
            $.ajax({
                url: '{{ route('categories.destroy', ':id') }}'.replace(':id', id) ,
                method: "POST",
                data:{
                    _method: "DELETE"
                },
                dataType:"json",
                success: function (data) {
                    if (data.success) {
                        toastr.success(data.message);
                        window.location.reload();
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
    </script>
@endpush
