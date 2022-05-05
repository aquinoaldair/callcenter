<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-md-12">
                    <label for="name">Pregunta</label>
                    <textarea id="name" rows="5" required v-model="form.question" class="form-control" />
                </div>
                <div class="col-md-12 mt-4">
                    <label for="description" class="text-muted">Descripcion(opcional)</label>
                    <textarea id="description" rows="5"  v-model="form.description" class="form-control" />
                </div>
                <div class="col-md-12 mt-4" v-show="questions.length">
                    <label for="next">Ir a siguiente Pregunta</label>
                    <v-select id="next" v-model="form.options[0].next_question_id" :reduce="question => question.id" label="question" :options="questions" />
                </div>
                <div class="mt-5">
                    <store-button v-if="!loading" />
                    <loading-button v-if="loading" />
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import StoreButton from "../../../../Components/StoreButton";
import LoadingButton from "../../../../Components/LoadingButton";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

export default {
    components: {StoreButton, vSelect, LoadingButton},
    props: {
        questions : { type: Array, default : [] },
        loading: { type: Boolean, default: false},
        question: { default: null }
    },
    data(){
        return {
            form: {
                question: null,
                type: 'Texto Largo',
                description: null,
                options: [
                    {
                        next_question_id : null,
                        name: ''
                    }
                ]
            }
        }
    },
    created() {
        if (this.question === null) return true;
        this.form = JSON.parse(JSON.stringify(this.question));
    },
    methods: {
        save(){
            this.$emit('onClick', this.form);
        }
    },
    computed:{
        foo(){
            return this.question
        }
    },
    watch: {
        foo(val){
            console.log(val);
        }
    }
}
</script>

<style scoped>

</style>
