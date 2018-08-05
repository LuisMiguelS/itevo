<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @can('tenant-update', $student)
        <li><a href="{{ $student->url->edit }}"> Editar</a></li>
        @endcan

        @can('tenant-delete', $student)
        <li>
            <a href="{{ $student->url->delete }}"
               onclick="event.preventDefault();
               document.getElementById('{{ 'student-delete-'. $student->id  }}').submit();">
                Eliminar
            </a>
        </li>
        <form id="student-delete-{{ $student->id }}"
              action="{{ $student->url->delete }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endcan
        <li role="separator" class="divider"></li>
        <li><a href="#">Something else here</a></li>
    </ul>
</div>