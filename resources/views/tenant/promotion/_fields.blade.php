@csrf

<div class="form-group row {{ $errors->has('promotion_no') ? 'has-error' : '' }}">
    <label for="promotion_no" class="col-sm-4 col-form-label text-md-right">Número de promoción: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="promotion_no" type="number" class="form-control{{ $errors->has('promotion_no') ? ' is-invalid' : '' }}" name="promotion_no" value="{{ old('promotion_no', $promotion->promotion_no) }}" required="" autofocus>

        @if ($errors->has('promotion_no'))
	        <span class="help-block">
	            <strong>{{ $errors->first('promotion_no') }}</strong>
	        </span>
	    @endif
    </div>
</div>