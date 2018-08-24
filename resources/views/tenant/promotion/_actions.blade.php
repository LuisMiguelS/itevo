@if($promotion->trashed())
    @can('tenant-restore', $promotion)
        <a href="{{ $promotion->url->restore }}" class="btn btn-default btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'promotion-restore-'. $promotion->id  }}').submit();">
            <i class="fa fa-repeat" aria-hidden="true"></i>
        </a>
        
        <form id="promotion-restore-{{ $promotion->id }}"
            action="{{ $promotion->url->restore }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan

    @can('tenant-delete', $promotion)
        <a href="{{ $promotion->url->delete }}"
            class="btn btn-danger btn-xs"
            onclick="event.preventDefault();
            document.getElementById('{{ 'promotion-delete-'. $promotion->id  }}').submit();">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>
        
        <form id="promotion-delete-{{ $promotion->id }}"
            action="{{ $promotion->url->delete }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@else

    <div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 3px">
        <i class="fa fa-eye" aria-hidden="true"></i> <span class="caret"></span>
    </button>

    @can('tenant-update', $promotion)
        <a href="{{ $promotion->url->edit }}" class="btn btn-default btn-xs"  style="margin: 3px">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('tenant-trash', $promotion)
        <a href="{{ $promotion->url->trash }}"
           class="btn btn-danger btn-xs"
           style="margin: 3px"
           onclick="event.preventDefault();
                document.getElementById('{{ 'promotion-trash-'. $promotion->id  }}').submit();">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </a>

        <form id="promotion-trash-{{ $promotion->id }}"
              action="{{ $promotion->url->trash }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endcan

    <ul class="dropdown-menu">
        <li><a href="{{ route('tenant.promotions.periods.index', ['branchOffice' => request()->branchOffice, 'promotion' => $promotion]) }}">Períodos</a></li>

        @if($promotion->status === \App\Promotion::STATUS_CURRENT)
            @can('tenant-finish', $promotion)
                <li role="separator" class="divider"></li>
                <li><a href="{{ $promotion->url->finish }}">Finalizar promocion</a></li>
            @endcan
        @endif
    </ul>

    </div>
@endif