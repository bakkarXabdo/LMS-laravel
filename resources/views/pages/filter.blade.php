<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
            @forelse ($books as $book)
            <tr>
            <td>{{$book->Id}}</td>
            <td>{{$book->Title}}</td>
            <td>{{$book->Authors}}</td>
            <td><a href="/filter/{{optional($book->language)->Id}}">{{ $book->language->Name}}</a></td>
            <td class=" text-center">
                <a class="btn btn-primary" href="#">Show</a>
            </td>
            </tr>
            @empty
                no books Found
            @endforelse
    </tbody>
  </table>