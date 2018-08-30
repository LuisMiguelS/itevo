@csrf

<h3 style="text-align: center"><small><b>Nota:</b> Por favor ingrese el valor de la hora en formato de 24 horas</small></h3>

<div class="form-group {{ $errors->has('weekday') ? 'has-error' : '' }}">
    <label>Día laboral <span class="text-danger">*</span></label>
    <select class="form-control" name="weekday">
        @foreach(App\Schedule::WEEKDAY as $weekday)
            <option value="{{ $weekday }}"
                    {{ $weekday ===  old('weekday', $schedule->weekday) ? 'selected' : '' }}>
                {{ strtoupper($weekday) }}
            </option>
        @endforeach
    </select>

    @if ($errors->has('weekday'))
        <span class="help-block">
            <strong>{{ $errors->first('weekday') }}</strong>
        </span>
    @endif
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('start_at') ? 'has-error' : '' }}" >
            <label  class="control-label">Hora de inicio <span class="text-danger">*</span>
            </label>

            <input id="start_at"
                   type="time"
                   class="form-control"
                   name="start_at"
                   value="{{ old('start_at', $schedule->start_at->format('H:i')) }}"
                   min="07:00"
                   max="21:00"
                   pattern="[0-9]{2}:[0-9]{2}"
                   required>

            @if ($errors->has('start_at'))
                <span class="help-block">
            <strong>{{ $errors->first('start_at') }}</strong>
        </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('ends_at') ? 'has-error' : '' }}" >
            <label  class="control-label">Hora de finalizacion <span class="text-danger">*</span></label>

            <input id="ends_at"
                   type="time"
                   class="form-control"
                   name="ends_at"
                   value="{{ old('ends_at', $schedule->ends_at->format('H:i')) }}"
                   min="07:00"
                   max="21:00"
                   pattern="[0-9]{2}:[0-9]{2}"
                   required>

            @if ($errors->has('ends_at'))
                <span class="help-block">
            <strong>{{ $errors->first('ends_at') }}</strong>
        </span>
            @endif
        </div>
    </div>
</div>