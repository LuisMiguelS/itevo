@csrf

<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del curso <span class="text-danger">*</span></label>

    <div class="col-md-12">
        <input id="name"
               class="form-control"
               name="name"
               type="text"
               value="{{ old('name', $course->name) }}"
               required
               autofocus>

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('type_course_id') ? 'has-error' : '' }}">
    <label for="institute_id" class="col-sm-4 col-form-label text-md-right">Tipo de curso <span class="text-danger">*</span></label>

    <div class="col-md-12">
        <div class="form-group">
            @if($typeCourses->isNotEmpty())
                <select class="form-control" id="type_course_id" name="type_course_id">
                    <option disabled>Seleciona una opción</option>
                    @foreach($typeCourses as $typeCourse)

                        <option value="{{ $typeCourse->id }}"
                                {{ old('type_course_id') == $typeCourse->id ? 'selected' : '' }}>
                            {{ $typeCourse->name }}
                        </option>
                    @endforeach
                </select>
            @else
                <div class="alert alert-info">
                        <strong>No tienes un tipo de curso creado, <a href="{{ route('tenant.typeCourses.create', $branchOffice) }}">haga clic aquí para crear uno</a></strong>
                </div>
            @endif

            @if ($errors->has('type_course_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('type_course_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>