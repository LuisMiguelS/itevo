<form action="{{ route('institutes.update', $institute) }}" method="POST">
    @csrf

    <input name="_method" type="hidden" value="PUT">

    <input type="text" name="name" value="{{ $institute->name }}"  autofocus/>

    <button type="submit">
        Actualizar
    </button>
</form>
