<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="{{ $course->url->edit }}"> Editar</a></li>
        <li>
            <a href="{{ $course->url->delete }}"
               onclick="event.preventDefault();
               document.getElementById('{{ 'course-delete-'. $course->id  }}').submit();">
                Eliminar
            </a>
        </li>
        <form id="course-delete-{{ $course->id }}"
              action="{{ $course->url->delete }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        <li role="separator" class="divider"></li>
        <li><a href="#">Something else here</a></li>
    </ul>
</div>