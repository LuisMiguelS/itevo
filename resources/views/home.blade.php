@extends('layouts.app')

 @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 font-weight-bold text-uppercase text-center">Esto son los institutos a los que peteneces</div>

                <div class="card-body">
                   @if($institutes->count())
                        <ul class="list-group">
                            @foreach($institutes as $institute)
                                <a href="{{ route('tenant.dashboard', $institute) }}" class="list-group-item text-uppercase">
                                    <i class="fas fa-school text-dark"></i>
                                    <b>{{ $institute->name }}</b>
                                </a>
                            @endforeach
                        </ul>
                       @else
                       No tienes un instituto asignado...
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
