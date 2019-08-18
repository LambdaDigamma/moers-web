<template>
    <div class="mt-4">
        <can I="read-user" a="User">
            <b-card bg-variant="secondary" text-variant="black">
                <div class="d-flex justify-content-between">
                    <h3 class="m-0">Benutzer</h3>
                </div>
            </b-card>
            <b-card class="mt-5" v-if="user">

                <b-form>
                    <b-form-group
                            id="input-group-name"
                            label="Name:"
                            label-for="name">
                        <b-form-input
                                id="name"
                                required
                                v-model="user.name"
                                placeholder="Namen eingeben"></b-form-input>
                    </b-form-group>
                    <b-form-group
                            id="input-group-bio"
                            label="Bio:"
                            label-for="bio">
                        <b-form-input
                                id="bio"
                                required
                                v-model="user.description"
                                placeholder="Bio eingeben"></b-form-input>
                    </b-form-group>

                    <div class="d-flex justify-content-end">
                        <b-button type="submit" variant="primary">Speichern</b-button>
                    </div>
                </b-form>

                <div class="mt-3">

                    <h4>Gruppen</h4>
                    <b-card class="mt-2" v-for="group in user.groups" :key="group.id">
                        <b-row>
                            <b-col sm="12" md="8">
                                <h4>{{ group.name }}</h4>
                                <p>{{ group.description }}</p>
                            </b-col>
                            <b-col class="d-flex justify-content-end align-items-end" sm="12" md="4">
                                <b-button to="#" variant="danger">Benutzer entfernen</b-button>
                            </b-col>
                        </b-row>
                    </b-card>

                    <div class="mt-3">
                        <div cols="12">
                            Benutzer zu einer Gruppe hinzufügen:
                        </div>

                        <b-row class="mt-1">
                            <b-col class="mt-1 mt-md-0" cols="12" md="10">
                                <b-form-select v-if="groups" v-model="selected" :options="options">

                                </b-form-select>
                            </b-col>
                            <b-col class="mt-1 mt-md-0" cols="12" md="2">
                                <b-button block @click="addUserGroup" :disabled="!selected">Hinzufügen</b-button>
                            </b-col>
                        </b-row>
                    </div>

                </div>

            </b-card>

        </can>
    </div>
</template>

<script>
    import store from "../../store"
    import { ADMIN_FETCH_GROUPS, FETCH_USER } from "../../store/actions.type";
    import { mapGetters } from "vuex";

    export default {
        name: "User",
        props: {
            id: {
                type: Number,
                required: true
            }
        },
        computed: {
            ...mapGetters(['user', 'groups']),
            options: function() {
                return [
                    { text: 'Gruppe auswählen', value: null, disabled: true }
                ].concat(this.groups.map(group => {
                    return {
                        text: group.name,
                        value: group.id,
                        disabled: this.user.groups.map(userGroup => userGroup.id).includes(group.id)
                    }
                }))
            }
        },
        data() {
            return {
                selected: null
            }
        },
        methods: {
            addUserGroup() {
                this.selected = null
            }
        },
        beforeRouteEnter(to, from, next) {
            Promise.all([
                store.dispatch(FETCH_USER, to.params.id),
                store.dispatch(ADMIN_FETCH_GROUPS)
            ]).then(() => {
                next();
            });
        }
    }
</script>

<style scoped>

</style>