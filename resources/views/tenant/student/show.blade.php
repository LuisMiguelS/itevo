@extends('layouts.tenant')

@section('title', 'Informacion de: '. $student->full_name)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            @box
                @slot('title', "Informacion de: {$student->name}")
                <p><strong>Nombre completo:</strong> {{ $student->full_name }}</p>
                <p><strong>Cedula:</strong> {{ $student->id_card }}</p>
                <p><strong>Cedula del tutor:</strong> {!! $student->tutor_id_card ?? '<span class="label label-info">Sin especificar</span>'  !!}</p>
                <p><strong>Telefono:</strong> {{ $student->phone }}</p>
                <p><strong>Fecha de nacimiento:</strong> {{ $student->birthdate->format('d/m/Y') }}</p>
                <p><strong>Inscrito :</strong> {!! (new \Carbon\Carbon($student->signed_up))->format('d/m/Y') ?? '<span class="label label-info">Sin inscribir</span>'!!}</p>
                <p><strong>Registrado :</strong> {{ $student->created_at->format('d/m/Y') }}</p>
            @endbox
        </div>
        <div class="col-md-8">
            @box
                @slot('title', "Historial de cursos")

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Estado de cuenta</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($studentInfo as $info)
                <tr>
                    <td>
                        @foreach($info->coursePeriod as $coursePeriod)
                           <p>
                               <strong> {{ strtoupper($coursePeriod->course->name .' '. $coursePeriod->course->typeCourse->name) }} </strong>
                               <br>
                               <strong>Profesor: </strong>  {{ $coursePeriod->teacher->full_name }}
                               <br>
                               RD ${{ number_format($coursePeriod->price, 2) }}
                               <br>
                               Inicio: {{ $coursePeriod->start_at->format('d/m/Y') }}
                               <br>
                               Finalización {{ $coursePeriod->ends_at->format('d/m/Y') }}
                           </p>
                        @endforeach
                    </td>
                    <td>
                        <strong>Total</strong> RD ${{ number_format($info->total, 2) }} <br>
                        @if($info->total == $info->balance)
                            <strong>Monto Pagado</strong> <span class="label label-info">RD ${{ number_format($info->balance, 2) }}</span>
                        @else
                            <strong>Monto Pagado</strong> <span class="label label-danger">RD ${{ number_format($info->balance, 2) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($info->status == \App\Invoice::STATUS_COMPLETE)
                            <span class="label label-success">{{ $info->status }}</span>
                        @else
                            <span class="label label-warning">{{ $info->status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            {{ $studentInfo->links() }}

            @endbox
        </div>
    </div>
@endsection
