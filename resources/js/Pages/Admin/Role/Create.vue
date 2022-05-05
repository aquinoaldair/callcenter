<template>
    <admin-layout>
        <breadcrumb title="Crear Rol de Usuario" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="save">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Nombre</label>
                                    <input id="name" required v-model="form.title" type="text" class="form-control"  />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label for="name">Seleccionar Permisos</label>
                            </div>
                            <div class="row mb-5 p-3">
                                <div v-for="item in permissions" class="form-check form-check-primary mb-2 col-md-3" >
                                    <input v-model="item.selected"  type="checkbox" class="form-check-input">
                                    <label  class="form-check-label" v-text="item.title"></label>
                                </div>
                            </div>
                            <store-button/>
                            <redirect-button :url="route('role.index')"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import Breadcrumb from "../../../Components/Breadcrumb";
import StoreButton from "../../../Components/StoreButton";
import RedirectButton from "../../../Components/RedirectButton";
export default {
    components: {RedirectButton, StoreButton, Breadcrumb, AdminLayout},
    props: { errors : { type: Object }, permissions: { type: Array } },
    data(){
        return{
            form: {
                title: null,
                permissions: []
            }
        }
    },
    methods: {
        save(){
            this.form.permissions = this.getPermissionsSelected();
            this.$inertia.post(this.route('role.store'), this.form);
        },
        getPermissionsSelected(){
            return this.permissions.reduce( (array, value) => {
                if (value.hasOwnProperty('selected') && value.selected) array.push(value.id);
                return array;
            }, []);
        }
    }
}
</script>

<style scoped>

</style>
