@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">

              <div class="card shadow-sm border-0">
                  <div class="card-header border-0 font-weight-bold bg-white">Crear Sucursal</div>
                  <div class="card-body">
                      @include('partials._alert')

                      <form action="{{ route('branchOffices.store') }}" method="POST">
                          @csrf

                          @include('branch_office._fields')

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
