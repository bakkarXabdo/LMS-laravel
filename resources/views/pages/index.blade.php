@extends('layouts.master')

@section('content')
<h1>Search form</h1>
<div style="height: 400px">
  <form action="{{url('/search')}}" method="get" class="form-container">
    <input
    type="search"
    name="search_query"
    class="input-container"
    autocomplete="off"
    placeholder="Search by Title or Author..."
    />
    <i class="fa fa-search"></i>
    <h5>or filter by Language</h5>
    <div class="drop-container">
      <ul>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" href="#">Languages</a>
          <ul class="dropdown-menu">
            @foreach ($langs as $lang)
            <li><a class="dropdown-item" href="/filter/{{ $lang->Id }}">{{ $lang->Name}}</a></li>
            @endforeach
          </ul>
        </li>
      </ul>
    </div>
  </form>
</div>
@include('pages.search')
@include('pages.filter')
<style>
  .drop-container {
    border: 2px solid gray;
    border-radius: 10px;
    background-color: white;
    padding-left: -40px;
  }
  .drop-container:hover {
  }
  .drop-container ul {

  }
  .drop-container ul li {
    float: left;
    list-style: none;
    position: relative;
  }
  .drop-container ul li a {
    display: block;
    font-family: Arial, Helvetica, sans-serif;
    color: #222;
    padding: 14px 34px 14px 0px;
    text-decoration: none;
  }
  .drop-container ul li ul {
    display: none;
    position: absolute;
    background-color: white;
    border-radius: 0px 0px 4px 4px;
  }
  .drop-container ul li ul li {
    width: 180px;
  }
  .drop-container ul li ul li a {
    padding: 8px;
  }
  .drop-container ul li ul li a:hover {
    background-color: #f3f3f3; 
  }
  .form-container {
    position: relative;
    display: flex;
    text-align: center;
    padding-top: 100px;
    padding-left: 20%;

  }
  .input-container {
      align-items: center;
    width: 50%;
    padding: 12px 32px;
    border: 2px solid gray;
    border-radius: 10px;
    outline: none;
    color: rgb(32, 31, 31);
    font-size: 15px;
  }
  .form-container i {
    position: absolute;
    top: 110px;
    padding-left: 5px;
    font-size: 24px;
  }

  .form-container h5 {
    margin-top: 15px;
    width: 15%;
  }
</style> 
@endsection