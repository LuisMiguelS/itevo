<div class="box {{ $box_class ?? 'box-primary' }}">
    <div class="box-header with-border">
        <h3 class="box-title">
            {!! $title ?? 'Llena los campos requeridos: <span class="text-danger"><strong>*</strong></span>' !!}
        </h3>
    </div>
    <div class="box-body {{ $body_class ?? '' }}">
        @include('partials._alert')

        {{ $slot }}
    </div>
</div>