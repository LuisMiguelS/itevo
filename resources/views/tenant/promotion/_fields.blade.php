@csrf

<div class="form-group {{ $errors->has('promotion_no') ? 'has-error' : '' }}">
    <label for="promotion_no" >Número de promoción: <span class="text-danger">*</span></label>

    <input id="promotion_no"
           name="promotion_no" value="{{ old('promotion_no', $promotion->promotion_no) }}"
           class="form-control{{ $errors->has('promotion_no') ? ' is-invalid' : '' }}"
           type="number"
           min="1"
           required
           autofocus>

    @if ($errors->has('promotion_no'))
        <span class="help-block">
	            <strong>{{ $errors->first('promotion_no') }}</strong>
	        </span>
    @endif
</div>