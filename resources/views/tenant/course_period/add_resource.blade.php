@extends('layouts.tenant')

@section('title', 'Crear curso')

@section('breadcrumb')
    {{ Breadcrumbs::render('coursePeriod-resource', $branchOffice, $period, $coursePeriod) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box

            @slot('title', 'Recursos diponibles, para asignar')

            <form action="{{ $coursePeriod->url->addResource }}" method="POST">
                @csrf

                <div class="form-group row">
                <label for="abilities" class="col-sm-4 col-form-label text-md-right">Recursos</label>
                    <div class="col-md-6 row">
                        @foreach($branchOffice->resources as $resource)
                          <div class="custom-control custom-checkbox col-md-6">
                              <input name="resources[{{ $resource->id }}]"
                                     class="custom-control-input"
                                     type="checkbox"
                                     id="resource_{{ $resource->id }}"
                                     value="{{ $resource->id }}"
                                      {{ old("resources.{$resource->id}") || in_array($resource->id, $coursePeriod->resources()->pluck('id', 'id')->toArray()) ? 'checked' : '' }}>
                              <label class="custom-control-label" for="resource_{{ $resource->id }}">{{ $resource->name }}</label>
                          </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Actualizar
                        </button>
                    </div>
                </div>

            </form>

            @endbox

        </div>
    </div>
@endsection