<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @can('tenant-update', $classroom)
        <li><a href="{{ $classroom->url->edit }}"> Editar</a></li>
        @endcan

        @can('tenant-delete', $classroom)
        <li>
            <a href="{{ $classroom->url->delete }}"
               onclick="event.preventDefault();
               document.getElementById('{{ 'classroom-delete-'. $classroom->id  }}').submit();">
                Eliminar
            </a>
        </li>
        <form id="classroom-delete-{{ $classroom->id }}"
              action="{{ $classroom->url->delete }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endcan
        <li role="separator" class="divider"></li>
        <li><a href="#">Something else here</a></li>
    </ul>
</div>