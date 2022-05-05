import paginationOptionsDefault from "./PaginationOptionsDefault";
import searchOptions from "./SearchOptions";
const RoleTable = {
    columns : [
        {
            label: 'Nombre',
            field: 'title'
        },
        {
            label: 'Permisos',
            field: 'permissions'
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

export default RoleTable;
