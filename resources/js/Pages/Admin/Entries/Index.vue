<template>

    <div>

        <Header title="Einträge">

        </Header>

        {{ entries.data }}
    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import Header from "../../../Shared/UI/Header";

    export default {
        name: "Index",
        components: {Header},
        layout: LayoutAdmin,
        props: {
            entries: Object
        }
    }
</script>

<style scoped>

</style>