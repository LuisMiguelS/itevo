<template>
    <main>
        <div class="col-md-8">

            <div class="box">
                <div class="box-header with-border"><h3 class="box-title">Inscripcion</h3></div>
                <div class="box-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estudiante <span class="text-danger">*</span></label>
                                    <multiselect id="student_id"
                                                 v-model="student"
                                                 :options="students"
                                                 :custom-label="fullName"
                                                 placeholder="Seleciona un estudiante">
                                        <span slot="noResult">Oops! No se encontraron resultados. Considere cambiar la consulta de búsqueda.</span>
                                    </multiselect>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Curso <span class="text-danger">*</span></label>
                                    <multiselect id="course_id"
                                                 v-model="course"
                                                 :options="courses"
                                                 :custom-label="courseFullName"
                                                 @input="dispatchActionCourse"
                                                 placeholder="Seleciona un curso">
                                        <span slot="noResult">Oops! No se encontraron resultados. Considere cambiar la consulta de búsqueda.</span>
                                    </multiselect>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                              <div v-if="student">
                                  <p> <strong> Estudiante:</strong> {{ student.name }} {{ student.last_name }} </p>
                                  <p> <strong> Cedula:</strong> {{ student.id_card }}</p>
                                  <p> <strong> Cedula del tutor:</strong> {{ student.tutor_id_card }} </p>
                                  <p> <strong> Telefono:</strong> {{ student.phone }} </p>
                                  <p style="margin-top:20px"> <strong>Notas:</strong> {{ student.notes }}</p>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div v-if="course">
                                  <p> <strong> Curso:</strong> {{ course.course.name }} ({{ course.course.type_course.name }})</p>
                                  <p> <strong> Fecha de inicio:</strong> {{ course.start_at.date }} </p>
                                  <p> <strong> Fecha de finalización:</strong> {{ course.ends_at.date }}</p>
                                  <p> <strong> Profesor:</strong> {{ course.teacher.full_name }}</p>
                                  <p> <strong> Aula:</strong> {{ course.classroom.name }} - {{ course.classroom.building }}</p>
                                  <p> <strong>Horario</strong>
                                      <small v-for="schedule in course.schedules"> {{ schedule.weekday }} {{ schedule.start_at.date}} - {{ schedule.ends_at.date}}</small>
                                  </p>
                              </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="box" v-if="course">
                <div class="box-body">
                    <div class="form-group row">
                        <div class="col-md-12 row">
                            <div class="custom-control custom-checkbox col-md-6" v-for="resource in course.resources">
                                <input class="custom-control-input"
                                       type="checkbox"
                                       :id="resource.id"
                                       :value="resource"
                                       :disabled="resource.necessary === 1"
                                       v-model="resources">
                                <label class="custom-control-label" :for="resource.id">{{ resource.name }} - costo {{ resource.price | currency }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-success btn-block"
                            @click.prevent="inscription"
                            :disabled="isDisabled">
                        Facturar</button>
                </div>
                <div class="box-body">

                    <h3>Curso: {{ totalCourse | currency }}</h3>

                    <h3>Recursos: {{ totalResource | currency }}</h3>

                    <h3>Total: {{ total | currency }}</h3>

                    <div class="form-group">
                        <label>Monto a pagar</label>

                        <vue-numeric
                                class="form-control"
                                placeholder="Monto a pagar"
                                currency="$"
                                separator=","
                                v-bind:minus="false"
                                v-bind:min="totalResource"
                                v-bind:max="total"
                                v-model="payment"></vue-numeric>
                    </div>

                    <div class="form-group">
                        <label>Efectivo recibido</label>

                        <vue-numeric
                                class="form-control"
                                placeholder="Efectivo recibido"
                                currency="$"
                                separator=","
                                v-bind:minus="false"
                                v-bind:min="payment"
                                v-bind:max="20000"
                                v-model="cash_received"></vue-numeric>
                    </div>

                    <div class="alert alert-info" role="alert" v-if="retunedMoney">
                        <strong> Devuelta: {{ retunedMoney | currency }} </strong>
                    </div>

                </div>
            </div>

        </div>
    </main>
</template>

<script>
    export default {
        name: "inscription",
        props: ['branchOffice'],
        data() {
            return {
                students: [],
                student: null,
                courses: [],
                course: null,
                payment: 0,
                cash_received: 0,
                resources: [],
            }
        },
        mounted(){
            axios.get(`/${this.branchOffice.slug}/inscription/students`).then((response) => {
                this.students = response.data.data;
            });

            axios.get(`/${this.branchOffice.slug}/inscription/courses`).then((response) => {
                this.courses = response.data.data;
            });
        },
        methods: {
            fullName ({ name, last_name }) {
                return `${name} ${last_name}`;
            },
            courseFullName({ course }) {
                return `${course.name} (${course.type_course.name})`;
            },
            dispatchActionCourse() {
              this.resource = [];
              if (this.course) {
                  this.course.resources.forEach(resource => {
                     if (resource.necessary === 1) {
                         this.resources.push(resource);
                     }
                  });
              }
            },
            inscription() {
                axios.post(`/${this.branchOffice.slug}/inscriptiones`, {
                    'student_id': this.student.id,
                    'course_period': [this.course],
                    'resources': this.resources,
                    'paid_out': this.payment,
                    'cash_received': this.cash_received,
                }).then((response => {
                    this.clear();
                     window.open(`/${this.branchOffice.slug}/invoices/${response.data.data.id}`, '_blank').focus();
                })).catch((error => {
                    if (error.response) {
                        console.log(error.response.data.message);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                }));
            },
            clear() {
                this.student = null;
                this.course = null;
                this.payment = 0;
                this.cash_received = 0;
                this.resources = [];
            }
        },
        computed: {
            totalCourse() {
                if (this.course)
                    return this.course.price;

                return 0;
            },
            totalResource() {
                return this.resources.reduce((total, resource) => total + resource.price, 0);
            },
            total() {
                return parseFloat(this.totalCourse) + parseFloat(this.totalResource);
            },
            retunedMoney() {
                if (this.payment > this.cash_received) {
                    return false;
                }

                return parseFloat(this.cash_received - this.payment);
            },
            isDisabled() {
                if (this.payment === 0
                    || this.cash_received === 0
                    || this.retunedMoney === false) {
                    return true;
                }
                return false;
            }
        }

    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>