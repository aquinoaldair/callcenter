<template>
    <admin-layout>
        <breadcrumb title="Usuarios"/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <create-button @onClick="create" text="Nuevo Usuario"/>
                    </div>
                    <div class="card-body">
                        <vue-good-table :line-numbers="true" :columns="columns" :rows="rows" :search-options="searchOptions" :pagination-options="paginationOptions">
                            <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'actions'">
                                        <edit-button @onClick="edit(props.row)"/>
                                        <delete-button @onClick="destroy(props.row)" />
                                    </span>
                                <span v-else-if="props.column.field == 'role'">
                                        <span  v-text="props.row.role.title" class="badge bg-info" />
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
import UserTable from "../../../Adapters/VueGoodTable/UserTable";
import DeleteButton from "../../../Components/DeleteButton";
import EditButton from "../../../Components/EditButton";
import CreateButton from "../../../Components/CreateButton";
import Breadcrumb from "../../../Components/Breadcrumb";
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import ConfirmMixin from "../../../Mixin/ConfirmMixin";
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
            searchOptions : {},
        }
    },
    created() {
        this.columns = UserTable.columns;
        this.paginationOptions = UserTable.paginationOptions;
        this.searchOptions = UserTable.searchOptions
    },
    methods: {
        create() {
            this.$inertia.get(this.route('user.create'));
        },
        edit(item){
            this.$inertia.get(this.route('user.edit', item));
        },
        async destroy(item){
            if (!await this.confirmDeletion()) return true;

            const  result = await axios.delete(this.route('user.destroy', item));

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
