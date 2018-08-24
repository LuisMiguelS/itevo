@if($resource->trashed())
    @can('tenant-restore', $resource)
    <a href="{{ $resource->url->restore }}" class="btn btn-default btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'resource-restore-'. $resource->id  }}').submit();">
            <i class="fa fa-repeat" aria-hidden="true"></i>
    </a>

    <form id="resource-restore-{{ $resource->id }}"
        action="{{ $resource->url->restore }}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endcan

    @can('tenant-delete', $resource)
        <a href="{{ $resource->url->delete }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'resource-delete-'. $resource->id  }}').submit();">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>

        <form id="resource-delete-{{ $resource->id }}"
        action="{{ $resource->url->delete }}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        </form>
    @endcan
@else
    @can('tenant-update', $resource)
        <a href="{{ $resource->url->edit }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('tenant-trash', $resource)
    <a href="{{ $resource->url->trash }}"
        class="btn btn-danger btn-xs"
        onclick="event.preventDefault();
        document.getElementById('{{ 'resource-trash-'. $resource->id  }}').submit();">
            <i class="fa fa-trash" aria-hidden="true"></i>
    </a>

        <form id="resource-trash-{{ $resource->id }}"
            action="{{ $resource->url->trash }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@endif