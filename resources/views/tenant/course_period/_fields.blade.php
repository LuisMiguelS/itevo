@csrf

<div class="row">

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('course_id') ? 'has-error' : '' }}">
            <label>Curso <span class="text-danger">*</span></label>
            <select class="form-control" name="course_id">
                @foreach($courses as $course)
                    <option value="{{ $course['id'] }}"
                            {{ $course['id'] ===  old('course_id', $coursePeriod->course_id) ? 'selected' : '' }}>
                        {{ $course['label'] }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('course_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('course_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('classroom_id') ? 'has-error' : '' }}">
            <label>Aula <span class="text-danger">*</span></label>
            <select class="form-control" name="classroom_id">
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom['id'] }}"
                            {{ $classroom['id'] ===  old('classroom_id', $coursePeriod->classroom_id) ? 'selected' : '' }}>
                        {{ $classroom['label'] }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('classroom_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('classroom_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

</div>

<div class="form-group {{ $errors->has('teacher_id') ? 'has-error' : '' }}">
    <label>Profesor <span class="text-danger">*</span></label>
    <select class="form-control" name="teacher_id">
        @foreach($teachers as $teacher)
            <option value="{{ $teacher['id'] }}"
                    {{ $teacher['id'] ===  old('teacher_id', $coursePeriod->teacher_id) ? 'selected' : '' }}>
                {{ $teacher['label'] }}
            </option>
        @endforeach
    </select>

    @if ($errors->has('teacher_id'))
        <span class="help-block">
            <strong>{{ $errors->first('teacher_id') }}</strong>
        </span>
    @endif
</div>

<div class="form-group row {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Precio: <span class="text-danger">*</span></label>

    <div class="col-md-12">
        <input id="price"
               type="number"
               class="form-control"
               name="price"
               value="{{ old('price', $coursePeriod->price) }}"
               min="100"
               required>

        @if ($errors->has('price'))
            <span class="help-block">
	            <strong>{{ $errors->first('price') }}</strong>
	        </span>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('start_at') ? 'has-error' : '' }}" >
            <label  class="control-label">Fecha de inicio <span class="text-danger">*</span>
            </label>

            <input id="start_at"
                   type="date"
                   class="form-control"
                   name="start_at"
                   value="{{ old('start_at', $coursePeriod->start_at->format('Y-m-d')) }}"
                   min="{{$period->start_at->format('Y-m-d')}}"
                   required>

            @if ($errors->has('start_at'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_at') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('ends_at') ? 'has-error' : '' }}" >
            <label  class="control-label">Hora de finalizacion <span class="text-danger">*</span></label>

            <input id="ends_at"
                   type="date"
                   class="form-control"
                   name="ends_at"
                   value="{{ old('ends_at', $coursePeriod->ends_at->format('Y-m-d')) }}"
                   max="{{$period->ends_at->format('Y-m-d')}}"
                   required>

            @if ($errors->has('ends_at'))
                <span class="help-block">
                  <strong>{{ $errors->first('ends_at') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>