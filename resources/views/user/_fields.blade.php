@csrf

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="col-sm-4 control-label">Nombre</label>

    <div class="col-md-8">
        <input id="name"
               type="text"
               class="form-control"
               name="name"
               value="{{ old('name', $user->name) }}"
               required
               autofocus>

        @if ($errors->has('name'))
            <span class="help-block">{{ $errors->first('name') }}</span>
        @endif
    </div>
</div>

<div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
    <label class="col-sm-4 control-label">Correo Electrónico</label>

    <div class="col-md-8">
        <input id="email"
               type="email"
               class="form-control"
               name="email"
               value="{{ old('email', $user->email) }}"
               required>
        @if ($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
        @endif
    </div>
</div>

@if(request()->route()->getActionMethod() === "create")
<div class="form-group {{ $errors->has('password')  ? 'has-error' : '' }}">
    <label for="password" class="col-sm-4 control-label">{{ __('Password') }}</label>

    <div class="col-sm-8">
        <input id="password"
               type="password"
               class="form-control"
               name="password"
               required>

        @if ($errors->has('password'))
            <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="password-confirm" class="col-sm-4 control-label">{{ __('Confirm Password') }}</label>

    <div class="col-sm-8">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    </div>
</div>
@endif

@if(auth()->user()->isAn(\App\User::ROLE_ADMIN) || auth()->user()->isAn(\App\User::ROLE_TENANT_ADMIN))
    <div class="form-group {{ $errors->has('role')  ? 'has-error' : '' }}">
        <label for="role" class="col-sm-4 control-label">Rol</label>
        <div class="col-sm-8">
            <select class="form-control" id="role" name="role">
                @foreach($roles as $role)
                    <option value="{{ old('role', $role->name) }}" {{ in_array($role->id, $user->roles()->pluck('id', 'id')->toArray()) ? 'selected' : ''  }}>{{ $role->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('role'))
                <span class="help-block">{{ $errors->first('role') }}</span>
            @endif
        </div>
    </div>
@endif

<div class="form-group {{ $errors->has('branchOffices')  ? 'has-error' : '' }}">
    <label for="abilities" class="col-sm-4 control-label">Sucursal</label>
    <div class="col-sm-8">
        @if($branchOffices->count())
            @foreach($branchOffices as $branchOffice)
                <div class="custom-control custom-checkbox">
                    <input name="branchOffices[{{ $branchOffice->id }}]"
                           class="custom-control-input"
                           type="checkbox"
                           id="branchOffices{{ $branchOffice->id }}"
                           value="{{ $branchOffice->id }}"
                            {{ old("branchOffices.{$branchOffice->id}") || in_array($branchOffice->id, $user->branchOffices()->get()->pluck('pivot')->pluck('branch_office_id', 'branch_office_id')->toArray()) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="branchOffices{{ $branchOffice->id }}">{{ $branchOffice->name }}</label>
                </div>
            @endforeach

            @if ($errors->has('branchOffices'))
                <span class="help-block">{{ $errors->first('branchOffices') }}</span>
            @endif
        @else
            <div class="alert alert-primary" role="alert">
                No hay sucursales registradas
            </div>
        @endif
    </div>
</div>