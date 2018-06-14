<a href="{{ route('institutes.create') }}">Crear instituto</a>


@foreach($institutes  as $institute)
    <div>
        <h1><a href="este_sera_el_link_para_acceder_al_instituto_selecionado">{{ $institute->name }}</a></h1>
        @can('update', $institute)
        <a href="{{ route('institutes.edit', $institute) }}">Editar</a>
        @endcan

        @can('delete', $institute)
        <a href="{{ route('institutes.destroy', $institute) }}">Eliminar</a>
        @endcan
    </div>
@endforeach
