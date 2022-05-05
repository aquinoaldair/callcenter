<template>
    <div>
        <form @submit.prevent="save">
            <div class="row" >
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
                    <label for="description">Pregunta</label>
                    <textarea id="description" rows="5" v-model="form.description" class="form-control" />
                </div>
            </div>

            <div class="row mt-4 pt-2 pb-2 border border-light" v-for=" (op, index) in form.options">
                <div class="col-md-8">
                    <div class="col-12">
                        <label>Opcion {{ index + 1}}</label>
                        <input type="text" required v-model="form.options[index].name" class="form-control form-control-sm" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row"><label>&nbsp;</label></div>
                    <div class="row">
                        <div class="col-6">
                            <b-button @click="deleteOption(index)" v-if="isNotFirstElement(index)" variant="danger" size="sm">
                                <i class="mdi mdi-trash-can font-size-14"/>
                            </b-button>
                        </div>
                        <div class="col-6">
                            <b-button @click="addNewOption" v-if="isLastElement(index)" variant="info" size="sm">
                                <i class="mdi mdi-plus font-size-14"/>
                            </b-button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <label class="text-muted">Ir a siguiente pregunta</label>
                    <v-select id="next" v-model="form.options[index].next_question_id"
                              :reduce="question => question.id"
                              label="question"
                              :options="questions" />
                </div>


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

export default {
    components: {StoreButton, vSelect, LoadingButton, vueDropzone: vue2Dropzone},
    props: {
        questions : { type: Array, default : [] },
        loading: { type: Boolean, default: false},
        question: { default: null }
    },
    data(){
        return {
            form: {
                first: false,
                question: null,
                type: 'Multiple',
                description: null,
                files: [],
                options: [
                    {
                        next_question_id : null,
                        name: ''
                    }
                ]
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
        addNewOption(){
            this.form.options.push( {
                next_question_id : null,
                name: ''
            });
        },
        deleteOption(index){
            this.form.options.splice(index,1);
        },
        isNotFirstElement(index){
            return index > 0;
        },
        isLastElement(index){
            return (index + 1) === this.form.options.length;
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
    }
}
</script>

<style scoped>

</style>
