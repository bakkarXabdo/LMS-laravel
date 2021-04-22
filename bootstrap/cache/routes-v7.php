<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/_debugbar/open' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.openhandler',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/assets/stylesheets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.assets.css',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/assets/javascript' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.assets.js',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/chart/monthly_rentals_count_chart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'charts.monthly_rentals_count_chart',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/chart/books_by_category_chart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'charts.books_by_category_chart',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/chart/books_by_language_chart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'charts.books_by_language_chart',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::422TXMgHVZgDCdU4',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::b4VDqia7pY2WAg1e',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/books/choose' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.choose',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/books/importing' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.importing',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/books/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bookcopies/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bookcopies/choose' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.choose',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bookcopies/typeahead' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.typeahead',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/students/choose' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.choose',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/students/typeahead' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.typeahead',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/students/spciality-type-ahead' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.specialityTypeAhead',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/history/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'history.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/books/table' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.table',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/books/import' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.import',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bookcopies/table' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.table',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rentals/table' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.table',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/students/table' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.table',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/history/exporting' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'history.exporting',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/books' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'books.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/books/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'settings.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bookcopies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bookcopies/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rentals' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rentals/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/students' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'students.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/students/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'history.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'history.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/history/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'history.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'categories.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/languages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'languages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'languages.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/languages/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'languages.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/about' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pages.about',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/_debugbar/(?|c(?|lockwork/([^/]++)(*:42)|ache/([^/]++)(?:/([^/]++))?(*:76))|telescope/([^/]++)(*:102))|/book(?|copies/(?|forBook/([A-Za-z]+\\/\\d+)(*:153)|([A-Za-z]+\\/\\d+\\/\\d+)(*:182)|([A-Za-z]+\\/\\d+\\/\\d+)/edit(*:216)|([A-Za-z]+\\/\\d+\\/\\d+)(?|(*:248)))|s/(?|([A-Za-z]+\\/\\d+)(*:279)|([A-Za-z]+\\/\\d+)/edit(*:308)|([A-Za-z]+\\/\\d+)(?|(*:335))))|/rentals/(?|for(?|book/([A-Za-z]+\\/\\d+)(*:385)|student/([^/]++)(*:409)|copy/([A-Za-z]+\\/\\d+\\/\\d+)(*:443))|return/([^/]++)(*:467)|([^/]++)(?|(*:486)|/edit(*:499)|(*:507)))|/s(?|tudents/(?|password/([^/]++)(*:550)|([^/]++)(?|(*:569)|/edit(*:582)|(*:590)))|ettings/([^/]++)(?|(*:619)|/edit(*:632)|(*:640)))|/history/([^/]++)(?|(*:670)|/edit(*:683)|(*:691))|/categories/([^/]++)(?|/edit(*:728)|(*:736))|/languages/([^/]++)(?|/edit(*:772)|(*:780)))/?$}sDu',
    ),
    3 => 
    array (
      42 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.clockwork',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      76 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.cache.delete',
            'tags' => NULL,
          ),
          1 => 
          array (
            0 => 'key',
            1 => 'tags',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      102 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.telescope',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      153 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.forBook',
          ),
          1 => 
          array (
            0 => 'book',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      182 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.show',
          ),
          1 => 
          array (
            0 => 'bookcopy',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      216 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.edit',
          ),
          1 => 
          array (
            0 => 'bookcopy',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      248 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.update',
          ),
          1 => 
          array (
            0 => 'bookcopy',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'bookcopies.destroy',
          ),
          1 => 
          array (
            0 => 'bookcopy',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      279 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.show',
          ),
          1 => 
          array (
            0 => 'book',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      308 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.edit',
          ),
          1 => 
          array (
            0 => 'book',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      335 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'books.update',
          ),
          1 => 
          array (
            0 => 'book',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'books.destroy',
          ),
          1 => 
          array (
            0 => 'book',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      385 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.forbook',
          ),
          1 => 
          array (
            0 => 'book',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      409 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.forstudent',
          ),
          1 => 
          array (
            0 => 'student',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      443 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.forcopy',
          ),
          1 => 
          array (
            0 => 'bookcopy',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      467 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.return',
          ),
          1 => 
          array (
            0 => 'rental',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      486 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.show',
          ),
          1 => 
          array (
            0 => 'rental',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      499 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.edit',
          ),
          1 => 
          array (
            0 => 'rental',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      507 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.update',
          ),
          1 => 
          array (
            0 => 'rental',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'rentals.destroy',
          ),
          1 => 
          array (
            0 => 'rental',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      550 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.changePassword',
          ),
          1 => 
          array (
            0 => 'student',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      569 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.show',
          ),
          1 => 
          array (
            0 => 'student',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      582 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.edit',
          ),
          1 => 
          array (
            0 => 'student',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      590 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'students.update',
          ),
          1 => 
          array (
            0 => 'student',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'students.destroy',
          ),
          1 => 
          array (
            0 => 'student',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      619 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.show',
          ),
          1 => 
          array (
            0 => 'setting',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      632 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.edit',
          ),
          1 => 
          array (
            0 => 'setting',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      640 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.update',
          ),
          1 => 
          array (
            0 => 'setting',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'settings.destroy',
          ),
          1 => 
          array (
            0 => 'setting',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      670 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'history.show',
          ),
          1 => 
          array (
            0 => 'history',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      683 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'history.edit',
          ),
          1 => 
          array (
            0 => 'history',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      691 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'history.update',
          ),
          1 => 
          array (
            0 => 'history',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'history.destroy',
          ),
          1 => 
          array (
            0 => 'history',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      728 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.edit',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      736 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.update',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'categories.destroy',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      772 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'languages.edit',
          ),
          1 => 
          array (
            0 => 'language',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      780 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'languages.update',
          ),
          1 => 
          array (
            0 => 'language',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'languages.destroy',
          ),
          1 => 
          array (
            0 => 'language',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'debugbar.openhandler' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/open',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@handle',
        'as' => 'debugbar.openhandler',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@handle',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.clockwork' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/clockwork/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@clockwork',
        'as' => 'debugbar.clockwork',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@clockwork',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.telescope' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/telescope/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\TelescopeController@show',
        'as' => 'debugbar.telescope',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\TelescopeController@show',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.assets.css' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/assets/stylesheets',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@css',
        'as' => 'debugbar.assets.css',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@css',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.assets.js' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/assets/javascript',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@js',
        'as' => 'debugbar.assets.js',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@js',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.cache.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => '_debugbar/cache/{key}/{tags?}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\CacheController@delete',
        'as' => 'debugbar.cache.delete',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\CacheController@delete',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'charts.monthly_rentals_count_chart' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/chart/monthly_rentals_count_chart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'charts.monthly_rentals_count_chart',
        'uses' => 'ConsoleTVs\\Charts\\ChartsController@__invoke',
        'controller' => 'ConsoleTVs\\Charts\\ChartsController',
        'prefix' => 'api/chart',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'chart' => 
        App\Charts\MonthlyRentalsCountChart::__set_state(array(
           'middlewares' => 
          array (
            0 => 'App\\Http\\Middleware\\IsAdmin',
          ),
        )),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'charts.books_by_category_chart' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/chart/books_by_category_chart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'charts.books_by_category_chart',
        'uses' => 'ConsoleTVs\\Charts\\ChartsController@__invoke',
        'controller' => 'ConsoleTVs\\Charts\\ChartsController',
        'prefix' => 'api/chart',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'chart' => 
        App\Charts\BooksByCategoryChart::__set_state(array(
           'middlewares' => 
          array (
            0 => 'App\\Http\\Middleware\\IsAdmin',
          ),
        )),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'charts.books_by_language_chart' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/chart/books_by_language_chart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'charts.books_by_language_chart',
        'uses' => 'ConsoleTVs\\Charts\\ChartsController@__invoke',
        'controller' => 'ConsoleTVs\\Charts\\ChartsController',
        'prefix' => 'api/chart',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'chart' => 
        App\Charts\BooksByLanguageChart::__set_state(array(
           'middlewares' => 
          array (
            0 => 'App\\Http\\Middleware\\IsAdmin',
          ),
        )),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::422TXMgHVZgDCdU4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:api',
        ),
        'uses' => 'C:32:"Opis\\Closure\\SerializableClosure":291:{@KUuJQcc2lmmHXNE61EWM4IEvyvu9NzSAgKjI2mbC4KY=.a:5:{s:3:"use";a:0:{}s:8:"function";s:79:"function (\\Illuminate\\Http\\Request $request) {
    return $request->user();
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000003aaeb9c4000000002d96342f";}}',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::422TXMgHVZgDCdU4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::b4VDqia7pY2WAg1e' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'generated::b4VDqia7pY2WAg1e',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\DashboardController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.choose' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'books/choose',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BooksController@choose',
        'controller' => 'App\\Http\\Controllers\\BooksController@choose',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'books.choose',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.importing' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'books/importing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BooksController@importing',
        'controller' => 'App\\Http\\Controllers\\BooksController@importing',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'books.importing',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'books/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BooksController@export',
        'controller' => 'App\\Http\\Controllers\\BooksController@export',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'books.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@export',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@export',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'bookcopies.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.forBook' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies/forBook/{book}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@forBook',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@forBook',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'bookcopies.forBook',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.choose' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies/choose',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@choose',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@choose',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'bookcopies.choose',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.typeahead' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies/typeahead',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@typeahead',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@typeahead',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'bookcopies.typeahead',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.forbook' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rentals/forbook/{book}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\RentalsController@forBook',
        'controller' => 'App\\Http\\Controllers\\RentalsController@forBook',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'rentals.forbook',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.forstudent' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rentals/forstudent/{student}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\RentalsController@forStudent',
        'controller' => 'App\\Http\\Controllers\\RentalsController@forStudent',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'rentals.forstudent',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.forcopy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rentals/forcopy/{bookcopy}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\RentalsController@forCopy',
        'controller' => 'App\\Http\\Controllers\\RentalsController@forCopy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'rentals.forcopy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.choose' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'students/choose',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\StudentsController@choose',
        'controller' => 'App\\Http\\Controllers\\StudentsController@choose',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'students.choose',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.typeahead' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'students/typeahead',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\StudentsController@typeahead',
        'controller' => 'App\\Http\\Controllers\\StudentsController@typeahead',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'students.typeahead',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.specialityTypeAhead' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'students/spciality-type-ahead',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\StudentsController@specialityTypeAhead',
        'controller' => 'App\\Http\\Controllers\\StudentsController@specialityTypeAhead',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'students.specialityTypeAhead',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'history/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@export',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@export',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'history.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.table' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'books/table',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BooksController@table',
        'controller' => 'App\\Http\\Controllers\\BooksController@table',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'books.table',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.import' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'books/import',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BooksController@import',
        'controller' => 'App\\Http\\Controllers\\BooksController@import',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'books.import',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.table' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bookcopies/table',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@table',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@table',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'bookcopies.table',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.table' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rentals/table',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\RentalsController@table',
        'controller' => 'App\\Http\\Controllers\\RentalsController@table',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'rentals.table',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.return' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rentals/return/{rental}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\RentalsController@returnRental',
        'controller' => 'App\\Http\\Controllers\\RentalsController@returnRental',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'rentals.return',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.changePassword' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'students/password/{student}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\StudentsController@changePassword',
        'controller' => 'App\\Http\\Controllers\\StudentsController@changePassword',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'students.changePassword',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.table' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'students/table',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\StudentsController@table',
        'controller' => 'App\\Http\\Controllers\\StudentsController@table',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'students.table',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.exporting' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'history/exporting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@exporting',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@exporting',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'history.exporting',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'books',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'books.index',
        'uses' => 'App\\Http\\Controllers\\BooksController@index',
        'controller' => 'App\\Http\\Controllers\\BooksController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'books/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'books.create',
        'uses' => 'App\\Http\\Controllers\\BooksController@create',
        'controller' => 'App\\Http\\Controllers\\BooksController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'books',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'books.store',
        'uses' => 'App\\Http\\Controllers\\BooksController@store',
        'controller' => 'App\\Http\\Controllers\\BooksController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'books/{book}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'books.show',
        'uses' => 'App\\Http\\Controllers\\BooksController@show',
        'controller' => 'App\\Http\\Controllers\\BooksController@show',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'books/{book}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'books.edit',
        'uses' => 'App\\Http\\Controllers\\BooksController@edit',
        'controller' => 'App\\Http\\Controllers\\BooksController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'books/{book}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'books.update',
        'uses' => 'App\\Http\\Controllers\\BooksController@update',
        'controller' => 'App\\Http\\Controllers\\BooksController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'books.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'books/{book}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'books.destroy',
        'uses' => 'App\\Http\\Controllers\\BooksController@destroy',
        'controller' => 'App\\Http\\Controllers\\BooksController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'settings.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'settings.index',
        'uses' => 'App\\Http\\Controllers\\SettingsController@index',
        'controller' => 'App\\Http\\Controllers\\SettingsController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'settings.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'settings.create',
        'uses' => 'App\\Http\\Controllers\\SettingsController@create',
        'controller' => 'App\\Http\\Controllers\\SettingsController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'settings.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'settings.store',
        'uses' => 'App\\Http\\Controllers\\SettingsController@store',
        'controller' => 'App\\Http\\Controllers\\SettingsController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'settings.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/{setting}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'settings.show',
        'uses' => 'App\\Http\\Controllers\\SettingsController@show',
        'controller' => 'App\\Http\\Controllers\\SettingsController@show',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'settings.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/{setting}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'settings.edit',
        'uses' => 'App\\Http\\Controllers\\SettingsController@edit',
        'controller' => 'App\\Http\\Controllers\\SettingsController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'settings.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'settings/{setting}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'settings.update',
        'uses' => 'App\\Http\\Controllers\\SettingsController@update',
        'controller' => 'App\\Http\\Controllers\\SettingsController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'settings.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'settings/{setting}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'settings.destroy',
        'uses' => 'App\\Http\\Controllers\\SettingsController@destroy',
        'controller' => 'App\\Http\\Controllers\\SettingsController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'bookcopies.index',
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@index',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'bookcopies.create',
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@create',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bookcopies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'bookcopies.store',
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@store',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies/{bookcopy}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'bookcopies.show',
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@show',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@show',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookcopies/{bookcopy}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'bookcopies.edit',
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@edit',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'bookcopies/{bookcopy}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'bookcopies.update',
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@update',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'bookcopies.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'bookcopies/{bookcopy}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'bookcopies.destroy',
        'uses' => 'App\\Http\\Controllers\\BookCopiesController@destroy',
        'controller' => 'App\\Http\\Controllers\\BookCopiesController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rentals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'rentals.index',
        'uses' => 'App\\Http\\Controllers\\RentalsController@index',
        'controller' => 'App\\Http\\Controllers\\RentalsController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rentals/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'rentals.create',
        'uses' => 'App\\Http\\Controllers\\RentalsController@create',
        'controller' => 'App\\Http\\Controllers\\RentalsController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rentals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'rentals.store',
        'uses' => 'App\\Http\\Controllers\\RentalsController@store',
        'controller' => 'App\\Http\\Controllers\\RentalsController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rentals/{rental}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'rentals.show',
        'uses' => 'App\\Http\\Controllers\\RentalsController@show',
        'controller' => 'App\\Http\\Controllers\\RentalsController@show',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rentals/{rental}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'rentals.edit',
        'uses' => 'App\\Http\\Controllers\\RentalsController@edit',
        'controller' => 'App\\Http\\Controllers\\RentalsController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'rentals/{rental}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'rentals.update',
        'uses' => 'App\\Http\\Controllers\\RentalsController@update',
        'controller' => 'App\\Http\\Controllers\\RentalsController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'rentals.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'rentals/{rental}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'rentals.destroy',
        'uses' => 'App\\Http\\Controllers\\RentalsController@destroy',
        'controller' => 'App\\Http\\Controllers\\RentalsController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'students',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'students.index',
        'uses' => 'App\\Http\\Controllers\\StudentsController@index',
        'controller' => 'App\\Http\\Controllers\\StudentsController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'students/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'students.create',
        'uses' => 'App\\Http\\Controllers\\StudentsController@create',
        'controller' => 'App\\Http\\Controllers\\StudentsController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'students',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'students.store',
        'uses' => 'App\\Http\\Controllers\\StudentsController@store',
        'controller' => 'App\\Http\\Controllers\\StudentsController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'students/{student}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'students.show',
        'uses' => 'App\\Http\\Controllers\\StudentsController@show',
        'controller' => 'App\\Http\\Controllers\\StudentsController@show',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'students/{student}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'students.edit',
        'uses' => 'App\\Http\\Controllers\\StudentsController@edit',
        'controller' => 'App\\Http\\Controllers\\StudentsController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'students/{student}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'students.update',
        'uses' => 'App\\Http\\Controllers\\StudentsController@update',
        'controller' => 'App\\Http\\Controllers\\StudentsController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'students.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'students/{student}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'students.destroy',
        'uses' => 'App\\Http\\Controllers\\StudentsController@destroy',
        'controller' => 'App\\Http\\Controllers\\StudentsController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'history.index',
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@index',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'history/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'history.create',
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@create',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'history.store',
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@store',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'history/{history}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'history.show',
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@show',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@show',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'history/{history}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'history.edit',
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@edit',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'history/{history}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'history.update',
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@update',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'history.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'history/{history}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'history.destroy',
        'uses' => 'App\\Http\\Controllers\\RentalHistoryController@destroy',
        'controller' => 'App\\Http\\Controllers\\RentalHistoryController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'categories.index',
        'uses' => 'App\\Http\\Controllers\\BookCategoryController@index',
        'controller' => 'App\\Http\\Controllers\\BookCategoryController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'categories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'categories.create',
        'uses' => 'App\\Http\\Controllers\\BookCategoryController@create',
        'controller' => 'App\\Http\\Controllers\\BookCategoryController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'categories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'categories.store',
        'uses' => 'App\\Http\\Controllers\\BookCategoryController@store',
        'controller' => 'App\\Http\\Controllers\\BookCategoryController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'categories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'categories/{category}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'categories.edit',
        'uses' => 'App\\Http\\Controllers\\BookCategoryController@edit',
        'controller' => 'App\\Http\\Controllers\\BookCategoryController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'categories.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'categories.update',
        'uses' => 'App\\Http\\Controllers\\BookCategoryController@update',
        'controller' => 'App\\Http\\Controllers\\BookCategoryController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'categories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'categories.destroy',
        'uses' => 'App\\Http\\Controllers\\BookCategoryController@destroy',
        'controller' => 'App\\Http\\Controllers\\BookCategoryController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'languages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'languages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'languages.index',
        'uses' => 'App\\Http\\Controllers\\BookLanguageController@index',
        'controller' => 'App\\Http\\Controllers\\BookLanguageController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'languages.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'languages/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'languages.create',
        'uses' => 'App\\Http\\Controllers\\BookLanguageController@create',
        'controller' => 'App\\Http\\Controllers\\BookLanguageController@create',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'languages.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'languages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'languages.store',
        'uses' => 'App\\Http\\Controllers\\BookLanguageController@store',
        'controller' => 'App\\Http\\Controllers\\BookLanguageController@store',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'languages.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'languages/{language}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'languages.edit',
        'uses' => 'App\\Http\\Controllers\\BookLanguageController@edit',
        'controller' => 'App\\Http\\Controllers\\BookLanguageController@edit',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'languages.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'languages/{language}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'languages.update',
        'uses' => 'App\\Http\\Controllers\\BookLanguageController@update',
        'controller' => 'App\\Http\\Controllers\\BookLanguageController@update',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'languages.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'languages/{language}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'App\\Http\\Middleware\\IsAdmin',
        ),
        'as' => 'languages.destroy',
        'uses' => 'App\\Http\\Controllers\\BookLanguageController@destroy',
        'controller' => 'App\\Http\\Controllers\\BookLanguageController@destroy',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'pages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PagesController@index',
        'controller' => 'App\\Http\\Controllers\\PagesController@index',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'pages.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'pages.about' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'about',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PagesController@about',
        'controller' => 'App\\Http\\Controllers\\PagesController@about',
        'namespace' => NULL,
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'pages.about',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'book' => '^[A-Za-z]+\\/\\d+$',
        'bookcopy' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
        'bookId' => '^[A-Za-z]+\\/\\d+$',
        'bookCopyId' => '^[A-Za-z]+\\/\\d+\\/\\d+$',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
  ),
)
);
