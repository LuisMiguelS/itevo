@if($student->trashed())
    @can('tenant-restore', $student)
        <a href="{{ $student->url->restore }}" class="btn btn-default btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'student-restore-'. $student->id  }}').submit();">
                <i class="fa fa-repeat" aria-hidden="true"></i>
        </a>

        <form id="student-restore-{{ $student->id }}"
            action="{{ $student->url->restore }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan

    @can('tenant-delete', $student)
        <a href="{{ $student->url->delete }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'student-delete-'. $student->id  }}').submit();">
                <i class="fa fa-times" aria-hidden="true"></i>
        </a>

        <form id="student-delete-{{ $student->id }}"
            action="{{ $student->url->delete }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@else

    <a href="{{ $student->url->show }}" target="_blank" class="btn btn-default btn-xs">
        <i class="fa fa-eye" aria-hidden="true"></i>
    </a>

    @can('tenant-update', $student)
        <a href="{{ $student->url->edit }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('tenant-trash', $student)
        <a href="{{ $student->url->trash }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'student-trash-'. $student->id  }}').submit();">
             <i class="fa fa-trash" aria-hidden="true"></i>
        </a>

        <form id="student-trash-{{ $student->id }}"
            action="{{ $student->url->trash }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@endif