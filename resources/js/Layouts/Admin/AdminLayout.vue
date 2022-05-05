<template>
    <div>
        <Vertical>
            <slot />
        </Vertical>
    </div>
</template>

<script>
import Vertical from "./Vertical";
    export default {
        name: "AdminLayout",
        components: { Vertical },
        mounted() {
            if(this.$page.props.flash.message.success){
                this.showAlertMessage('success', this.$page.props.flash.message.success);
            }
            if(this.$page.props.flash.message.warning){
                this.showAlertMessage('warnig', this.$page.props.flash.message.warning);
            }
        },
        methods: {
            showAlertMessage(icon, title) {
                this.$swal({
                    position: 'top-end',
                    icon: icon,
                    title: title,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
        }
    }
</script>
