<template>
    <div>
        <p> <strong> Estudiante:</strong> {{ student.name }} {{ student.last_name }} </p>
        <p> <strong> Cedula:</strong> {{ student.id_card }}</p>
        <p> <strong> Cedula del tutor:</strong> {{ student.tutor_id_card }} </p>
        <p> <strong> Telefono:</strong> {{ student.phone }} </p>
        <p style="margin-top:20px"> <strong>Notas:</strong> {{ student.notes }}</p>
    </div>
</template>

<script>
    export default {
        name: "StudentInfo",
        props: ['student']
    }
</script>