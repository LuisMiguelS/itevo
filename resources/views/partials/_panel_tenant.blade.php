<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            {!! $title ?? 'Llena los campos requeridos: <span class="text-danger"><strong>*</strong></span>' !!}
        </div>
    </div>

    <div class="panel-body">
        {{ $slot }}
    </div>
</div>