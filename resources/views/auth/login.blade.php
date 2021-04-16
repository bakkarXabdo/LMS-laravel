@extends('layouts.master')

@section('content')
    <h1 class="text-center" style="margin-bottom: 100px">{{ config('app.name', 'Laravel') }}</h1>
    <div class="container" dir="rtl">
        <div class="row vertical-offset-100">
            <div style="max-width: 350px;margin: 0 auto;">
                <div class="panel panel-default">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-heading">
                        <h3 class="panel-title">تسجيل الدخول</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <input style="margin: 0 auto" class="form-control" placeholder="المستخدم" name="username" type="text">
                                </div>
                                <div class="form-group">
                                    <input style="margin: 0 auto" class="form-control" placeholder="كلمة السر" name="password" type="password" value="">
                                </div>
                                <div class="checkbox" style="margin-right: 10px">
                                    <label>
                                        <input class="mx-1" name="remember" type="checkbox" value="Remember Me"> <span style="margin: 0 20px">حفظ الدخول</span>
                                    </label>
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="دخول">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
