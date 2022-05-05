<template>
    <div>
        <b-button @click="showGraphChart" variant="outline-dark" size="sm">
            <i class="mdi mdi-graph-outline font-size-16"/> Diagrama
        </b-button>
        <b-button @click="showScriptModal" variant="outline-dark" size="sm">
            <i class="mdi mdi-monitor-eye font-size-16"/> Preview
        </b-button>
        <div class="row p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-5">Preguntas</h4>
                            <div class>
                                <ul class="verti-timeline list-unstyled">
                                    <li class="event-list" v-for="(question, index) in questions">
                                        <div class="event-timeline-dot">
                                            <i class="bx bx-right-arrow-circle"></i>
                                        </div>
                                        <div class="media">
                                            <div class="me-3">
                                                <i class="h2 text-secondary" :class="getIcon(question.type)"></i>
                                            </div>
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="d-flex flex-row">
                                                            <h5 class="mr-2" >
                                                               <span class="text-warning" v-if="question.first">
                                                                   <i class="mdi mdi-star-outline" />
                                                               </span>
                                                                {{ question.question }}
                                                            </h5>
                                                            <div v-for="file in question.files">
                                                                <a :href="file.fullPath" style="margin-left: 10px" class="text-success" target="_blank">
                                                                    <i class="bx bx-file-blank font-size-22"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <p v-if="!isCustomQuestion(question)" class="text-muted" v-text="question.description"></p>
                                                        <div v-else class="description" v-html="question.description"></div>
                                                        <div class="row justify-content-center" v-for="option in question.options">
                                                            <div v-show="option.name" class="p-1 col-6 border border-light txt9">
                                                                {{ option.name }}
                                                            </div>
                                                            <div v-show="getQuestionById(option.next_question_id)" class="p-1 col-6 border border-light txt9">
                                                                {{ getQuestionById(option.next_question_id) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                    </div>
                                                    <div class="col-2">
                                                        <b-button @click="editQuestion(index)" variant="info" size="sm">
                                                            <i class="mdi mdi-pencil font-size-12"/>
                                                        </b-button>
                                                        <b-button @click="deleteQuestion(index)" variant="danger" size="sm">
                                                            <i class="mdi mdi-trash-can font-size-12"/>
                                                        </b-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <GraphModal />
        <ScriptModal />
    </div>
</template>

<script>
import GraphModal from "./GraphModal";
import ScriptModal from "./ScriptModal";
import {QuestionType} from "../../../Adapters/Const/QuestionTypes";

export default {
    components: { GraphModal, ScriptModal },
    props: {
        questions: { type: Array, default: [] }
    },
    methods:{
        showGraphChart(){
            this.$modal.show('graph', { 'questions' : this.questions });
        },
        showScriptModal(){
            this.$modal.show('script', { 'questions' : this.questions });
        },
        getQuestionById(id){
            const question = this.questions.find(element => element.id === id);
            return (question) ? question.question : '';
        },
        editQuestion(index){
            this.$emit('onEditQuestion', index);
        },
        deleteQuestion(index){
            this.$emit('onDeleteQuestion', index);
        },
        isCustomQuestion(question) {
            return question.type === QuestionType.CUSTOM_TEXT;
        },
        getIcon(type){
            if(type === QuestionType.CUSTOM_TEXT){
                return 'bx bx-sort-a-z';
            }else if(type === QuestionType.MULTIPLE){
                return 'bx bx-select-multiple';
            }
            return "bx bx bx-text";
        }
    },
}
</script>

<style scoped>
    .txt9{
        font-size: 0.9em;
    }
</style>
