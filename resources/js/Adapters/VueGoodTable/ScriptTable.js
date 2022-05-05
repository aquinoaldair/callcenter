import paginationOptionsDefault from "./PaginationOptionsDefault";
import searchOptions from "./SearchOptions";
const ScriptTable = {
    columns : [
        {
            label: 'Nombre',
            field: 'name'
        },
        {
            label: 'Acciones',
            field: 'actions',
            sortable: false,
        }
    ],
    paginationOptions : paginationOptionsDefault,
    searchOptions : searchOptions
}

export default ScriptTable;
