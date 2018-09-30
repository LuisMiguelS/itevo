<template>
    <main>
        <error-account-recivable :errors="errors" v-if="errors"></error-account-recivable>

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
                                     @input="dispatchActionStudent"
                                     placeholder="Seleciona un estudiante">
                            <span slot="noResult">Oops! No se encontraron resultados. Considere cambiar la consulta de búsqueda.</span>
                        </multiselect>
                    </div>
                </div>
            </div>

            <debts v-if="student"
                   :student="student"
                   v-on:click-debt="getInvoice">
            </debts>

        </div>

        <resources v-if="invoice" :invoice="invoice" v-on:change-resources="changeResources"></resources>

        <div class="col-md-4" v-if="invoice">

            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-success btn-block"
                            @click.prevent="facturar"
                            :disabled="isDisabled">
                        Facturar</button>
                </div>
                <div class="box-body">

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
    import ErrorAccountRecivable from './ErrorAccountRecivable';
    import Debts from './debt';
    import Resources from './Resources';

    export default {
        name: "accounts_receivable",
        props: ['branchOffice'],
        components: {
            ErrorAccountRecivable,
            Debts,
            Resources
        },
        data() {
            return {
                students: [],
                student: null,
                payment: 0,
                cash_received: 0,
                resources: [],
                invoice: null,
                errors: false,
            }
        },
        mounted(){
            this.getStudent();
        },
        methods: {
            getStudent(){
                axios.get(`/${this.branchOffice.slug}/accounts/receivable/students`).then((response) => {
                    this.students = response.data.data;
                });
            },
            fullName ({ name, last_name }) {
                return `${name} ${last_name}`;
            },
            getInvoice(invoice){
                this.invoice = invoice;
            },
            dispatchActionStudent(){
                this.invoice = null;
                this.resources = [];
            },
            facturar() {
                axios.post(`/${this.branchOffice.slug}/accounts/receivable`, {
                    'invoice_id': this.invoice.id,
                    'resources': this.resources,
                    'paid_out': this.payment,
                    'cash_received': this.cash_received,
                }).then((response => {
                    this.clear();
                    window.open(`/${this.branchOffice.slug}/invoices/accounts/receivable/${response.data.data.id}`, '_blank').focus();
                    this.getStudent();
                })).catch((error => {
                    this.errors = false;
                    this.errors = error.response.data;
                }));
            },
            clear() {
                this.student = null;
                this.payment = 0;
                this.cash_received = 0;
                this.resources = [];
                this.invoice = null;
                this.errors = false;
            },
            changeResources(newResources) {
                this.resources = newResources;
            }
        },
        computed: {
            totalResource() {
                return this.resources.reduce((total, resource) => total + resource.price, 0);
            },
            total() {
                if (! this.invoice) return 0;
                return parseFloat(this.invoice.total - this.invoice.balance) + parseFloat(this.totalResource);
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