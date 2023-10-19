<template>
    <div v-if="hasError" class="alert alert-danger">
        <ul>
            <li v-for="error of errors">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        errors: Array,
    },
    computed: {
        hasError() {
            return this.errors && this.errors.length > 0;
        },
    },
}
</script>