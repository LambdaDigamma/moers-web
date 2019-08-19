<template>
    <div class="mt-0 mt-sm-1 mt-md-2">
        <can I="read-group" a="Group">
            <b-card bg-variant="secondary" text-variant="black">
                <div class="d-flex justify-content-between">
                    <h3 class="m-0">Gruppen</h3>
                    <can I="create-group" a="Group">
                        <b-button variant="success">Hinzufügen</b-button>
                    </can>
                </div>
            </b-card>
            <b-card bg-variant="light" class="mt-3" v-if="groups">
                <b-table hover outlined :items="groups" :fields="fields" @row-clicked="showDetail"></b-table>
            </b-card>
        </can>
    </div>
</template>

<script>
    import { ADMIN_FETCH_GROUPS } from "../../store/actions.type";
    import { mapGetters } from "vuex";

    export default {
        name: "Groups",
        mounted() {
            this.$store.dispatch(ADMIN_FETCH_GROUPS)
        },
        computed: {
            ...mapGetters(["isAuthenticated", "groups"])
        },
        methods: {
            showDetail(item) {
                this.$router.push({ name: 'admin.group', params: { id: item.id } })
            }
        },
        data() {
            return {
                fields: {
                    name: {
                        label: 'Name'
                    },
                }
            }
        }
    }
</script>

<style scoped>

</style>