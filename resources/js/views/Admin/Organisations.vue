<template>
    <div class="mt-0 mt-sm-1 mt-md-2">
        <can I="read-organisation" a="Organisation">
            <b-card bg-variant="secondary" text-variant="black">
                <div class="d-flex justify-content-between">
                    <h3 class="m-0">Organisationen</h3>
                    <can I="create-organisation" a="Organisation">
                        <b-button variant="success">Hinzufügen</b-button>
                    </can>
                </div>
            </b-card>
        </can>
    </div>
</template>

<script>
    export default {
        name: "Organisations"
    }
</script>

<style scoped>

</style>