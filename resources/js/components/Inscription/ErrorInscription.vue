<template>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong v-if="errors.message"> {{ errors.message }}</strong>
        <ul v-for="error in errors.errors">
            <li v-for="message in error">
                {{ message }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "Errors",
        props: ['errors']
    }
</script>