@extends('layouts.master')

@section('PageTitle') New Rental @endsection


@section('content')
    <h2>New Rental</h2>
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
    <div class="container">
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
            <div class="row">
                <div class="col-sm-6">
                    @if ($customer != null)
                    <table class="table table-condensed">
                        <tr>
                            <th>الرقم</th>
                            <td>{{ $customer->CardId }}</td>
                        </tr>
                        <tr>
                            <th>الإسم</th>
                            <td style="font-size: large; font-weight: bold">{{ $customer->Name }}</td>
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
            </div>
            <div class="row" dir="rtl">
                <div class="col-sm-6">
                    <input name="{{ \App\Models\Student::FOREIGN_KEY }}" class="form-control text-right" id="typeahead-student" placeholder="رقم الطالب">
                </div>
                <div class="col-sm-6">
                    <input name="{{ \App\Models\BookCopy::FOREIGN_KEY }}" class="form-control text-right typeahead" id="typeahead-copy" placeholder="الشفرة">
                </div>
            </div>
            <div class="row" dir="rtl">

                <div class="col-sm-6">
                    <a class="btn btn-primary my-2" href="{{ route('students.choose', ["copyId" => isset($copy) ? $copy->Id : 'false']) }}">{{ isset($customer) ? "تغيير" : "إختيار" }}</a>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary my-2" href="{{ route('books.choose', ["customerId" => isset($customer) ? $customer->Id : 'false']) }}">{{ isset($copy) ? "تغيير" : "إختيار" }}</a>
                </div>
            </div>
            <hr />
            <div class="form-group">
                <label class="h4">مدة الإعارة(أيام)</label>
                <input value="15" type="number" min="1" class="form-control" name="duration" />
            </div>
            <input name="confirming" value="{{ $confirming ?? 'true' }}" hidden />
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> تأكيد</button>
        </form>
    </div>

@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
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