<template>
    <modal name="graph"
           width="800"
           height="600"
           @before-open="beforeOpen"
           @before-close="beforeClose">

        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <b-button @click="closeModal" variant="outline-danger" size="ms">
                    <i class="mdi mdi-close-thick font-size-16"/>
                </b-button>
            </div>
        </div>

        <div class="row">
            <GraphChart v-if="questions.length" :questions="questions" />
        </div>

    </modal>
</template>

<script>
import GraphChart from "./GraphChart";
export default {
    components: { GraphChart },
    data(){
        return {
            questions: []
        }
    },
    methods:{
        beforeOpen({params}){
            this.questions = params.questions;
        },
        beforeClose(){
            this.questions = [];
        },
        closeModal(){
            this.$modal.hide('graph');
        }
    }
}
</script>

<style scoped>

</style>
