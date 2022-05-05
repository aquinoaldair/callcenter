<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/images/logo.svg" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="/images/logo-dark.png" alt height="17" />
                        </span>
                    </a>
                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/images/logo-light.svg" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="/images/logo-light.png" alt height="19" />
                        </span>
                    </a>
                </div>
                <button id="toggle" type="button" class="btn btn-sm me-2 font-size-16 d-lg-none header-item" @click="toggleMenu">
                    <i class="fa fa-fw fa-bars"/>
                </button>

            </div>

            <div class="d-flex">
                <b-dropdown class="d-inline-block d-lg-none ml-2" variant="black" menu-class="dropdown-menu-lg p-0 dropdown-menu-end" toggle-class="header-item noti-icon" right>
                    <template v-slot:button-content>
                        <i class="mdi mdi-magnify"/>
                    </template>

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username"/>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-magnify"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </b-dropdown>

                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon" @click="initFullScreen">
                        <i class="bx bx-fullscreen"/>
                    </button>
                </div>
                <b-dropdown right  variant="black"  toggle-class="header-item"  menu-class="dropdown-menu-end">
                    <template v-slot:button-content>
                        <img class="rounded-circle header-profile-user" src="/images/users/avatar-9.png" alt="Header Avatar"/>
                        <span class="d-none d-xl-inline-block ml-1" v-text="user"></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"/>
                    </template>
                    <!-- item-->
                    <b-dropdown-divider/>
                    <a @click="logout" class="dropdown-item text-danger" style="cursor: pointer">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"/>
                        Salir
                    </a>
                </b-dropdown>
            </div>
        </div>
    </header>
</template>

<script>
    export default {
        name: "TopBar",
        computed: {
            user() {
                return this.$page.props.auth.user !== null ? this.$page.props.auth.user.name : null
            }
        },
        methods:{
            logout(){
                this.$inertia.post(this.route('logout'));
            },
            toggleMenu() {
                let element = document.getElementById("topnav-menu-content");
                element.classList.toggle("show");
            },
            initFullScreen() {
                document.body.classList.toggle("fullscreen-enable");
                if (
                    !document.fullscreenElement &&
                    /* alternative standard method */ !document.mozFullScreenElement &&
                    !document.webkitFullscreenElement
                ) {
                    // current working methods
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen(
                            Element.ALLOW_KEYBOARD_INPUT
                        );
                    }
                } else {
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
