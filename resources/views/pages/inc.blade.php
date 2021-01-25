
<style>
    .drop-container {
        position: relative;
        border: 2px solid gray;
        border-radius: 10px;
        background-color: white;
        padding: 10px;
        /* padding-left: -40px; */
    }
    
    .drop-container .drop-arrow {
      position: absolute;
      margin-top: -111px;
      right: 0px;
      padding: 0px 0px 0px 5px;
      font-size: 18px;
    }
    .drop-container:hover {
    }
    .drop-container ul {
        padding: 0px;
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
      text-align: left;
      text-decoration: none;
        width: 90px;
    }
    .drop-container ul li ul {
      display: none;
      position: absolute;
      background-color: white;
      border-radius: 0px 0px 4px 4px;
        margin-top: 18px;
        margin-left: -10px;
      width: 180px;
    }
    .drop-container ul li ul li {
      /* width: 180px; */
    }
    .drop-container ul li ul li a {
      padding: 8px;
      width: 180px;
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
      top: 114px;
      padding-left: 5px;
      font-size: 24px;
    }
  
    .form-container h5 {
      margin-top: 15px;
      width: 15%;
    }
  </style> 
<h1 class="jumbotron text-center">{{config('app.name')}}</h1>
<div style="height: 300px">
  <form action="{{url('/search')}}" method="get" class="form-container">
    {{-- <h5>make a search</h5> --}}
    <input
    type="search"
    name="search_query"
    class="input-container"
    autocomplete="off"
    placeholder="Search by Title or Author..."
    />
    <i class="glyphicon glyphicon-search"></i>
    
    <h5>or filter</h5>
    <div class="drop-container">
      <ul>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" href="#">Category<i class="glyphicon glyphicon-chevron-down drop-arrow"></i></a>
          
          <ul class="dropdown-menu">
            @foreach ($categories as $category)
            <li><a class="dropdown-item" href="/filter_category/{{ $category->Id }}">{{ $category->Name }}</a></li>
            @endforeach
          </ul>
        </li>
      </ul>
    </div>
    <div style="margin-left: 10px;" class="drop-container">
      <ul>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" href="#">Languages<i class="glyphicon glyphicon-chevron-down drop-arrow"></i></a>
          <ul class="dropdown-menu">
            @foreach ($langs as $lang)
            <li><a class="dropdown-item" href="/filter/{{ $lang->Id }}">{{ $lang->Name }}</a></li>
            @endforeach
          </ul>
        </li>
      </ul>
    </div>
  </form>
</div>