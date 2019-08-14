<template>
    <div class="mt-4">

        <b-card bg-variant="secondary" text-variant="black">
            <h3 class="m-0">Admin Dashboard</h3>
        </b-card>

        <b-card bg-variant="light" class="mt-3">
            <h2>Users</h2>
            <router-link :to="{ name: 'admin.users' }" tag="b-button">List and edit all users.</router-link>
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