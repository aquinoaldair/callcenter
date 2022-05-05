<template>
    <div class="topnav">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                <div id="topnav-menu-content" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <template v-for="(item, index) of menuItems">
                            <inertia-link :href="item.route" class="nav-link dropdown-toggle arrow-none">
                                <i :class="`bx ${item.icon} mr-2`"/>{{ item.label }}
                            </inertia-link>
                        </template>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBar",
    data(){
        return{
            menuItems : [
                {
                    label   : 'Inicio',
                    icon    : 'bx-home',
                    route   :  this.route('dashboard')
                },
                {
                    label   : 'Scripts',
                    icon    : 'bx-file-blank',
                    route   :  this.route('script.index')
                },
                {
                    label   : 'Usuarios',
                    icon    : 'bx-user',
                    route   :  this.route('user.index')
                },
                {
                    label   : 'Roles',
                    icon    : 'bx-lock-alt',
                    route   :  this.route('role.index')
                }
            ]
        }
    }
}
</script>

<style scoped>

</style>
