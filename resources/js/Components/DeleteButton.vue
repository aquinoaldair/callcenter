<template>
    <b-button @click="onClick" variant="danger" size="sm">
        <i class="mdi mdi-trash-can d-block font-size-14"/> {{ text }}
    </b-button>
</template>

<script>
    export default {
        props: {
            text : { type: String, required: false }
        },
        methods:{
            onClick(){
                this.$emit('onClick');
            }
        }
    }
</script>

<style scoped>

</style>
