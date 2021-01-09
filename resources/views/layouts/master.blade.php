<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('PageTitle') - {{ config('app.name', 'Laravel') }} </title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div class="wrapper">
            @include('layouts._sidenav')
            <main id="content">
                @yield('content')
            </main>
        </div>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                     $('.sidebar-text').toggle();
                 });
             });
         </script>
    </body>
</html>
