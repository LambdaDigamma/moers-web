<template>
    <div class="mt-4">

        <b-card bg-variant="secondary" text-variant="black">
            <h3 class="m-0">Users</h3>
        </b-card>

        <b-card bg-variant="light" class="mt-3">
            <b-table striped hover :items="items"></b-table>
        </b-card>

    </div>
</template>

<script>
    export default {
        name: "Users",
        data() {
            return {
                items: [
                    { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
                    { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
                    { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' }
                ]
            }
        }
    }
</script>

<style scoped>

</style>