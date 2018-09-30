<template>
    <div class="box">
        <div class="box-header with-border"><h3 class="box-title">Deudas</h3></div>
        <div class="box-body">
            <ul class="list-group">
                <a class="list-group-item" v-for="item_invoice in student.invoices" @click="$emit('click-debt', item_invoice)">
                    <h5 class="list-group-item-heading" v-for="item_course_period in item_invoice.course_period">
                        {{ item_invoice.created_at.date | moment("DD/MM/YYYY") }} {{ item_course_period.course.name }} ({{ item_course_period.course.type_course.name }})
                    </h5>
                    <p class="list-group-item-text"><strong>Total:</strong> {{ item_invoice.total }}</p>
                    <p class="list-group-item-text"><strong>Total Pagado:</strong> {{ item_invoice.balance }}</p>
                </a>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "debt",
        props: ['student'],
    }
</script>