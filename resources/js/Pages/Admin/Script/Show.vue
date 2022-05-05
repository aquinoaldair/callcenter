<template>
    <div class="container">
        <div  class="row  mh-100 p-0 border">
            <transition :name="transitionName">
                <div v-if="currentQuestion!==null" class="col-12 align-self-start">
                    <div  class="row p-4">
                        <div class="col-12">
                            <div class="d-flex flex-row">
                                <p class="mr-2" >
                                    {{ currentQuestion.question }}
                                </p>
                                <div v-for="file in currentQuestion.files">
                                    <a :href="file.fullPath" style="margin-left: 10px" class="text-success" target="_blank">
                                        <i class="bx bx-file-blank font-size-22"></i>
                                    </a>
                                </div>
                            </div>
                            <h4 v-if="!isCustomQuestion(currentQuestion)" class="text-muted" v-text="currentQuestion.description"></h4>
                            <div v-else class="description" v-html="currentQuestion.description"></div>
                        </div>
                        <div v-if="isMultipleQuestion" class="col-12 mt-2">
                            <div class="d-flex flex-column ">
                                <div class="p-2"  v-for="option in currentQuestion.options ">
                                    <button @click="onSelectOptionMultiple(option)" type="button" class="btn btn-outline-secondary">
                                        {{ option.name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <div v-if="currentQuestion!==null" class="col-12 align-self-end p-4 col-foot border-top" >
                <div class="row">
                    <div class="col-4">
                        <button @click="onPreviousQuestion" v-if="isNotFirstQuestion" type="button" class="btn btn-success">
                            <i class="bx bx-left-arrow-alt font-size-16 align-middle me-2"></i>
                            Atrás
                        </button>
                    </div>
                    <div class="col-8">
                        <div class="d-flex flex-row-reverse bd-highlight">
                            <div class="p-2 bd-highlight">
                                <button v-if="!isMultipleQuestion"  @click="onNextQuestion" type="button" class="btn btn-success">
                                    <i class="bx bx-right-arrow-alt font-size-16 align-middle me-2"></i>
                                    Siguiente
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { QuestionType } from "../../../Adapters/Const/QuestionTypes";

export default {
    components: { },
    props: {
        questions: { type: Array, required: true }
    },
    data(){
        return {
            currentQuestion : null,
            currentOption: null,
            transitionName: 'fadeRight',
            previousQuestions : [],
        }
    },
    created() {
        this.getFirstQuestion();
    },
    methods:{
        onNextQuestion(){
            this.transitionName = 'fadeRight';
            this.previousQuestions.push(this.currentQuestion);
            this.currentQuestion = null;
            this.step++;
            this.$nextTick(() => {
                this.currentQuestion = this.getNextQuestion() ?? null;
            });
        },
        onPreviousQuestion(){
            this.transitionName = 'fadeLeft';
            this.currentQuestion = null;
            this.step--;
            this.$nextTick(() => {
                this.currentQuestion = this.getPreviousQuestion();
            });
        },
        getFirstQuestion(){
            this.currentQuestion = this.questions.find(i => i.first);
        },
        isCustomQuestion(question) {
            return question.type === QuestionType.CUSTOM_TEXT;
        },
        getNextQuestion(){
            const question = this.previousQuestions[this.previousQuestions.length - 1];
            let nextQuestionId = null;
            if (question.type !== QuestionType.MULTIPLE){
                nextQuestionId = question.options[0].next_question_id;
            }else{
                nextQuestionId = this.currentOption.next_question_id;
            }
            return  this.questions.find(q => q.id === nextQuestionId);
        },
        onSelectOptionMultiple(option){
            this.currentOption = option;
            this.onNextQuestion();
        },
        getPreviousQuestion(){
            const lastQuestion = this.previousQuestions[this.previousQuestions.length - 1];
            this.previousQuestions.splice(this.previousQuestions.length - 1, 1);
            return lastQuestion;
        }
    },
    computed: {
        isNotFirstQuestion () {
            return this.previousQuestions.length > 0;
        },
        isMultipleQuestion(){
            return this.currentQuestion.type === QuestionType.MULTIPLE;
        }
    }
}
</script>

<style scoped>
.container{
    width: 100% !important;
    margin: 10px;
    height: 500px;
}
.container .row{
    height: 100% !important;
}
.col-foot{
    background-color: white;
}
</style>
