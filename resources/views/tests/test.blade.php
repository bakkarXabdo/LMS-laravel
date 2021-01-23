<form action="{{ route('rentals.destroy', [1014]) }}" method="post">
    @method('DELETE')
    @csrf
    <button type="submit">Sub</button>
</form>