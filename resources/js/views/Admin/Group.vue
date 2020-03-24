<template>
    <div class="mt-0 mt-sm-1 mt-md-2">
        <can I="read-group" a="Group">
            <b-card bg-variant="secondary" text-variant="black">
                <div class="d-flex justify-content-between">
                    <h3 class="m-0">Gruppe</h3>
                </div>
            </b-card>
            <b-card class="mt-5" v-if="group !== {}">
                <h4>Allgemeine Informationen</h4>
                <b-form @keydown="formChanged">
                    <b-form-group
                            id="input-group-name"
                            label="Name:"
                            label-for="name">
                        <b-form-input
                                id="name"
                                required
                                v-model="form.name"
                                placeholder="Namen eingeben"></b-form-input>
                        <b-form-invalid-feedback :force-show="form.errors.has('name')" v-text="form.errors.get('name')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                            id="input-group-description"
                            label="Beschreibung:"
                            label-for="description">
                        <b-form-textarea
                                id="description"
                                v-model="form.description"
                                rows="3"
                                placeholder="Beschreibung eingeben"></b-form-textarea>
                        <b-form-invalid-feedback :force-show="form.errors.has('description')" v-text="form.errors.get('description')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                            id="input-group-organisation"
                            label="Organisation:"
                            label-for="organisation">
                        <b-form-select
                                id="organisation"
                                v-if="organisations"
                                v-model="form.organisation_id"
                                :options="organisationOptions"
                                @input="formChanged"></b-form-select>
                        <b-form-invalid-feedback :force-show="form.errors.has('description')" v-text="form.errors.get('description')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-alert class="mt-2 mb-4" :show="form.errors.has('common')" variant="danger" v-text="form.errors.get('common')">
                    </b-alert>
                    <div class="d-flex justify-content-end">
                        <b-button @click.prevent="updateGroup" :disabled="!changed || form.errors.any()" type="submit" variant="primary">Speichern</b-button>
                    </div>
                </b-form>
                <div class="mt-3">

                    <h4>Benutzer</h4>
                    <b-card class="mt-2" v-for="user in group.users" :key="user.id">
                        <div class="d-flex flex-row justify-content-between">
                            <h4>{{ user.name }}</h4>
                            <div class="d-flex flex-row">
                                <b-button @click.prevent="allowCreatePoll(user.id)" variant="secondary" class="mr-2">Allg. Schreiben</b-button>
                                <b-button @click.prevent="disallowCreatePoll(user.id)" variant="warning" class="mr-2">Allg. Schreiben</b-button>
                                <b-button @click.prevent="allowCreatePollGroup(user.id)" variant="secondary" class="mr-2">Spez. Schreiben</b-button>
                                <b-button @click.prevent="disallowCreatePollGroup(user.id)" variant="warning" class="mr-2">Spez. Schreiben</b-button>
                                <b-button @click.prevent="removeUserGroup(user.id)" variant="danger">Benutzer entfernen</b-button>
                            </div>
                        </div>
                    </b-card>

                    <div class="mt-3">
                        <div>
                            Benutzer hinzufügen:
                        </div>

                        <b-row class="mt-1">
                            <b-col class="mt-1 mt-md-0" cols="12" md="10">
                                <b-form-select v-if="users" v-model="selectedUser" :options="userOptions">

                                </b-form-select>
                            </b-col>
                            <b-col class="mt-1 mt-md-0" cols="12" md="2">
                                <b-button block @click.prevent="addGroupUser" :disabled="!selectedUser">Hinzufügen</b-button>
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
    import {mapGetters} from "vuex";
    import Form from "../../Core/Form";
    import {
        ADMIN_ALLOW_CREATE_POLL, ADMIN_ALLOW_CREATE_POLL_GROUP, ADMIN_DISALLOW_CREATE_POLL, ADMIN_DISALLOW_CREATE_POLL_GROUP,
        ADMIN_FETCH_GROUP,
        ADMIN_JOIN_GROUP,
        ADMIN_LEAVE_GROUP, ADMIN_UPDATE_GROUP,
        FETCH_ORGANISATIONS,
        FETCH_USERS
    } from "../../store/actions.type";
    import {ADMIN_SET_GROUP} from "../../store/mutations.type";

    export default {
        name: "Group",
        props: {
            id: {
                type: Number,
                required: true
            }
        },
        computed: {
            ...mapGetters(['group', 'users', 'organisations']),
            organisationOptions() {
                return [
                    { text: 'Keine Organisation', value: null }
                ].concat(this.organisations.map(organisation => {
                    return {
                        text: organisation.name,
                        value: organisation.id
                    }
                }))
            },
            userOptions() {
                return [
                    { text: 'Benutzer auswählen', value: null, disabled: true }
                ]
                .concat(
                    this.users
                        .sort(function(a, b) {
                            if(a.name < b.name) { return -1; }
                            if(a.name > b.name) { return 1; }
                            return 0;
                        })
                        .map(user => {
                            return {
                                text: user.name,
                                value: user.id,
                                disabled: this.group.users.map(userGroup => userGroup.id).includes(user.id)
                        }
                }))
            },
        },
        methods: {
            formChanged(event) {
                this.changed = true
                if (event.target) {
                    this.form.errors.clear(event.target.name)
                }
            },
            updateGroup() {

                const payload = this.form.data()
                payload.group_id = this.id

                const updateRequest = this.$store.dispatch(ADMIN_UPDATE_GROUP, payload)

                updateRequest.then(data => {
                    this.form.update(data)
                })

                this.form.submit(updateRequest)

            },
            addGroupUser() {
                store.dispatch(ADMIN_JOIN_GROUP, { user_id: this.selectedUser, group_id: this.id })
                this.selectedUser = null
            },
            removeUserGroup(id) {
                store.dispatch(ADMIN_LEAVE_GROUP, {user_id: id, group_id: this.id})
            },
            allowCreatePoll(user_id) {
                store.dispatch(ADMIN_ALLOW_CREATE_POLL, user_id)
            },
            disallowCreatePoll(user_id) {
                store.dispatch(ADMIN_DISALLOW_CREATE_POLL, user_id)
            },
            allowCreatePollGroup(user_id) {
                store.dispatch(ADMIN_ALLOW_CREATE_POLL_GROUP, { user_id: user_id, group_id: this.id })
            },
            disallowCreatePollGroup(user_id) {
                store.dispatch(ADMIN_DISALLOW_CREATE_POLL_GROUP, { user_id: user_id, group_id: this.id })
            }
        },
        data() {
            return {
                form: new Form({}),
                changed: false,
                selectedUser: null,
            }
        },
        mounted() {
            store.dispatch(ADMIN_FETCH_GROUP, this.id)
            store.dispatch(FETCH_USERS)
            store.dispatch(FETCH_ORGANISATIONS)
            store.subscribe((mutation) => {
                if (mutation.type === ADMIN_SET_GROUP) {
                    this.changed = false
                    this.form.update(mutation.payload)
                }
            })
        }
    }
</script>

<style scoped>

</style>