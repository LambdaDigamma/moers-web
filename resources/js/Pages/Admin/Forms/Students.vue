<template>

    <div>

        <h1 class="font-bold text-4xl">
            Seitenlayout
        </h1>

        <div class="mt-6 grid gap-10 grid-cols-2">

            <Panel v-for="user in users" :key="user.id">
                <h2 class="font-semibold text-xl">{{ user.first_name }} {{ user.last_name }}</h2>
            </Panel>

        </div>
    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import Panel from "../../../Shared/UI/Panels/Panel";

    export default {
        name: "Students",
        components: {Panel},
        layout: LayoutAdmin,
        props: {
            users: Object,
            students: Object
        }
    }
</script>

<style scoped>

</style>