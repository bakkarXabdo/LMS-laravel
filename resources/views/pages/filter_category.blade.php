@extends('layouts.master')

@section('PageTitle') Category @endsection

@section('content')
@include('pages.inc')
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
            @forelse ($filter_book_cat as $book)
            <tr>
            <td>{{$book->Id}}</td>
            <td>{{$book->Title}}</td>
            <td>{{$book->Authors}}</td>
            <td>{{ $book->category->Name}}</td>
            <td>{{ $book->language->Name}}</td>
            {{-- <td class=" text-center">
                <a class="btn btn-primary" href="#">Rent</a>
            </td> --}}
            </tr>
            @empty
                no books Found
            @endforelse
            
    </tbody>
  </table>
  <div class="row">
      <div style="padding: 10px;"  class="text-center">
          {{$filter_book_cat->links()}}
      </div>
  </div>
@endsection