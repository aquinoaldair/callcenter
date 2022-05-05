<template>
    <b-button @click="onClick" variant="success">
        <i class="mdi mdi-plus font-size-14"/> {{ text }}
    </b-button>
</template>

<script>
    export default {
        props: {
            text : { type: String, required: true }
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
