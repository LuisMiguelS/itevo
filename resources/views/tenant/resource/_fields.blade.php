@csrf

<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del recurso: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $resource->name) }}" required autofocus>

        @if ($errors->has('name'))
	        <span class="help-block">
	            <strong>{{ $errors->first('name') }}</strong>
	        </span>
	    @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Precio: <span class="text-danger">*</span></label>

    <div class="col-md-12">
        <input id="price"
               type="number"
               class="form-control"
               name="price"
               value="{{ old('price', $resource->price) }}"
               required>

        @if ($errors->has('price'))
            <span class="help-block">
	            <strong>{{ $errors->first('price') }}</strong>
	        </span>
        @endif
    </div>
</div>