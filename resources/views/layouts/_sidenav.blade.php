<nav id="sidebar">
    <div class="sidebar-header">
        <h3 class="text-center">Library Management System</h3>
        <strong><b>L</b>MS</strong>
    </div>
    <ul class="list-unstyled components">
        <li class="active">
            <a href="#bookSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="glyphicon glyphicon-list-alt"></i>
                Books
            </a>
            <ul class="collapse list-unstyled" id="bookSubmenu">
                <li>
                    <a href="addBooks">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span class="sidebar-text">Add New Book</span>
                        <span class="sidebar-text" style="display: none;">Add</span>
                    </a>
                </li>
                <li>
                    <a href="booksList">
                        <i class="glyphicon glyphicon-list"></i>
                        <span class="sidebar-text">Book List</span>
                        <span class="sidebar-text" style="display: none;">List</span>
                    </a>
                </li>
                <li>
                    <a href="categoriesList">
                        <i class="glyphicon glyphicon-tags"></i>
                        <span class="sidebar-text">Category Wise books</span>
                        <span class="sidebar-text" style="display: none;">Category</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#catSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="glyphicon glyphicon-tags"></i>
                Categories
            </a>
            <ul class="collapse list-unstyled" id="catSubmenu">
                <li>
                    <a href="addCategories">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span class="sidebar-text">Add New Category</span>
                        <span class="sidebar-text" style="display: none;">Add</span>
                    </a>
                </li>
                <li>
                    <a href="categoriesList">
                        <i class="glyphicon glyphicon-list"></i>
                        <span class="sidebar-text">Category List</span>
                        <span class="sidebar-text" style="display: none;">List</span>
                    </a>
                </li>
            </ul>
        </li>
        <li >
            <a href="#issueBookSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="glyphicon glyphicon-share"></i>
                <span class="sidebar-text">Book Rentals</span>
                <span class="sidebar-text" style="display: none;">Rentals</span>
                <span></span>
            </a>
            <ul class="collapse list-unstyled" id="issueBookSubmenu">
                <li>
                    <a href="issueBooks">
                        <i class="glyphicon glyphicon-check"></i>
                        <span class="sidebar-text">New Rental</span>
                        <span class="sidebar-text" style="display: none;">New</span>
                    </a>
                </li>
                <li>
                    <a href="issuedBooks">
                        <i class="glyphicon glyphicon-ok"></i>
                        <span class="sidebar-text">Rented Books</span>
                        <span class="sidebar-text" style="display: none;">List</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#memberSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="glyphicon glyphicon-user"></i>
                Customers
            </a>
            <ul class="collapse list-unstyled" id="memberSubmenu">
                <li>
                    <a href="addMembers">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span class="sidebar-text">Add New Customer</span>
                        <span class="sidebar-text" style="display: none;">Add</span>
                    </a>
                </li>
                <li>
                    <a href="membersList">
                        <i class="glyphicon glyphicon-list"></i>
                        <span class="sidebar-text">Customers List</span>
                        <span class="sidebar-text" style="display: none;">List</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#thesisSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="glyphicon glyphicon-education"></i>
                Thesis
            </a>
            <ul class="collapse list-unstyled" id="thesisSubmenu">
                <li>
                    <a href="addThesis">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span class="sidebar-text">Add New Thesis</span>
                        <span class="sidebar-text" style="display: none;">Add</span>
                    </a>
                </li>
                <li>
                    <a href="thesisList">
                        <i class="glyphicon glyphicon-list"></i>
                        <span class="sidebar-text">Thesis List</span>
                        <span class="sidebar-text" style="display: none;">List</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Page Content Holder -->
<div class="" id="nav-controller">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header px-4 mx-auto flex flex-col md:flex-row items-center justify-between">
                <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                    <i class="glyphicon glyphicon-align-left"></i>
                    <span>Toggle Sidebar</span>
                </button>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item"><a class="nav-link" href="/">Go Front</a></li>
                </ul>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>