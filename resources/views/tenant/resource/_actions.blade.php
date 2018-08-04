<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="{{ $resource->url->edit }}"> Editar</a></li>
        <li>
            <a href="{{ $resource->url->delete }}"
               onclick="event.preventDefault();
               document.getElementById('{{ 'resource-delete-'. $resource->id  }}').submit();">
                Eliminar
            </a>
        </li>
        <form id="resource-delete-{{ $resource->id }}"
              action="{{ $resource->url->delete }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        <li role="separator" class="divider"></li>
        <li><a href="#">Something else here</a></li>
    </ul>
</div>