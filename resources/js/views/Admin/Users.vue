<template>
    <div class="mt-4">
        <can I="read-user" a="User">
            <b-card bg-variant="secondary" text-variant="black">
                <div class="d-flex justify-content-between">
                    <h3 class="m-0">Benutzer</h3>
                    <can I="create-user" a="User">
                        <b-button variant="success">Hinzufügen</b-button>
                    </can>
                </div>
            </b-card>
            <div class="d-flex justify-content-center m-5" v-if="isLoadingUsers">
                <b-spinner label="Lädt..."></b-spinner>
            </div>
            <b-card bg-variant="light" class="mt-3" v-else>
                <b-table hover outlined :items="users" :fields="fields"></b-table>
            </b-card>
        </can>
    </div>
</template>

<script>
    import { FETCH_USERS } from "../../store/actions.type";
    import { mapGetters } from "vuex";

    export default {
        name: "Users",
        mounted() {
            this.$store.dispatch(FETCH_USERS)
        },
        computed: {
            ...mapGetters(["isAuthenticated", "isLoadingUsers", "users"])
        },
        data() {
            return {
                fields: {
                    name: {
                        label: 'Name'
                    },
                    email: {
                        label: 'Email'
                    },
                }
            }
        }
    }
</script>

<style scoped>

</style>