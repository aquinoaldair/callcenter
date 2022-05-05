<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check form-switch form-switch-md">
                        <input type="checkbox" id="first" v-model="form.first" class="form-check-input">
                        <label for="first" class="form-check-label">¿Es la pregunta inicial ?</label>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <label for="name">Titulo</label>
                    <input type="text" id="name" required v-model="form.question" class="form-control" />
                </div>
                <div class="col-md-12 mt-4">
                    <label>Pregunta</label>
                    <vue-editor v-model="form.description"></vue-editor>
                </div>
                <div class="col-md-12 mt-4" v-show="questions.length">
                    <label for="next">Ir a siguiente Pregunta</label>
                    <v-select id="next" v-model="form.options[0].next_question_id" :reduce="question => question.id" label="question" :options="questions" />
                </div>
                <div class="col-md-12 mt-4">
                    <label for="next">Archivos</label>
                    <vue-dropzone @vdropzone-success="uploadedDropZone"
                                  ref="myVueDropzone" id="dropzone"
                                  @vdropzone-sending="sendingDropZone"
                                  @vdropzone-removed-file="removedDropZone"
                                  :options="dropzoneOptions"></vue-dropzone>
                </div>
                <div class="col-md-12 mt-2" v-if="question != null">
                    <div class="d-flex flex-row">
                        <div class="p-2 border-left border-light" v-for="(file, index) in form.files">
                            <div v-if="file.hasOwnProperty('id')">
                                <ul class="list-inline mb-0 font-size-16">
                                    <li class="list-inline-item">
                                        <a :href="file.fullPath" target="_blank" class="text-primary p-1">
                                            <i class="bx bx-file-blank"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a @click="removeFile(index)" class="text-danger p-1">
                                            <i class="bx bxs-trash"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <store-button v-if="!loading" />
                    <loading-button v-if="loading" />
                    <slot/>
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
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import { VueEditor } from "vue2-editor";

export default {
    components: {VueEditor, StoreButton, vSelect, LoadingButton, vueDropzone: vue2Dropzone},
    props: {
        questions : { type: Array, default : [] },
        loading: { type: Boolean, default: false},
        question: { default: null }
    },
    data(){
        return {
            files : [],
            form: {
                first: false,
                question: null,
                type: 'Texto Personalizado',
                description: null,
                files: [],
                options: [{
                    next_question_id : null,
                    name: ''
                }],
            },
            dropzoneOptions: {
                url: this.route('file.store'),
                addRemoveLinks: true,
                dictRemoveFile: "Eliminar",
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
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
        },
        sendingDropZone(file, xhr, formData) {
            formData.append('uuid',  file.upload.uuid);
        },
        uploadedDropZone(file, response){
            this.form.files.push(response);
        },
        removeFile(index){
            this.form.files.splice(index, 1);
        },
        removedDropZone(file){
            //solo ejecuta cuando el usuario da click en remover y no cuando se desmonte el componente
            if (this.$refs.myVueDropzone.dropzone.disabled !== true){
                const uuid = file.upload.uuid;
                const index = this.form.files.findIndex(i => i.uuid === uuid);
                axios.post(this.route('file.delete'), { path: this.form.files[index].path });
                this.form.files.splice(index, 1);
            }
        }
    },

}
</script>

<style scoped>

</style>
