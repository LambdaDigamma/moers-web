<template>

    <div class="auth-page">
        <b-row align-h="center" class="mt-5">
            <b-col sm="12" md="8">
                <b-card header="Sign in" header-bg-variant="dark" header-text-variant="white">
                    <b-form @submit.prevent="onSubmit()" @keydown="form.errors.clear($event.target.name)">
                        <b-form-group
                                id="input-group-email"
                                label-for="input-email">
                            <b-form-input
                                    id="input-email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    placeholder="Email">

                            </b-form-input>
                            <b-form-invalid-feedback :force-show="form.errors.has('email')" v-text="form.errors.get('email')">

                            </b-form-invalid-feedback>
                        </b-form-group>
                        <b-form-group
                                id="input-group-password"
                                label-for="input-password">
                            <b-form-input
                                    id="input-password"
                                    v-model="form.password"
                                    type="password"
                                    required
                                    placeholder="Password">

                            </b-form-input>
                            <b-form-invalid-feedback :force-show="form.errors.has('password')" v-text="form.errors.get('password')">

                            </b-form-invalid-feedback>
                        </b-form-group>
                        <b-alert class="mt-2 mb-4" :show="form.errors.has('common')" variant="danger" v-text="form.errors.get('common')">

                        </b-alert>
                        <div>
                            <b-button block type="submit" variant="success" :disabled="form.errors.any()">Anmelden</b-button>
                        </div>
                        <div class="mt-2">
                            <b-link :to="{ name: 'register' }">Benötigen Sie ein Account?</b-link>
                        </div>

<!--                        <b-form-invalid-feedback tag="p" style="font-size: 100%;" :force-show="form.errors.has('common')" v-text="form.errors.get('common')">-->

<!--                        </b-form-invalid-feedback>-->
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </div>

</template>

<script>

    import { LOGIN } from "../store/actions.type";
    import Form from "../core/Form";

    export default {
        name: "Login",
        data() {
            return {
                form: new Form({
                    email: null,
                    password: null
                })
            }
        },
        computed: {

        },
        methods: {
            onSubmit() {

                const payload = this.form.data()

                const login = this.$store.dispatch(LOGIN, payload)

                login.then(() => {
                    this.makeToast('success');
                    this.$router.push({ name: "home" });
                })

                this.form.submit(login)

            },
            makeToast(variant = null) {
                this.$bvToast.toast('Ihre Anmeldung war erfolgreich. Viel Spaß!', {
                    title: `Anmeldung erfolgreich!`,
                    variant: variant,
                    solid: true
                })
            }
        },
    }

</script>

<style scoped>

</style>