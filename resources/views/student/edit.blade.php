@extends('layouts.master')

@section('PageTitle') تعديل الطالب  @endsection


@section('content')

<form dir="rtl" action="{{ route('students.update',  $student->getKey() ) }}" method="post" novalidate="novalidate">
    @csrf
    @method('PUT')
    <h2>تعديل الطالب:  {{ $student->Name }} </h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-group">
        <label for="Customer_Name">الإسم الكامل</label>
        <input class="form-control" data-val="true" data-val-length="Name must be 3-255 Long" data-val-length-max="255" data-val-length-min="3"
                data-val-required="The Name field is required." id="Customer_Name" name="Name" type="text" value="{{ $student->Name }}"
        >
        <span class="field-validation-valid text-danger" data-valmsg-for="Name" data-valmsg-replace="true"></span>
    </div>
    <div class="form-group">
        <label for="Speciality">التخصص</label>
        <input class="form-control" id="Speciality" name="Speciality" value="{{ old('Speciality') ?? $student->Speciality }}">
    </div>
    <div class="form-group">
        <label for="Customer_Birthdate">تاريخ الميلاد</label>
        <input class="form-control" id="Customer_Birthdate" name="BirthDate" type="date" value="{{ \Illuminate\Support\Carbon::parse($student->Birthdate)->format('Y-m-d') }}">
    </div>
    <div class="form-group">
        <label for="Student_Id">الرقم</label>
        <input class="form-control" id="Student_Id" name="{{ Student::KEY }}" type="number" value="{{ $student->getKey() }}">
    </div>
    <button type="submit" class="btn btn-primary">حفظ</button>
    <br/>
    <br/>
    <a href="{{ route('students.index') }}">الرجوع إلي القائمة</a>
</form>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#Speciality').typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "{{ route('students.specialityTypeAhead') }}",
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
