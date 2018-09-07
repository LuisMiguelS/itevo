<template>
    <main>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border"><h3 class="box-title">Estudiantes</h3></div>
                <div class="box-body">
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
            </div>

            <div class="box" v-if="student">
                <div class="box-header with-border"><h3 class="box-title">Deudas</h3></div>
                <div class="box-body">
                    <ul class="list-group">
                        <a class="list-group-item" v-for="item_invoice in student.invoices">
                            <h5 class="list-group-item-heading" v-for="item_course_period in item_invoice.course_period">
                                {{ item_course_period.course.name }} ({{ item_course_period.course.type_course.name }})
                            </h5>
                            <p class="list-group-item-text">asds sad asd dsadasds ds adsdsada</p>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">

        </div>
    </main>
</template>

<script>
    export default {
        name: "accounts_receivable",
        props: ['branchOffice'],
        data() {
            return {
                students: [],
                student: null,
                course: null,
                payment: 0,
                cash_received: 0,
                resources: [],
            }
        },
        mounted(){
            axios.get(`/${this.branchOffice.slug}/accounts/receivable/students`).then((response) => {
                this.students = response.data.data;
            });
        },
        methods: {
            fullName ({ name, last_name }) {
                return `${name} ${last_name}`;
            },
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>