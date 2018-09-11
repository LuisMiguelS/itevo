@csrf

<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Tipo de curso <span class="text-danger">*</span></label>
    <div class="col-md-12">
        <input id="name"
               type="text"
               class="form-control"
               name="name"
               value="{{ old('name', $typeCourse->name) }}"
               required
               autofocus>

        @if ($errors->has('name'))
	        <span class="help-block">
	            <strong>{{ $errors->first('name') }}</strong>
	        </span>
	    @endif
    </div>
</div>
