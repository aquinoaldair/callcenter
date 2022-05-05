<template>
    <admin-layout>
        <breadcrumb title="Scripts"/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <create-button @onClick="create" text="Nuevo Script"/>
                    </div>
                    <div class="card-body">
                        <vue-good-table :line-numbers="true" :columns="columns" :rows="rows" :search-options="searchOptions" :pagination-options="paginationOptions">
                            <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'actions'">
                                          <b-button @click="question(props.row)" variant="info" size="sm">
                                              <i class="mdi mdi-clipboard-outline d-block font-size-14"/>
                                          </b-button>
                                        <edit-button @onClick="edit(props.row)"/>
                                        <delete-button @onClick="destroy(props.row)" />
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
import ScriptTable from "../../../Adapters/VueGoodTable/ScriptTable";
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
            searchOptions : {}
        }
    },
    created() {
        this.columns = ScriptTable.columns;
        this.paginationOptions = ScriptTable.paginationOptions;
        this.searchOptions = ScriptTable.searchOptions
    },
    methods: {
        create() {
            this.$inertia.get(this.route('script.create'));
        },
        edit(item){
            this.$inertia.get(this.route('script.edit', item));
        },
        question(item){
            this.$inertia.get(this.route('question.index', item.id));
        },
        async destroy(item){
            if (!await this.confirmDeletion()) return true;

            const  result = await axios.delete(this.route('script.destroy', item));

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
