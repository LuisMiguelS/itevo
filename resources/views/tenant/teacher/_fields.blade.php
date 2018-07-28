@csrf

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre(s): <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $teacher->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Apellido(s): <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" required>

        @if ($errors->has('last_name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Cédula: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="id_card" type="text" class="form-control{{ $errors->has('id_card') ? ' is-invalid' : '' }}" name="id_card" value="{{ old('id_card', $teacher->id_card) }}" required>

        @if ($errors->has('id_card'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('id_card') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Teléfono: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone', $teacher->phone) }}" required>

        @if ($errors->has('phone'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
</div>