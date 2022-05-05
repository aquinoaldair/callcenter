
<script>
import NavBarVertical from "./NavBarVertical";
import SideBar from "./SideBar";
export default {
    components: { NavBarVertical, SideBar },
    created() {},
    methods: {
        toggleMenu() {
            document.body.classList.toggle("sidebar-enable");

            if (window.screen.width >= 992) {
                // eslint-disable-next-line no-unused-vars
                document.body.classList.toggle("vertical-collpsed");
            } else {
                // eslint-disable-next-line no-unused-vars
                document.body.classList.remove("vertical-collpsed");
            }
            this.isMenuCondensed = !this.isMenuCondensed;
        },
        toggleRightSidebar() {
            document.body.classList.toggle("right-bar-enabled");
        },
        hideRightSidebar() {
            document.body.classList.remove("right-bar-enabled");
        }
    }
}
</script>

<template>
    <div id="layout-wrapper">
        <NavBarVertical />
        <SideBar />
        <div class="main-content">
            <div class="page-content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
