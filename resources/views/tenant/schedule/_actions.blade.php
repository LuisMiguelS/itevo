@if($schedule->trashed())
    @can('tenant-restore', $schedule)
        <a href="{{ $schedule->url->restore }}" class="btn btn-default btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'schedule-restore-'. $schedule->id  }}').submit();">
                <i class="fa fa-repeat" aria-hidden="true"></i>
        </a>

        <form id="schedule-restore-{{ $schedule->id }}"
            action="{{ $schedule->url->restore }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan

    @can('tenant-delete', $schedule)
        <a href="{{ $schedule->url->delete }}"
        class="btn btn-danger btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'schedule-delete-'. $schedule->id  }}').submit();">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>

        <form id="schedule-delete-{{ $schedule->id }}"
            action="{{ $schedule->url->delete }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@else
    @can('tenant-update', $schedule)
        <a href="{{ $schedule->url->edit }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('tenant-trash', $schedule)
        <a href="{{ $schedule->url->trash }}"
        class="btn btn-danger btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'schedule-trash-'. $schedule->id  }}').submit();">
         <i class="fa fa-trash" aria-hidden="true"></i>
        </a>

        <form id="schedule-trash-{{ $schedule->id }}"
            action="{{ $schedule->url->trash }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@endif