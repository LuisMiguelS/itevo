@csrf

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre</label>

    <div class="col-md-6">
        <input id="name"
               type="text"
               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
               name="name"
               value="{{ old('name', $user->name) }}"
               required
               autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Correo Electrónico</label>

    <div class="col-md-6">
        <input id="email"
               type="email"
               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
               name="email"
               value="{{ old('email', $user->email) }}"
               required>

        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>

@if(request()->route()->getActionMethod() === "create")
<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password"
               type="password"
               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
               name="password"
               required>

        @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    </div>
</div>
@endif

@if(auth()->user()->isAn(\App\User::ROLE_ADMIN) || auth()->user()->isAn(\App\User::ROLE_TENANT_ADMIN))
    <div class="form-group row">
        <label for="role" class="col-md-4 col-form-label text-md-right">Rol</label>
        <div class="col-md-6">
            <select class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" id="role" name="role">
                @foreach($roles as $role)
                    <option value="{{ old('role', $role->name) }}" {{ in_array($role->id, $user->roles()->pluck('id', 'id')->toArray()) ? 'selected' : ''  }}>{{ $role->title }}</option>
                @endforeach
            </select>
            @if ($errors->has('role'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endif

<div class="form-group row">
    <label for="abilities" class="col-sm-4 col-form-label text-md-right">Sucursal</label>
    <div class="col-md-6">
        @if($branchOffices->count())
            @foreach($branchOffices as $branchOffice)
                <div class="custom-control custom-checkbox">
                    <input name="branchOffices[{{ $branchOffice->id }}]"
                           class="custom-control-input {{ $errors->has('branchOffices') ? ' is-invalid' : '' }}"
                           type="checkbox"
                           id="branchOffices{{ $branchOffice->id }}"
                           value="{{ $branchOffice->id }}"
                            {{ old("branchOffices.{$branchOffice->id}") || in_array($branchOffice->id, $user->branchOffices()->get()->pluck('pivot')->pluck('branch_office_id', 'branch_office_id')->toArray()) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="branchOffices{{ $branchOffice->id }}">{{ $branchOffice->name }}</label>
                </div>
            @endforeach
            @if ($errors->has('branchOffices'))
                <br>
                <small style="color: #dc3545; font-size: 12px !important;">
                    <strong>{{ $errors->first('branchOffices') }}</strong>
                </small>
            @endif
        @else
            <div class="alert alert-primary" role="alert">
                No hay sucursales registradas
            </div>
        @endif
    </div>
</div>