<template>
    <b-button  @click="redirectBack" variant="warning">
        <i class="mdi mdi-keyboard-backspace font-size-16"/>
        Regresar
    </b-button>
</template>

<script>
export default {
    props: { url: String, required: true },
    methods: {
        redirectBack(){
            console.log(this.url);
            this.$inertia.get(this.url);
        }
    }
}
</script>

<style scoped>

</style>
