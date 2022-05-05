import paginationOptionsDefault from "./PaginationOptionsDefault";
import searchOptions from "./SearchOptions";
const UserTable = {
    columns : [
        {
            label: 'Nombre',
            field: 'name'
        },
        {
            label: 'Email',
            field: 'email'
        },
        {
            label: 'Rol',
            field: 'role'
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

export default UserTable;
