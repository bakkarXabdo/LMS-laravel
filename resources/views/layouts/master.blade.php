<!DOCTYPE html>
<html lang='ar'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="lang" content="">
        <title> @yield('PageTitle') - {{ config('app.name') }} </title>
        <link rel="icon"  href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
        <link rel="stylesheet" href="{{asset('css/app.css')}}" >
        {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
        {{-- <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet"> --}}
        @stack('src')
    </head>
    <body lang='ar'>
        <div  class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/" class="navbar-brand">{{config('app.brandName')}}</a>
                </div>
                <div class="navbar-collapse collapse" >
                    <ul class="nav navbar-nav">
                        @auth
                            @if(Auth::user()->IsAdmin)
                                <li><a href="{{ route('books.index') }}">الكُتب</a></li>
                                <li><a href="{{ route('bookcopies.index') }}">النُسخ</a></li>
                                <li><a href="{{ route('students.index') }}">الطُلاب</a></li>
                                <li><a href="{{ route('rentals.index') }}">الإعارات</a></li>
                                <li><a href="{{ route('history.index') }}">الأرشيف</a></li>
                                <li><a href="{{ route('languages.index') }}">اللغات</a></li>
                                <li><a href="{{ route('categories.index') }}">الفئات</a></li>
        {{--                            <li><a href="{{ route('settings') }}">الإعدادات</a></li>--}}
                            @else
                                <li><a href="{{ route('studentPages.rentals') }}">الإعارات الجارية</a></li>
                                <li><a href="{{ route('studentPages.history') }}">أرشيف الإعارات</a></li>
                            @endif
                        @endauth
                    </ul>
                    @include('layouts._login')
                </div>
            </div>
        </div>


        <div style="min-height: 100vh"class="container body-content" id="wrapper" >
            <div style="min-height: 90vh;padding-top:20px">
                @yield('content')
            </div>
            <hr />
            <footer class="text-center">
                <div class="row">
                    <div class="col-lg-3">
                        <p class="d-inline">&copy; {{ date('Y') }} - {{config('app.name')}}</p>
                    </div>
                    <div class="col-lg-1">
                        <a class="nav-link" href="{{ route('pages.about') }}">حول الموقع</a>
                    </div>
                    <div class="col-lg-1">
                        <a class="nav-link" href="{{ route('pages.terms') }}">الشروط و الأحكام</a>
                    </div>
                  </div>
            </footer>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $.fn.dataTable.ext.errMode = 'none';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            toastr.options = {
                "timeOut": "4000",
                "extendedTimeOut": "2000"
            };
        </script>
        @stack('scripts')
    </body>
</html>
