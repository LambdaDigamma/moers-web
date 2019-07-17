<template>

    <div class="auth-page">
        <b-row align-h="center" class="mt-5">
            <b-col cols="8">
                <b-card header="Sign in" header-bg-variant="dark" header-text-variant="white">
                    <b-form v-on:submit.prevent="onSubmit(email, password)">
                        <b-form-group
                                id="input-group-email"
                                label-for="input-email">
                            <b-form-input
                                    id="input-email"
                                    v-model="email"
                                    type="email"
                                    required
                                    placeholder="Email">

                            </b-form-input>
                        </b-form-group>
                        <b-form-group
                                id="input-group-password"
                                label-for="input-password">
                            <b-form-input
                                    id="input-password"
                                    v-model="password"
                                    type="password"
                                    required
                                    placeholder="Password">

                            </b-form-input>
                        </b-form-group>
                        <b-button type="submit" variant="success">Anmelden</b-button>
                    </b-form>
                    <ul v-if="errors" class="error-messages">
                        <li v-for="(v, k) in errors" :key="k">{{ k }} {{ v | error }}</li>
                    </ul>
                    <p class="text-left">
                        <router-link :to="{ name: 'register' }">
                            Benötigen Sie ein Account?
                        </router-link>
                    </p>
                </b-card>
            </b-col>
        </b-row>
    </div>

</template>

<script>

    import { mapState } from "vuex";
    import { LOGIN } from "../store/actions.type";

    export default {
        name: "Login",
        data () {
            return {
                email: null,
                password: null
            }
        },
        computed: {
            ...mapState({
                errors: state => state.auth.errors
            })
        },
        methods: {
            onSubmit(email, password) {
                this.$store
                    .dispatch(LOGIN, { email, password })
                    .then(() => {
                        this.makeToast('success');
                        this.$router.push({ name: "home" });
                    })
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