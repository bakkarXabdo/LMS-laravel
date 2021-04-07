@extends('layouts.master')

@section('PageTitle') {{ $book->Title }} @endsection

@section('content')

    <br /><br />
    <h4>تفاصيل الكتاب</h4>
    <table class="table table-responsive table-bordered">
        <tr class="d-flex">
            <th class="col-sm-2">العُنوان</th>
            <td>{{ $book->Title }}</td>
        </tr>
        <tr>
            <th>المؤلف</th>
            <td>{{ $book->Authors }}</td>
        </tr>
        <tr>
            <th>الصِنف</th>
            <td>{{ $book->category->Name }}</td>
        </tr>
        <tr>
            <th>اللغة</th>
            <td>{{ $book->language->Name }}</td>
        </tr>
        <tr>
            <th>تاريخ الإصدار</th>
            <td>{{ $book->ReleaseYear }}</td>
        </tr>
        <tr>
            <th>تاريخ الإضافة</th>
            <td>{{\Illuminate\Support\Carbon::parse($book->DateAdded)->format('d-m-Y H:i:s') }}</td>
        </tr>

        <tr>
            <th>نُسخ الكتاب</th>
            <td>
                @if ($book->NumberInStock === 0)
                    <span class="text-danger">لا يوجد نُسخ</span>
                @else
                    <a href="{{ route('bookcopies.index', ["bookId" => $book->getKey()]) }}">
                        {{ $book->NumberInStock }}  نُسخة
                    </a>
                @endif
            </td>
        </tr>
        <tr>
            <th>النُسخ المعارة</th>
            <td>
                @if ($book->RentalsCount > 0)
                    <a href="{{ route('rentals.forbook', $book->getKey()) }}">{{ $book->RentalsCount }}  نُسخة </a>
                @else
                    لا يوجد
                @endif
            </td>
        </tr>
        <tr>
            <th>النُسخ المُتوفِرة</th>
            <td>
                @if ($book->NumberInStock == 0)
                    <span class="text-danger">الكِتاب بِدون نُسخ</span>
                @elseif($book->NumberAvailable > 0)
                    {{ $book->NumberAvailable }}
                @else
                    <span class="text-danger">كُل النُسخ مُعارة</span>
                @endif
            </td>
        </tr>
    </table>
    <h4>الإجرائات</h4>
    <hr />
    <div class="row" style="margin-left:0">
        @php
            $url = route('bookcopies.choose', ['bookId' => $book->getKey()]);
        @endphp
        @if ($book->NumberAvailable > 0)
            @if($book->NumberAvailable == 1)
                @php
                    $copy = \App\Models\BookCopy::where(\App\Models\BookCopy::KEY, $book->getKeyName())->whereDoesntHave('rental')->first();
                    $url = route('rentals.create', ['copyId' => $copy->getKey()]);
                @endphp
            @endif
            <a href="{{ $url }}" class="btn btn-primary">إعارة</a>
        @endif
        <a href="{{ route('bookcopies.create', ["bookId" => $book->getKey()]) }}" class="btn btn-{{ $book->NumberAvailable > 0 ? "primary" : "success" }}">إضافة نُسخة</a>
        <a href="{{ route('books.edit', $book->getKey()) }}" class="btn btn-primary">تعديل</a>
        <a href="#" id="delete-book" class="btn btn-danger">حذف</a>
    </div>
    <br />
    <a href="{{ route('books.index') }}">الرجوع إلى القائمة</a>

@endsection

@push('scripts')
    <script>
        $("#delete-book").on("click",  function () {
            var button = $(this);
            bootbox.dialog({
                title: "Confirm Your Action",
                message: `
                        @if($book->NumberInStock > 1)
                            <span>This Book Has <a href="{{ route('bookcopies.index', ["bookId" => $book->getKey()]) }}">{{ $book->NumberInStock }} Copies</a>, Are you sure You want To Delete Them All?</span>
                        @else
                            <span>Delete <strong>{{ $book->Title }}</strong> ?</span>
                        @endif`,
                backdrop:true,
                buttons: {
                    confirm: {
                        label: 'Delete',
                        className: 'btn-danger',
                        callback: function () {
                            $.ajax({
                                url: '{{ route('books.destroy', $book->getKey()) }}',
                                data:{
                                    _method: "DELETE"
                                },
                                method: "POST",
                                dataType:"json",
                                success: function (data) {
                                    if (data.success) {
                                        toastr.success(data.message);
                                        location.href = document.referrer;
                                    } else {
                                        toastr.error(data.message);
                                    }
                                }
                            })
                        }
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-secondary'
                    }

                }
            });
            return false;
        });
    </script>
@endpush
