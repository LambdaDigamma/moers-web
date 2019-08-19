<template>
    <div class="mt-0 mt-sm-1 mt-md-2">

        <b-card bg-variant="secondary" text-variant="black">
            <h3 class="m-0">Admin Übersicht</h3>
        </b-card>

        <b-card bg-variant="light" class="mt-3">
            <h2>Benutzer</h2>
            <router-link :to="{ name: 'admin.users' }" tag="b-button">Zeige und bearbeite alle Benutzer.</router-link>
        </b-card>

        <b-card bg-variant="light" class="mt-3">
            <h2>Organisationen</h2>
            <router-link :to="{ name: 'admin.organisations' }" tag="b-button">Zeige und bearbeite alle Organisationen.</router-link>
        </b-card>

        <b-card bg-variant="light" class="mt-3">
            <h2>Gruppen</h2>
            <router-link :to="{ name: 'admin.groups' }" tag="b-button">Zeige und bearbeite alle Gruppen.</router-link>
        </b-card>

    </div>
</template>

<script>
    export default {
        name: "AdminDashboard"
    }
</script>

<style scoped>

</style>