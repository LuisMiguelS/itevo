@if($classroom->trashed())
    @can('tenant-restore', $classroom)
    <a href="{{ $classroom->url->restore }}" class="btn btn-default btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'classroom-restore-'. $classroom->id  }}').submit();">
        <i class="fa fa-repeat" aria-hidden="true"></i>
    </a>

    <form id="classroom-restore-{{ $classroom->id }}"
          action="{{ $classroom->url->restore }}"
          method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    </form>
    @endcan

    @can('tenant-delete', $classroom)
    <a href="{{ $classroom->url->delete }}"
        class="btn btn-danger btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'classroom-delete-'. $classroom->id  }}').submit();">
        <i class="fa fa-times" aria-hidden="true"></i>
    </a>

    <form id="classroom-delete-{{ $classroom->id }}"
        action="{{ $classroom->url->delete }}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endcan
@else
    @can('tenant-update', $classroom)
        <a href="{{ $classroom->url->edit }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('tenant-trash', $classroom)
        <a href="{{ $classroom->url->trash }}"
           class="btn btn-danger btn-xs"
           onclick="event.preventDefault();
                   document.getElementById('{{ 'classroom-trash-'. $classroom->id  }}').submit();">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </a>

        <form id="classroom-trash-{{ $classroom->id }}"
              action="{{ $classroom->url->trash }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@endif
