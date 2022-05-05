<template>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft bg-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Bienvenido de nuevo!</h5>
                                        <p>Iniciar sesión para continuar</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="/images/profile-img.png" alt class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="/">
                                    <div class="avatar-md profile-user-wid mb-4">
								<span class="avatar-title rounded-circle bg-light">
									<img src="/images/logo.svg" alt height="34" />
								</span>
                                    </div>
                                </a>
                            </div>
                            <b-alert :show="'email' in errors" dismissible variant="danger" class="mt-3" @dismissed="delete errors.email"> {{ errors.email }} </b-alert>
                            <b-form class="p-2" @submit.prevent="submit">
                                <b-form-group id="input-group-1" label="Email" label-for="input-1" class="mb-3" >
                                    <b-form-input required id="input-1" v-model="form.email" type="text" placeholder="Correo electrónico"/>
                                </b-form-group>
                                <b-form-group id="input-group-2" label="Password" label-for="input-2" class="mb-3" >
                                    <b-form-input required id="input-2" v-model="form.password"  type="password" placeholder="Contraseña"/>
                                </b-form-group>
                                <b-form-checkbox class="form-check" v-model="form.remember">Recordar</b-form-checkbox>
                                <div class="mt-3 d-grid text-center">
                                    <b-button v-if="!logging" type="submit" variant="primary" class="btn-block" >Iniciar sesión</b-button >
                                    <span v-if="logging" aria-hidden="true" class="m-2 spinner-border text-success"><!----></span>
                                </div>
                                <!--<div class="mt-4 text-center">
                                    <h5 class="font-size-14 mb-3">Iniciar sesión con:</h5>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item bg-primary text-white border-primary" >
                                                <i class="mdi mdi-facebook"/>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item bg-info text-white border-info" >
                                                <i class="mdi mdi-twitter"/>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item bg-danger text-white border-danger" >
                                                <i class="mdi mdi-google"/>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div  class="mt-4 text-center">
                                    <a :href="route('password.request')" class="text-muted">
                                        <i class="mdi mdi-lock mr-1"/> Olvidaste tu contraseña?
                                    </a>
                                </div>-->
                            </b-form>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                   <!-- <div class="mt-5 text-center" v-if="canRegister">
                        <p> No tienes una cuenta?
                            <a :href="route('register')" class="fw-medium text-primary">Registrarse</a>
                        </p>
                        <p> © {{ new Date().getFullYear() }} Aldair. Crafted with
                            <i class="mdi mdi-heart text-danger"/> by AquinoAldair
                        </p>
                    </div>-->
                    <!-- end row -->
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            errors: Object,
            canRegister: Boolean
        },
        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                }),
                logging : false
            }
        },
        methods: {
            submit() {
                this.logging = true;
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => {
                            this.form.reset('password');
                            this.logging = false;
                        } ,
                    })
            }
        }
    }
</script>

<style scoped>

</style>
