<!DOCTYPE html>
<html lang="es">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="text-center">
      <h1>{{ strtoupper(config('app.name')) }}</h1>
      <h2>Horario de cursos</h2>
  </div>
    <table class="table">
        <thead>
        <tr>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miércoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
            <th>Sábado</th>
            <th>Domingo</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @isset($horario[\App\Schedule::WEEKDAY['monday']])
                <td>
                @foreach($horario[\App\Schedule::WEEKDAY['monday']] as $schedule)
                    @foreach($schedule->coursePeriods as $coursePeriod)
                        {{ $coursePeriod->course->name }}   {{ $coursePeriod->course->typeCourse->name }}
                        <br>
                        Profesor:  {{ $coursePeriod->teacher->full_name }}
                        <br>
                        {{ $coursePeriod->classroom->building }}:  {{ $coursePeriod->classroom->name }}
                    @endforeach
                    <br>
                    {{ $schedule->start_at->format('h:i:s A') }} - {{ $schedule->start_at->format('h:i:s A') }}
                    <hr>
                @endforeach
                </td>
            @endisset

            @isset($horario[\App\Schedule::WEEKDAY['tuesday']])
                <td>
                    @foreach($horario[\App\Schedule::WEEKDAY['tuesday']] as $schedule)
                        @foreach($schedule->coursePeriods as $coursePeriod)
                            {{ $coursePeriod->course->name }}   {{ $coursePeriod->course->typeCourse->name }}
                            <br>
                            Profesor:  {{ $coursePeriod->teacher->full_name }}
                            <br>
                            {{ $coursePeriod->classroom->building }}:  {{ $coursePeriod->classroom->name }}
                        @endforeach
                        <br>
                        {{ $schedule->start_at->format('h:i:s A') }} - {{ $schedule->start_at->format('h:i:s A') }}
                        <hr>
                    @endforeach
                </td>
            @endisset

            @isset($horario[\App\Schedule::WEEKDAY['wednesday']])
                <td>
                    @foreach($horario[\App\Schedule::WEEKDAY['wednesday']] as $schedule)
                        @foreach($schedule->coursePeriods as $coursePeriod)
                            {{ $coursePeriod->course->name }}   {{ $coursePeriod->course->typeCourse->name }}
                            <br>
                            Profesor:  {{ $coursePeriod->teacher->full_name }}
                            <br>
                            {{ $coursePeriod->classroom->building }}:  {{ $coursePeriod->classroom->name }}
                        @endforeach
                        <br>
                        {{ $schedule->start_at->format('h:i:s A') }} - {{ $schedule->start_at->format('h:i:s A') }}
                        <hr>
                    @endforeach
                </td>
            @endisset

            @isset($horario[\App\Schedule::WEEKDAY['thursday']])
                <td>
                    @foreach($horario[\App\Schedule::WEEKDAY['thursday']] as $schedule)
                        @foreach($schedule->coursePeriods as $coursePeriod)
                            {{ $coursePeriod->course->name }}   {{ $coursePeriod->course->typeCourse->name }}
                            <br>
                            Profesor:  {{ $coursePeriod->teacher->full_name }}
                            <br>
                            {{ $coursePeriod->classroom->building }}:  {{ $coursePeriod->classroom->name }}
                        @endforeach
                        <br>
                        {{ $schedule->start_at->format('h:i:s A') }} - {{ $schedule->start_at->format('h:i:s A') }}
                        <hr>
                    @endforeach
                </td>
            @endisset

            @isset($horario[\App\Schedule::WEEKDAY['friday']])
                <td>
                    @foreach($horario[\App\Schedule::WEEKDAY['friday']] as $schedule)
                        @foreach($schedule->coursePeriods as $coursePeriod)
                            {{ $coursePeriod->course->name }}   {{ $coursePeriod->course->typeCourse->name }}
                            <br>
                            Profesor:  {{ $coursePeriod->teacher->full_name }}
                            <br>
                            {{ $coursePeriod->classroom->building }}:  {{ $coursePeriod->classroom->name }}
                        @endforeach
                        <br>
                        {{ $schedule->start_at->format('h:i:s A') }} - {{ $schedule->start_at->format('h:i:s A') }}
                        <hr>
                    @endforeach
                </td>
            @endisset

            @isset($horario[\App\Schedule::WEEKDAY['saturday']])
                <td>
                    @foreach($horario[\App\Schedule::WEEKDAY['saturday']] as $schedule)
                        @foreach($schedule->coursePeriods as $coursePeriod)
                            {{ $coursePeriod->course->name }}   {{ $coursePeriod->course->typeCourse->name }}
                            <br>
                            Profesor:  {{ $coursePeriod->teacher->full_name }}
                            <br>
                            {{ $coursePeriod->classroom->building }}:  {{ $coursePeriod->classroom->name }}
                        @endforeach
                        <br>
                        {{ $schedule->start_at->format('h:i:s A') }} - {{ $schedule->start_at->format('h:i:s A') }}
                        <hr>
                    @endforeach
                </td>
            @endisset

            @isset($horario[\App\Schedule::WEEKDAY['sunday']])
                <td>
                    @foreach($horario[\App\Schedule::WEEKDAY['sunday']] as $schedule)
                        @foreach($schedule->coursePeriods as $coursePeriod)
                            {{ $coursePeriod->course->name }}   {{ $coursePeriod->course->typeCourse->name }}
                            <br>
                            Profesor:  {{ $coursePeriod->teacher->full_name }}
                            <br>
                            {{ $coursePeriod->classroom->building }}:  {{ $coursePeriod->classroom->name }}
                        @endforeach
                        <br>
                        {{ $schedule->start_at->format('h:i:s A') }} - {{ $schedule->start_at->format('h:i:s A') }}
                        <hr>
                    @endforeach
                </td>
            @endisset
        </tr>
        </tbody>
    </table>
</div>

</body>
</html>