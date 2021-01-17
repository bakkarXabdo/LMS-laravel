<table class="table table-bordered table-hover">
  <thead>
      <tr>
          <th>#ID</th>
          <th>Title</th>
          <th>Author</th>
      </tr>
  </thead>
  <tbody>
      
          @forelse ($books as $book)
          <tr>
          <td>{{$book->Id}}</td>
          <td>{{$book->Title}}</td>
          <td>{{$book->Authors}}</td>
          <td class=" text-center">
              <a class="btn btn-primary" href="/books/{{$book->id}}">Show</a>
          </td>
          </tr>
          @empty
              no books Found
          @endforelse
      
  </tbody>
</table>