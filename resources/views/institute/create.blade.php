@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">

              <div class="card shadow-sm border-0">
                  <div class="card-header border-0 font-weight-bold">Crear Instituto</div>
                  <div class="card-body">

                      <form action="{{ route('institutes.store') }}" method="POST">
                          @csrf

                          <div class="form-group row">
                              <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del instituto</label>

                              <div class="col-md-6">
                                  <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                  @if ($errors->has('name'))
                                      <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Crear
                                  </button>
                              </div>
                          </div>
                      </form>

                  </div>
              </div>

          </div>
      </div>
  </div>
@endsection
