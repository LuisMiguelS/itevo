@csrf

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 control-label">Nombre</label>

    <div class="col-md-8">
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $branchOffice->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">{{ $errors->first('name') }}</span>
        @endif
    </div>
</div>