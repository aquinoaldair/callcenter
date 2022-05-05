<template>
    <div class="vertical-menu">
        <simplebar  class="h-100">
            <SideNav />
        </simplebar>
    </div>
    <!-- Left Sidebar End -->
</template>

<script>
import simplebar from "simplebar-vue";
import SideNav from "./SideNav";
export default {
    components: { simplebar, SideNav },
    data() {
        return {
            settings: {
                minScrollbarLength: 60,
            },
        };
    },
}
</script>

<style scoped>
    .vertical-menu{
        top: 50px !important;
    }
</style>
