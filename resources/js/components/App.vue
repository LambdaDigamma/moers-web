<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Mein Moers</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <router-link :to="{ name: 'landingpage' }" class="nav-link">Home</router-link>
                    <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                </ul>
            </div>
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Register</router-link>
                <li class="nav-link" v-if="isLoggedIn"> Hi, {{ name }}</li>
                <router-link :to="{ name: 'home' }" class="nav-link" v-if="isLoggedIn">Board</router-link>
            </ul>

        </nav>
        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
    import axios from 'axios'
    export default {
        data(){
            return {
                isLoggedIn : null,
                name : null
            }
        },
        mounted(){
            this.isLoggedIn = localStorage.getItem('jwt');
            this.name = localStorage.getItem('user');
        }
    }
</script>