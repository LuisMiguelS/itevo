@csrf

@if($period->status === \App\Period::STATUS_WITHOUT_STARTING)
    <div class="form-group {{ $errors->has('period_no') ? 'has-error' : '' }}">
        <label>Periodo <span class="text-danger">*</span></label>
        <select class="form-control" name="period_no">
            <option value="{{ App\Period::PERIOD_NO_1 }}"
                    {{ $period->period_no ===  old('period_no', App\Period::PERIOD_NO_1) ? 'selected' : '' }}>
                {{ strtoupper(App\Period::PERIOD_NO_1) }}
            </option>
            <option value="{{ App\Period::PERIOD_NO_2 }}"
                    {{ $period->period_no ===  old('period_no', App\Period::PERIOD_NO_2) ? 'selected' : '' }}>
                {{ strtoupper(App\Period::PERIOD_NO_2) }}
            </option>
            <option value="{{ App\Period::PERIOD_NO_3 }}"
                    {{ $period->period_no ===  old('period_no', App\Period::PERIOD_NO_3) ? 'selected' : '' }}>
                {{ strtoupper(App\Period::PERIOD_NO_3) }}
            </option>
        </select>

        @if ($errors->has('period_no'))
            <span class="help-block">
            <strong>{{ $errors->first('period_no') }}</strong>
        </span>
        @endif
    </div>
@endif

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label>Estado <span class="text-danger">*</span></label>
    <select class="form-control" name="status">
        <option value="{{ App\Period::STATUS_WITHOUT_STARTING }}"
                @if($period->status === \App\Period::STATUS_CURRENT) disabled @endif
                {{ $period->period ===  old('status', App\Period::STATUS_WITHOUT_STARTING) ? 'selected' : '' }}>
            {{ strtoupper(App\Period::STATUS_WITHOUT_STARTING) }}
        </option>
        <option value="{{ App\Period::STATUS_CURRENT }}"
                {{ $period->period === old('status',  App\Period::STATUS_CURRENT) ? 'selected' : '' }}>
            {{ strtoupper(App\Period::STATUS_CURRENT) }}
        </option>
        <option value="{{ App\Period::STATUS_FINISHED }}"
                @if($period->status === \App\Period::STATUS_WITHOUT_STARTING) disabled @endif
                {{ $period->period ===  old('status', App\Period::STATUS_FINISHED) ? 'selected' : '' }}>
            {{ strtoupper(App\Period::STATUS_FINISHED) }}
        </option>
    </select>

    @if ($errors->has('status'))
        <span class="help-block">
            <strong>{{ $errors->first('status') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('start_at') ? 'has-error' : '' }}" >
    <label  class="control-label">Inicio de periodo <span class="text-danger">*</span></label>

    <input id="start_at"
           type="date"
           class="form-control"
           name="start_at"
           @if($period->getOriginal('ends_at') !== null) readonly @endif
           value="{{ old('start_at', $period->start_at->format('Y-m-d')) }}">

    @if ($errors->has('start_at'))
        <span class="help-block">
            <strong>{{ $errors->first('start_at') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('ends_at') ? 'has-error' : '' }}" >
    <label  class="control-label">Fin del periodo <span class="text-danger">*</span></label>

    <input id="ends_at"
           type="date"
           class="form-control"
           name="ends_at"
           @if($period->getOriginal('ends_at') !== null) readonly @endif
           value="{{ old('ends_at', $period->ends_at->format('Y-m-d')) }}">

    @if ($errors->has('ends_at'))
        <span class="help-block">
            <strong>{{ $errors->first('ends_at') }}</strong>
        </span>
    @endif
</div>