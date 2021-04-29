@extends('layouts.master')

@section('PageTitle') New Rental @endsection


@section('content')

    <div class="container" dir="rtl">
        <h2>إعارة جديدة</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <hr />
        <form action="{{ route('rentals.store') }}" method="post">
            @csrf
            <div class="row" dir="rtl">
                <div class="col-sm-6">
                    <h4>الطالب</h4>
                </div>
                <div class="col-sm-6">
                    <h4>النُسخة</h4>
                </div>
            </div>
            <div class="row" dir="rtl">
                <div class="col-sm-6">
                    @if ($student != null)
                    <table class="table table-condensed">
                        <tr>
                            <th class="text-right">الرقم</th>
                            <td>{{ $student->getKey() }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">الإسم</th>
                            <td>{{ $student->Name }}</td>
                        </tr>
                    </table>
                    @endif
                </div>
                <div class="col-sm-6">
                    @if($copy != null)
                        <table class="table table-condensed">
                            <tr>
                                <th class="text-right">الشفرة</th>
                                <td>{{ $copy->getKey() }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">العُنوان</th>
                                <td >{{ $copy->book->Title }}</td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
            <div @if($confirming) hidden @endif>
                <div class="row" >
                    <div class="col-sm-6">
                        @php
                            $value = "";
                            if(!empty(request(Student::urlname())))
                            {
                                $value = request(Student::urlname());
                            }else if(!empty(old(Student::urlname())))
                            {
                                $value = old(Student::urlname());
                            }else if($student && !empty($student->getKey()))
                            {
                                $value = $student->getKey();
                            }
                        @endphp
                        <input autocomplete="off" name="{{ Student::urlname() }}" class="form-control text-right" id="typeahead-student"
                         placeholder="رقم الطالب" value="{{ $value }}">
                    </div>
                    <div class="col-sm-6">
                        @php
                            $value = "";
                            if(!empty(request(BookCopy::urlname())))
                            {
                                $value = request(BookCopy::urlname());
                            }else if(!empty(old(BookCopy::urlname())))
                            {
                                $value = old(BookCopy::urlname());
                            }else if($copy && !empty($copy->getKey()))
                            {
                                $value = $copy->getKey();
                            }
                        @endphp
                        <input autocomplete="off" name="{{ BookCopy::urlname() }}" class="form-control text-right typeahead" id="typeahead-copy"
                         placeholder="الشفرة" value="{{ $value }}">
                    </div>
                </div>
                <hr />
            </div>
            <div class="form-group">
                <label class="h4">مدة الإعارة(أيام)</label>
                <input type="number" @if($confirming) readonly @endif  class="form-control" name="duration" value="{{ request()->get('duration') ?? (Cache::get('last-rental-duration') ?? '15')   }}"/>
            </div>
            <input name="confirming" value="{{ $confirming }}" hidden />
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ $confirming ? "تأكيد" : "متابعة" }}</button>
        </form>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#typeahead-copy').typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "{{ route('typeahead.copyId') }}",
                        method: "GET",
                        data: {query: query},
                        dataType: "json",
                        success: data => result(data)
                    })
                }
            });
            $('#typeahead-student').typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "{{ route('typeahead.studentId') }}",
                        method: "GET",
                        data: {query: query},
                        dataType: "json",
                        success: data => result(data)
                    })
                }
            });
        });
    </script>
@endpush
