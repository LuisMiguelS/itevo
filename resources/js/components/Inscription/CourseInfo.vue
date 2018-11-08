<template>
    <div v-if="course">
        <p> <strong> Curso:</strong> {{ course.course.name }} ({{ course.course.type_course.name }})</p>
        <p> <strong> Fecha de inicio:</strong> {{ course.start_at.date | moment("dddd, MMMM D YYYY") }} </p>
        <p> <strong> Fecha de finalización:</strong> {{ course.ends_at.date | moment("dddd, MMMM D YYYY") }}</p>
        <p> <strong> Profesor:</strong> {{ course.teacher.full_name }}</p>
        <p> <strong> Aula:</strong> {{ course.classroom.name }} - {{ course.classroom.building }}</p>
        <p> <strong> Estudiantes inscritos:</strong> {{ course.students_count }} </p>
        <p> <strong>Horario:</strong>
            <small v-for="schedule in course.schedules"><br> {{ schedule.weekday }} {{ schedule.start_at.date |  moment("h:mm a") }} - {{ schedule.ends_at.date |  moment("h:mm a") }}</small>
        </p>
    </div>
</template>

<script>
    export default {
        name: "CourseInfo",
        props: ['course']
    }
</script>