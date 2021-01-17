<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('PageTitle') - {{ config('app.brandName') }} </title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
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
                    <a href="{{ route('home') }}" class="navbar-brand">{{config('app.brandName')}}</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('books.index') }}">Books</a></li>
                        <li><a href="#">Customers</a></li>
                        <li><a href="#">Rentals</a></li>
                        <li><a href="#">Inventory</a></li>
                    </ul>
                    @include('layouts._login')
                </div>
            </div>
        </div>


        <div class="container body-content" id="wrapper">
            @yield('content')
            <hr />
            <footer>
                <p>&copy; {{ date('Y') }} - {{config('app.name')}}</p>
            </footer>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>