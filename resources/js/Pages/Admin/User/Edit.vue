<template>
    <admin-layout>
        <breadcrumb title="Editar Usuario"/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="save" autocomplete="off">
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="row p-3">
                                      <div class="col-12 mt-2">
                                          <label for="name">Nombre</label>
                                          <input id="name" required v-model="form.name" type="text" class="form-control"  />
                                          <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                      </div>
                                      <div class="col-12 mt-2">
                                          <label for="email">Email</label>
                                          <input id="email" required v-model="form.email" type="email" class="form-control"  />
                                          <p v-if="errors.email" class="text-danger">{{ errors.email }}</p>
                                      </div>
                                      <div class="col-12 mt-2">
                                          <label for="password">Contraseña</label>
                                          <input id="password"  v-model="form.password" type="password" class="form-control"  />
                                          <p v-if="errors.password" class="text-danger">{{ errors.password }}</p>
                                      </div>
                                      <div class="col-12 mt-2">
                                          <label for="password_confirmation">Confirmar contraseña</label>
                                          <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="form-control"  />
                                      </div>
                                      <div class="col-12 mt-2">
                                          <label for="name">Rol</label>
                                          <v-select  v-model="role" @input="eventSelectedRole" label="title" :options="roles" />
                                          <p v-if="errors.role" class="text-danger">{{ errors.role }}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-8">
                                  <h4 class="text-muted">Permisos del Rol</h4>
                                  <div class="row mb-5 p-3">
                                      <div v-for="item in permissions" class="form-check form-check-primary mb-2 col-md-3" >
                                          <input v-model="item.selected"  type="checkbox" class="form-check-input">
                                          <label  class="form-check-label" v-text="item.title"></label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                            <div class="mt-5">
                                <store-button/>
                                <redirect-button :url="route('user.index')"/>
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
        roles : { type: Array },
        user: { type: Object }
    },
    data(){
        return{
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
                role_id : null
            },
            role : null,
            permissions: []
        }
    },
    created() {
        this.form = this.user;
        this.form.role = this.user.role.id;
        this.role = this.roles.find(i => i.id === this.user.role_id);
        this.setPermissions(this.role.permissions);
    },
    methods: {
        setPermissions(permissions_role){
            this.permissions = permissions_role.map(item => {
                item.selected = !!this.user.permissions.find(permission => permission.id === item.id);
                return item;
            })
        },
        eventSelectedRole(value){
            this.setPermissions(value.permissions)
            this.form.role_id = (value == null) ? null : value.id;
        },
        save() {
            this.form.permissions = this.getPermissionsSelected();
            this.form._method = 'PUT';
            this.$inertia.post(this.route('user.update', this.user.id), this.form);
        },
        getPermissionsSelected(){
            return this.permissions.reduce( (array, value) => {
                if (value.hasOwnProperty('selected') && value.selected) array.push(value.name);
                return array;
            }, []);
        }
    }
}
</script>

<style scoped>

</style>
