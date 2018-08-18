<template>
    <form  @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group row" :class="{ 'has-error' : form.errors.has('course_id') }">
                    <label class="col-sm-4 col-form-label text-md-right">Curso</label>

                    <div class="col-md-12">
                        <v-select v-model="course_id" :options="courses">
                            <template slot="no-options">
                                lo siento, no hay opciones de coincidencia...
                            </template>
                        </v-select>

                        <span class="help-block" v-show="form.errors.has('course_id')">
                            <strong v-text="form.errors.first('course_id')"></strong>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row" :class="{ 'has-error' : form.errors.has('classroom_id') }">
                    <label class="col-sm-4 col-form-label text-md-right">Aula</label>

                    <div class="col-md-12">
                        <v-select name="classroom_id" v-model="classroom_id" :options="classrooms">
                            <template slot="no-options">
                                lo siento, no hay opciones de coincidencia...
                            </template>
                        </v-select>

                        <span class="help-block" v-show="form.errors.has('classroom_id')">
                            <strong v-text="form.errors.first('classroom_id')"></strong>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group row" :class="{ 'has-error' : form.errors.has('teacher_id') }">
            <label class="col-sm-4 col-form-label text-md-right">Profesor</label>

            <div class="col-md-12">
                <v-select name="teacher_id" v-model="teacher_id" :options="teachers">
                    <template slot="no-options">
                        lo siento, no hay opciones de coincidencia...
                    </template>
                </v-select>

                <span class="help-block" v-show="form.errors.has('teacher_id')">
                    <strong v-text="form.errors.first('teacher_id')"></strong>
                </span>
            </div>
        </div>

        <div class="form-group row" :class="{ 'has-error' : form.errors.has('teacher_id') }">
            <label class="col-sm-4 col-form-label text-md-right">Precio</label>

            <div class="col-md-12">
                <vue-numeric name="price" class="form-control" currency="RD $" separator="," v-model="form.price" :precision="2"></vue-numeric>

                <span class="help-block" v-show="form.errors.has('price')">
                    <strong v-text="form.errors.first('price')"></strong>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group row" :class="{ 'has-error' : form.errors.has('start_at') }">
                    <label class="col-sm-12 col-form-label text-md-right">Fecha de inicio</label>

                    <div class="col-md-12">
                        <date-picker v-model="form.start_at" format="DD-MM-YYYY" lang="es"></date-picker>

                        <span class="help-block" v-show="form.errors.has('start_at')">
                            <strong v-text="form.errors.first('start_at')"></strong>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row" :class="{ 'has-error' : form.errors.has('ends_at') }">
                    <label class="col-sm-12 col-form-label text-md-right">Fecha de finalizacion</label>

                    <div class="col-md-12">
                        <date-picker v-model="form.ends_at" format="DD-MM-YYYY" lang="es" :not-before="form.start_at"></date-picker>

                        <span class="help-block" v-show="form.errors.has('ends_at')">
                            <strong v-text="form.errors.first('ends_at')"></strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block">
                    Guardar
                </button>
            </div>
        </div>

    </form>
</template>

<script>

    export default {
        props: ['courses', 'classrooms', 'teachers', 'coursePeriod', 'form_data'],
        data() {
            return {
                course_id: this.coursePeriod instanceof Object ? {id: this.coursePeriod.course_id, label: this.coursePeriod.course.name + ` (${this.coursePeriod.course.type_course.name})`} : '',
                classroom_id: this.coursePeriod instanceof Object ? {id: this.coursePeriod.classroom_id, label: this.coursePeriod.classroom.name + ` (${this.coursePeriod.classroom.building})`} : '',
                teacher_id: this.coursePeriod instanceof Object ? {id: this.coursePeriod.teacher_id, label: this.coursePeriod.teacher.name + ` ${this.coursePeriod.teacher.last_name}`} : '',
                form: new Form({
                    course_id: this.coursePeriod instanceof Object ? this.coursePeriod.course_id : '',
                    classroom_id: this.coursePeriod instanceof Object ? this.coursePeriod.classroom_id : '',
                    teacher_id: this.coursePeriod instanceof Object ? this.coursePeriod.teacher_id : '',
                    price: this.coursePeriod instanceof Object ? this.coursePeriod.price : '',
                    start_at: this.coursePeriod instanceof Object ? this.coursePeriod.start_at : '',
                    ends_at: this.coursePeriod instanceof Object ? this.coursePeriod.ends_at : '',
                }),
            };
        },
        methods: {
            onSubmit() {
                this.form[this.form_data['method']](this.form_data['route'])
                    .then(() => {
                        window.location.href = this.form_data['redirect'];
                    }).catch(error => {
                        console.log(error);
                });
          },
        },
        watch: {
            course_id: function (obj) {
                if (obj instanceof Object) this.form.course_id = this.course_id.id;
            },
            classroom_id: function (obj) {
                if (obj instanceof Object) this.form.classroom_id = this.classroom_id.id;
            },
            teacher_id: function (obj) {
                if (obj instanceof Object) this.form.teacher_id = this.teacher_id.id;
            }
        }
    }
</script>
