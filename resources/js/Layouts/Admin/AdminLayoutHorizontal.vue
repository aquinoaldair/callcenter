<template>
    <div id="layout-wrapper">
        <top-bar/>
        <nav-bar/>
       <!-- <NavBar />
        <SideBar :is-condensed="isMenuCondensed" />-->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="main-content">
            <div class="page-content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <slot />
                </div>
            </div>
            <custom-footer/>
        </div>
    </div>
</template>

<script>
    import TopBar from "./TopBar";
    import NavBar from "./NavBar";
    import CustomFooter from "./CustomFooter";
    export default {
        name: "AdminLayout",
        components: { CustomFooter,  NavBar,  TopBar},
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

<style scoped>

</style>
