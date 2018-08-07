<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @can('tenant-update', $promotion)
        <li><a href="{{ $promotion->url->edit }}"> Editar</a></li>
        @endcan

        @can('tenant-delete', $promotion)
        <li>
            <a href="{{ $promotion->url->delete }}"
               onclick="event.preventDefault();
               document.getElementById('{{ 'promotion-delete-'. $promotion->id  }}').submit();">
                Eliminar
            </a>
        </li>
        <form id="promotion-delete-{{ $promotion->id }}"
              action="{{ $promotion->url->delete }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endcan
        <li role="separator" class="divider"></li>

        <li><a href="">Períodos</a></li>

       @if($promotion->status === \App\Promotion::STATUS_CURRENT)
            @can('tenant-finish', $promotion)
            <li><a href="{{ $promotion->url->finish }}">Finalizar promocion</a></li>
            @endcan
        @endif
    </ul>
</div>