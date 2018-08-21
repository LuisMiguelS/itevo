@if($course->trashed())
    @can('tenant-restore', $course)
        <a href="{{ $course->url->restore }}" class="btn btn-default btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'course-restore-'. $course->id  }}').submit();">
            <i class="fa fa-repeat" aria-hidden="true"></i>
        </a>

        <form id="course-restore-{{ $course->id }}"
            action="{{ $course->url->restore }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan

    @can('tenant-delete', $course)
        <a href="{{ $course->url->delete }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'course-delete-'. $course->id  }}').submit();">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>

        <form id="course-delete-{{ $course->id }}"
            action="{{ $course->url->delete }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@else
    @can('tenant-update', $course)
        <a href="{{ $course->url->edit }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('tenant-trash', $course)
        <a href="{{ $course->url->trash }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'course-trash-'. $course->id  }}').submit();">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </a>

        <form id="course-trash-{{ $course->id }}"
            action="{{ $course->url->trash }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@endif