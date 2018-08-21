@if($typeCourse->trashed())
    @can('tenant-restore', $typeCourse)
    <a href="{{ $typeCourse->url->restore }}" class="btn btn-default btn-xs"
    onclick="event.preventDefault();
    document.getElementById('{{ 'typeCourse-restore-'. $typeCourse->id  }}').submit();">
        <i class="fa fa-repeat" aria-hidden="true"></i>
    </a>

    <form id="typeCourse-restore-{{ $typeCourse->id }}"
          action="{{ $typeCourse->url->restore }}"
          method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endcan

    @can('tenant-delete', $typeCourse)
    <a href="{{ $typeCourse->url->delete }}"
        class="btn btn-danger btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'typeCourse-delete-'. $typeCourse->id  }}').submit();">
            <i class="fa fa-times" aria-hidden="true"></i>
    </a>

    <form id="typeCourse-delete-{{ $typeCourse->id }}"
        action="{{ $typeCourse->url->delete }}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endcan
@else
    @can('tenant-update', $typeCourse)
    <a href="{{ $typeCourse->url->edit }}" class="btn btn-default btn-xs">
        <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
    @endcan

    @can('tenant-trash', $typeCourse)
    <a href="{{ $typeCourse->url->trash }}"
        class="btn btn-danger btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'typeCourse-trash-'. $typeCourse->id  }}').submit();">
        <i class="fa fa-trash" aria-hidden="true"></i>
    </a>

    <form id="typeCourse-trash-{{ $typeCourse->id }}"
        action="{{ $typeCourse->url->trash }}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endcan
@endif