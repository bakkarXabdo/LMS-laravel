@extends('layouts.master')
@section('PageTitle') {{ request('language') || request('category') || request('term') ? "Search" : "Home"  }} @endsection
@section('content')
    <h1 class="jumbotron text-center">{{config('app.name')}}</h1>
    <div>
        <form action="{{ route('pages.index', ["language" => request('language') , "category" => request('category')]) }}" method="get">
            {{-- <h5>make a search</h5> --}}
            <div>
                <div style="margin: 0 auto;width: fit-content">
                    <div style="display: inline-block; vertical-align: middle;">
                        <div class="input-group">
                            <input style="width: 250px;" type="text" class="form-control" required placeholder="Search by Title or Author" name="term" id="term" value="{{ request('term') }}">
                            <span class="input-group-btn" style="width: auto">
                                <button class="btn btn-default" type="submit">Search</button>
                            </span>
                            @if(request('language'))
                                <input name="language" hidden value="{{ request('language') }}">
                            @endif
                            @if(request('category'))
                                <input name="category" hidden value="{{ request('category') }}">
                            @endif
                        </div>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="categories-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                {{ isset($filterCategory) ? $filterCategory->Name : "Category" }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categories-dropdown">
                                @if(isset($filterCategory))
                                    <li><a class="dropdown-item" href="{{ route('pages.index', ["term" => request('term'), "language" => request('language')]) }}">Reset <span class="glyphicon glyphicon-repeat"></span></a></li>
                                @endif
                                @foreach($categories as $category)
                                    @if(isset($filterCategory) &&  $filterCategory->getKey() == $category->getKey())
                                        @continue
                                    @endif
                                    <li>
                                        <a href="{{ route('pages.index', ["language" => request('language'), "term" => request('term'), "category" => $category->getKey()]) }}">{{ $category->Name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="categories-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                {{ isset($filterLanguage) ? $filterLanguage->Name : "Language" }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categories-dropdown">
                                @if(isset($filterLanguage))
                                    <li><a class="dropdown-item" href="{{ route('pages.index', ["term" => request('term'), "category" => request('category')]) }}">Reset <span class="glyphicon glyphicon-repeat"></span></a></li>
                                @endif
                                @foreach ($languages as $language)
                                        @if(isset($filterLanguage) &&  $filterLanguage->getKey() == $language->getKey())
                                            @continue
                                        @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('pages.index', ["language" => $language->getKey(), "term" => request('term'), "category" => request('category')]) }}">{{ $language->Name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if(isset($filterLanguage) || isset($filterCategory) || request('term'))
                        <div style="display: inline-block; vertical-align: middle;">
                            <a href="{{ route('pages.index') }}" class="btn btn-default dropdown-toggle" type="button" >Reset <span class="glyphicon glyphicon-repeat"></span></a>
                        </div>
                    @endif
                </div>
            </div>
        </form>
        @if($results)
            <div style="margin-top: 2rem;">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Language</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($results as $key => $book)
                        @if($splits->contains($key + $results->firstItem() - 1))
                            <tr>
                                <td colspan="99" style="background-color: rgb(238 238 238);"></td>
                            </tr>
                        @else
                            <tr>
                                <td>{{$book->Id}}</td>
                                <td>{{$book->Title}}</td>
                                <td>{{$book->Authors}}</td>
                                <td>{{ $book->category->Name}}</td>
                                <td>{{ $book->language->Name}}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">No Results</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div>
                    <div style="padding: 10px;"  class="text-center">
                        {{$results->withQueryString()->links()}}
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection