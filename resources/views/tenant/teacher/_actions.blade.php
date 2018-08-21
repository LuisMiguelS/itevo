@if($teacher->trashed())
    @can('tenant-restore', $teacher)
        <a href="{{ $teacher->url->restore }}" class="btn btn-default btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'teacher-restore-'. $teacher->id  }}').submit();">
            <i class="fa fa-repeat" aria-hidden="true"></i>
        </a>

        <form id="teacher-restore-{{ $teacher->id }}"
            action="{{ $teacher->url->restore }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan

    @can('tenant-delete', $teacher)
        <a href="{{ $teacher->url->delete }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'teacher-delete-'. $teacher->id  }}').submit();">
            <i class="fa fa-times" aria-hidden="true"></i>
            </a>

        <form id="teacher-delete-{{ $teacher->id }}"
            action="{{ $teacher->url->delete }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@else
    @can('tenant-update', $teacher)
        <a href="{{ $teacher->url->edit }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('tenant-trash', $teacher)
        <a href="{{ $teacher->url->trash }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'teacher-trash-'. $teacher->id  }}').submit();">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </a>

        <form id="teacher-trash-{{ $teacher->id }}"
            action="{{ $teacher->url->trash }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@endif

<!--
<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @can('tenant-update', $teacher)
        <li><a href="{{ $teacher->url->edit }}"> Editar</a></li>
        @endcan

        @can('tenant-delete', $teacher)
        <li>
            <a href="{{ $teacher->url->delete }}"
               onclick="event.preventDefault();
               document.getElementById('{{ 'teacher-delete-'. $teacher->id  }}').submit();">
                Eliminar
            </a>
        </li>
        <form id="teacher-delete-{{ $teacher->id }}"
              action="{{ $teacher->url->delete }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endcan
        <li role="separator" class="divider"></li>
        <li><a href="#">Something else here</a></li>
    </ul>
</div>-->
