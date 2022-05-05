<template>
    <admin-layout>
        <breadcrumb title="Crear Script"/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="save">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Nombre</label>
                                    <input id="name" required v-model="form.name" type="text" class="form-control"  />
                                    <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                </div>
                            </div>
                            <div class="mt-5">
                                <store-button/>
                                <redirect-button :url="route('script.index')"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Breadcrumb from "../../../Components/Breadcrumb";
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import StoreButton from "../../../Components/StoreButton";
import RedirectButton from "../../../Components/RedirectButton";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
export default {
    components: {RedirectButton, StoreButton, Breadcrumb, AdminLayout, vSelect},
    props: {
        errors : { type: Object },
        script : { type: Object },
    },
    data(){
        return{
            form: {
                name: null,
            }
        }
    },
    created() {
        this.form = this.script;
    },
    methods: {
        save() {
            this.form._method = 'PUT';
            this.$inertia.post(this.route('script.update', this.script), this.form);
        },
    }
}
</script>

<style scoped>

</style>
