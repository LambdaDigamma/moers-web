<template>

    <div id="app">

        <NavigationBar></NavigationBar>

        <b-container>
            <router-view/>
        </b-container>

    </div>

</template>

<script>

    import NavigationBar from './components/NavigationBar'

    export default {
        name: 'App',
        components: {
            NavigationBar
        }
    }

</script>