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
            {{-- <div class="row" dir="rtl">
                <div class="col-sm-6">
                    @if ($student != null)
                    <table class="table table-condensed">
                        <tr>
                            <th>الرقم</th>
                            <td>{{ $student->getKey() }}</td>
                        </tr>
                        <tr>
                            <th>الإسم</th>
                            <td style="font-size: large; font-weight: bold">{{ $student->Name }}</td>
                        </tr>
                    </table>
                    @endif
                </div>
                <div class="col-sm-6">
                    @if($copy != null)
                        <table class="table table-condensed">
                            <tr>
                                <th>الشفرة</th>
                                <td>{{ $copy->getKey() }}</td>
                            </tr>
                            <tr>
                                <th>العُنوان</th>
                                <td style="font-size: large; font-weight: bold">{{ $copy->book->Title }}</td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div> --}}
            <div class="row" >
                <div class="col-sm-6">
                    <input autocomplete="off" name="{{ \App\Models\Student::FOREIGN_KEY }}" class="form-control text-right" id="typeahead-student" placeholder="رقم الطالب" value="{{ request()->get('studentId') ?? (isset($student->Id) ? $student->Id : '') }}">
                </div>
                <div class="col-sm-6">
                    <input autocomplete="off" name="{{ \App\Models\BookCopy::FOREIGN_KEY }}" class="form-control text-right typeahead" id="typeahead-copy" placeholder="الشفرة" value="{{ request()->get('copyId') ?? (isset($copy->Id) ? $copy->Id : '')}}">
                </div>
            </div>
            <hr />
            <div class="form-group">
                <label class="h4">مدة الإعارة(أيام)</label>
                <input type="number" min="1" class="form-control" name="duration" value="{{ Cache::get('last-rental-duration') ?? '15'  }}"/>
            </div>
            <input name="confirming" value="{{ $confirming ?? 'true' }}" hidden />
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> تأكيد</button>
        </form>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#typeahead-copy').typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "{{ route('bookcopies.typeahead') }}",
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
                        url: "{{ route('students.typeahead') }}",
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
