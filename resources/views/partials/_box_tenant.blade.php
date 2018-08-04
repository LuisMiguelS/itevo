<div class="{{ $box_class ?? 'box' }}">
    <div class="box-header with-border">
        <h3 class="box-title">
            {!! $title ?? 'Llena los campos requeridos: <span class="text-danger"><strong>*</strong></span>' !!}
        </h3>
    </div>
    <div class="box-body">
        {{ $slot }}
    </div>
</div>