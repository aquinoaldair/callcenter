export default {
    methods: {
        async confirmDeletion(){
            const result = await this.$swal({
                title: 'Seguro de eliminarlo?',
                text: "No podras revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5CBA83',
                cancelButtonColor: '#E94343',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText : 'Cancelar',
                allowOutsideClick: false
            });

            return  result.isConfirmed;
        }
    }
}
