<template>
    <modal name="script" width="800" height="600" @before-open="beforeOpen" @before-close="beforeClose">
        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <b-button @click="closeModal" variant="outline-danger" size="ms">
                    <i class="mdi mdi-close-thick font-size-16"/>
                </b-button>
            </div>
        </div>
        <div class="row">
            <script-show :questions="questions" />
        </div>
    </modal>
</template>

<script>
import Show from "../Script/Show";
export default {
    components: { ScriptShow: Show },
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
            this.$modal.hide('script');
        }
    }
}
</script>

<style scoped>

</style>
