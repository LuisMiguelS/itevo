@csrf

<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Recurso <span class="text-danger">*</span></label>

    <div class="col-md-12">
        <input id="name"
               type="text"
               class="form-control"
               name="name"
               value="{{ old('name', $resource->name) }}"
               required
               autofocus>

        @if ($errors->has('name'))
	        <span class="help-block">
	            <strong>{{ $errors->first('name') }}</strong>
	        </span>
	    @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Precio <span class="text-danger">*</span></label>

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

<div class="form-group  {{ $errors->has('necessary') ? 'has-error' : '' }}">
    <label>Imprescindible/Necesario</label>
    <br>
    <label class="radio-inline">
        <input type="radio" name="necessary" value="{{ \App\Resource::UNNECESSARY }}" @if($resource->necessary == \App\Resource::UNNECESSARY) checked @endif>
        No necesario
    </label>
    <label class="radio-inline">
        <input type="radio" name="necessary" value="{{ \App\Resource::NECESSARY }}" @if($resource->necessary == \App\Resource::NECESSARY) checked @endif>
        Necesario
    </label>

    @if ($errors->has('necessary'))
        <span class="help-block">
            <strong>{{ $errors->first('necessary') }}</strong>
        </span>
    @endif
</div>

