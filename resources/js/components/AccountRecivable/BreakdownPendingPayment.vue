<template>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Desglose de pago pendiente al curso</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Semana</th>
                    <th scope="col">Pago por semana</th>
                    <th scope="col">Saldo por semana</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="pending_payment in this.BreakdownPendingPayment" :class="pending_payment.label">
                    <th>{{ pending_payment.week}}</th>
                    <th>{{ pending_payment.payment_per_week | currency }}</th>
                    <th>{{ pending_payment.balance_per_week | currency }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BreakdownPendingPayment",
        props: ['branch_office_slug','invoice'],
        data() {
            return {
                BreakdownPendingPayment: {},
            }
        },
        mounted(){
            axios.get(`/${this.branch_office_slug}/accounts/receivable/invoices/${this.invoice.id}`).then((response) => {
                this.BreakdownPendingPayment = response.data.data;
                this.$emit('breakdown-pending-payment', this.BreakdownPendingPayment)
            });
        },
    }
</script>