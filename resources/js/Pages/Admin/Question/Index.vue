<template>
    <admin-layout>
        <breadcrumb :title="title" />
        <notifications group="questions" position="top left"/>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-4">
                            <label for="type">Seleccione el tipo de pregunta</label>
                            <v-select :disabled="editing" v-model="type" id="type" :options="types" />
                        </div>
                        <div class="row mt-4">
                            <short-text-question v-if="isShortTextQuestion"
                                                 @onClick="storeOrUpdateQuestion"
                                                 :questions="questions"
                                                 :question="question"
                                                 :loading="loading" >
                                <b-button v-if="question !== null" @click="cancelEdit"  variant="warning" size="md">
                                    <i class="mdi mdi-cancel font-size-14"/> Cancelar
                                </b-button>
                            </short-text-question>

                            <multiple-question v-if="isMultipleQuestion"
                                               @onClick="storeOrUpdateQuestion"
                                               :questions="questions"
                                               :question="question"
                                               :loading="loading" >
                                <b-button v-if="question !== null" @click="cancelEdit"  variant="warning" size="md">
                                    <i class="mdi mdi-cancel font-size-14"/> Cancelar
                                </b-button>
                            </multiple-question>

                            <custom-text-question v-if="isCustomQuestion"
                                                  @onClick="storeOrUpdateQuestion"
                                                  :questions="questions"
                                                  :question="question"
                                                  :loading="loading">
                                <b-button v-if="question !== null" @click="cancelEdit"  variant="warning" size="md">
                                    <i class="mdi mdi-cancel font-size-14"/> Cancelar
                                </b-button>
                            </custom-text-question>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <card-question
                            @onEditQuestion="editQuestion"
                            @onDeleteQuestion="deleteQuestion"
                            :questions="questions" />
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Breadcrumb from "../../../Components/Breadcrumb";
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import RedirectButton from "../../../Components/RedirectButton";
import StoreButton from "../../../Components/StoreButton";
import LongTextQuestion from "./TypeQuestion/LongTextQuestion";
import GraphChart from "./GraphChart";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import ShortTextQuestion from "./TypeQuestion/ShortTextQuestion";
import MultipleQuestion from "./TypeQuestion/MultipleQuestion";
import CardQuestion from "./CardQuestion";
import ConfirmMixin from "../../../Mixin/ConfirmMixin";
import CustomTextQuestion from "./TypeQuestion/CustomTextQuestion";

export default {
    components: {
        GraphChart,
        CustomTextQuestion,
        CardQuestion,
        MultipleQuestion,
        ShortTextQuestion, LongTextQuestion, vSelect, StoreButton, RedirectButton, Breadcrumb, AdminLayout},
    mixins: [ConfirmMixin],
    props: {
        errors : { type: Object },
        script : { type: Object },
    },
    data(){
        return {
            loading: false,
            questions: [],
            question: null,
            types: ['Texto Corto', 'Multiple', 'Texto Personalizado'],
            type: 'Texto Corto',
            title: `Script: ${this.script.name}`,
            form: {
                name: null,
            }
        }
    },
    created() {
        this.getQuestions();
    },
    methods: {
        async getQuestions(){
            try {
                const {data} = await axios.get(this.route('question.script', this.script.id));
                this.questions = data.questions;
            } catch (error) {
                console.error(error);
            }
        },
        async storeOrUpdateQuestion(data){
             (this.editing)
                 ? await  this.updateQuestion(data)
                 : await this.storeQuestion(data);
             this.cancelEdit();
        },
        async updateQuestion(data){
            this.loading = true;
            try {
                await axios.put(this.route('question.update', {
                    script_id : this.script.id,
                    question :  data.id
                }), data);
                this.showMessage("Se ha guardado correctamente", 'success');
                await this.getQuestions();
            } catch (error) {
                this.showMessage("No se ha podido guardar, intente mas tarde", 'warn')
            }
            this.loading = false;
        },
        async storeQuestion(data){
            this.loading = true;
            data.script_id = this.script.id;
            try {
                await axios.post(this.route('question.store', this.script.id), data);
                this.restoreType('Texto Corto');
                this.showMessage("Se ha guardado correctamente", 'success');
                await this.getQuestions();
            } catch (error) {
                this.showMessage("No se ha podido guardar, intente mas tarde", 'warn')
            }
            this.loading = false;
        },
        async deleteQuestion(index){

            if (!await this.confirmDeletion()) return true;

            const item = this.questions[index];

            const  result = await axios.delete(this.route('question.destroy', {
                script_id : this.script.id,
                question        :  item.id
            }));

            if (!!result.data.success){
                this.$swal('Eliminado', result.data.message, 'success');
                await this.getQuestions();
            }

        },
        restoreType(type){
            this.type = null;
            //cargamos el componente de nuevo
            this.$nextTick(() => {
                this.type = type
            });
        },
        editQuestion(index){
            this.question = this.questions[index];
            this.restoreType(this.question.type);
        },
        cancelEdit(){
            this.question = null;
            this.restoreType('Texto Corto');
        },
        showMessage(text, type){
            this.$notify({
                group: 'questions',
                text: text,
                type: type
            });
        }
    },
    computed:{
        isLongTextQuestion(){
            return this.type === 'Texto Largo';
        },
        isShortTextQuestion(){
            return this.type === 'Texto Corto';
        },
        isMultipleQuestion() {
            return this.type === 'Multiple';
        },
        isCustomQuestion() {
            return this.type === 'Texto Personalizado';
        },
        editing(){
            return this.question !== null;
        }
    }
}
</script>

<style scoped>

</style>
