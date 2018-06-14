<form action="{{ route('institutes.store') }}" method="POST">
    @csrf

    <input type="text" name="name"  autofocus/>

    <button type="submit">
        Crear
    </button>
</form>
