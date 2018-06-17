@extends('layouts.app')

 @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                   @if($institutes->count())
                        <ul class="list-group list-group-flush">
                            @foreach($institutes as $institute)
                                <a href="{{ route('institutes.dashboard', $institute) }}" class="list-group-item list-group-item-action">
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
