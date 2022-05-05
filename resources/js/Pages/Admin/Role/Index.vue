<template>
    <admin-layout>
        <breadcrumb title="Roles de Usuario" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <create-button @onClick="create" text="Nuevo Role"/>
                    </div>
                    <div class="card-body">
                        <vue-good-table :line-numbers="true" :columns="columns" :rows="rows" :search-options="searchOptions" :pagination-options="paginationOptions">
                            <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'actions'">
                                        <edit-button @onClick="edit(props.row)"/>
                                        <delete-button @onClick="destroy(props.row)" />
                                    </span>
                                    <span v-else-if="props.column.field == 'permissions'">
                                        <span v-for="p in props.row.permissions" v-text="p.title" class="badge bg-info ms-1" />
                                    </span>
                                    <span v-else>
                                        {{props.formattedRow[props.column.field]}}
                                    </span>
                            </template>
                        </vue-good-table>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import Breadcrumb from "../../../Components/Breadcrumb";
import CreateButton from "../../../Components/CreateButton";
import ConfirmMixin from "../../../Mixin/ConfirmMixin";
import RoleTable from "../../../Adapters/VueGoodTable/RoleTable";
import EditButton from "../../../Components/EditButton";
import DeleteButton from "../../../Components/DeleteButton";

export default {
    components: {DeleteButton, EditButton, CreateButton, Breadcrumb, AdminLayout},
    mixins: [ConfirmMixin],
    props: {
        data : Array
    },
    data(){
      return {
          columns: [],
          rows: this.data,
          paginationOptions: {},
          searchOptions : {}
      }
    },
    created() {
        this.columns = RoleTable.columns;
        this.paginationOptions = RoleTable.paginationOptions;
        this.searchOptions = RoleTable.searchOptions
    },
    methods: {
        create() {
            this.$inertia.get(this.route('role.create'));
        },
        edit(item){
            this.$inertia.get(this.route('role.edit', item));
        },
        async destroy(item){
            if (!await this.confirmDeletion()) return true;

            const  result = await axios.delete(this.route('role.destroy', item));

            if (!!result.data.success){
                this.$swal('Eliminado', result.data.message, 'success');
                this.rows.splice(item.originalIndex, 1);
            }
        },
    }
}
</script>

<style scoped>

</style>
