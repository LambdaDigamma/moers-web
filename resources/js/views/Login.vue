<template>
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 2.5em">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header bg-dark text-white">Login</div>

                    <div class="card-body bg-light">
                        <form @submit.prevent="handleSubmit">

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" v-model="email" name="email" class="form-control" :class="{ 'is-invalid': submitted && !email }" required autofocus />
                                </div>
                                <div v-show="submitted && !email" class="invalid-feedback">Email is required</div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                                <div v-show="submitted && !password" class="invalid-feedback">Password is required</div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        Login
                                    </button>
                                    <img v-show="loggingIn" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data () {
            return {
                email: '',
                password: '',
                submitted: false
            }
        },
        computed: {
            loggingIn() {
                return this.$store.state.authentication.status.loggingIn;
            }
        },
        created() {
            this.$store.dispatch('authentication/logout');
        },
        methods: {
            handleSubmit(e) {
                console.log("Test")
                this.submitted = true;
                const { email, password } = this;
                const { dispatch } = this.$store;
                if (email && password) {
                    dispatch('authentication/login', { email, password });
                }
            }
        },
        beforeRouteEnter (to, from, next) {
            if (localStorage.getItem('user.token')) {
                return next('/');
            }
            next();
        }
    }
</script>

<style scoped>

</style>