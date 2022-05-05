<template>
    <admin-layout>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Welcome to  Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from "../../../Layouts/Admin/AdminLayout";

    export default {
        name: "Index",
        components: {AdminLayout}
    }
</script>

<style scoped>

</style>
