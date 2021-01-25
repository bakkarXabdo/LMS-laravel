<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('PageTitle') - {{ config('app.brandName') }} </title>
        <link rel="icon"  href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
        <link rel="stylesheet" href="{{asset('css/app.css')}}" >
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/" class="navbar-brand">{{config('app.brandName')}}</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('books.index') }}">Books</a></li>
                        <li><a href="{{ route('customer.index') }}">Customers</a></li>
                        <li><a href="{{ route('rentals.index') }}">Rentals</a></li>
                        <li><a href="{{ route('inventory.index') }}">Inventory</a></li>
                    </ul>
                    @include('layouts._login')
                </div>
            </div>
        </div>


        <div class="container body-content" id="wrapper">
            @yield('content')
            <hr />
            <footer class="text-center">
                <div class="row">
                    <div class="col-lg-3">
                        <p class="d-inline">&copy; {{ date('Y') }} - {{config('app.name')}}</p>
                    </div>
                    <div class="col-lg-1">
                        <a class="nav-link" href="{{ route('pages.about') }}">About</a>
                    </div>
                  </div>
            </footer>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
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
