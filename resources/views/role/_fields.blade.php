@csrf

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="col-sm-2 control-label">Nombre</label>

    <div class="col-sm-10">
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $role->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">{{ $errors->first('name') }}</span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="abilities" class="col-sm-2 control-label">Habiliades</label>
    <div class="col-sm-10 row">
        @foreach($abilities as $abilitie)
            @if($abilitie->id !== 1)
                <div class="custom-control custom-checkbox col-md-6">
                    <input name="abilities[{{ $abilitie->id }}]"
                           class="custom-control-input"
                           type="checkbox"
                           id="role_{{ $abilitie->id }}"
                           value="{{ $abilitie->id }}"
                            {{ old("abilities.{$abilitie->id}") || in_array($abilitie->id, $role->getAbilities()->pluck('id', 'id')->toArray()) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="role_{{ $abilitie->id }}">{{ $abilitie->title }}</label>
                </div>
            @endif
        @endforeach

        @if ($errors->has('abilities[]'))
            <span class="help-block">{{ $errors->first('abilities[]') }}</span>
        @endif
    </div>
</div>