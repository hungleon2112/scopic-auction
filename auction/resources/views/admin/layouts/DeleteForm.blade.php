<form id="deleteForm" action="{{$url}}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
