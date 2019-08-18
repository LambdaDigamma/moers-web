<template>
    <div class="mt-0 mt-sm-1 mt-md-2">
        <can I="read-user" a="User">
            <b-card bg-variant="secondary" text-variant="black">
                <div class="d-flex justify-content-between">
                    <h3 class="m-0">Benutzer</h3>
                </div>
            </b-card>
            <b-card class="mt-5" v-if="user">

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
                            id="input-group-bio"
                            label="Bio:"
                            label-for="bio">
                        <b-form-input
                                id="bio"
                                required
                                v-model="form.description"
                                placeholder="Bio eingeben"></b-form-input>
                        <b-form-invalid-feedback :force-show="form.errors.has('description')" v-text="form.errors.get('description')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                            id="input-group-email"
                            label="Email:"
                            label-for="email">
                        <b-form-input
                                id="email"
                                required
                                v-model="form.email"
                                placeholder="Email eingeben"></b-form-input>
                        <b-form-invalid-feedback :force-show="form.errors.has('email')" v-text="form.errors.get('email')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-alert class="mt-2 mb-4" :show="form.errors.has('common')" variant="danger" v-text="form.errors.get('common')">
                    </b-alert>

                    <div class="d-flex justify-content-end">
                        <b-button @click.prevent="updateUser" :disabled="!changed || form.errors.any()" type="submit" variant="primary">Speichern</b-button>
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
                                <b-button @click.prevent="removeUserGroup(group.id)" variant="danger">Benutzer entfernen</b-button>
                            </b-col>
                        </b-row>
                    </b-card>

                    <div class="mt-3">
                        <div cols="12">
                            Benutzer zu einer Gruppe hinzufügen:
                        </div>

                        <b-row class="mt-1">
                            <b-col class="mt-1 mt-md-0" cols="12" md="10">
                                <b-form-select v-if="groups" v-model="selectedGroup" :options="options">

                                </b-form-select>
                            </b-col>
                            <b-col class="mt-1 mt-md-0" cols="12" md="2">
                                <b-button block @click.prevent="addUserGroup" :disabled="!selectedGroup">Hinzufügen</b-button>
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
    import {
        ADMIN_FETCH_GROUPS,
        ADMIN_JOIN_GROUP,
        ADMIN_LEAVE_GROUP,
        ADMIN_UPDATE_USER,
        FETCH_USER
    } from "../../store/actions.type";
    import { mapGetters } from "vuex";
    import Form from "../../core/Form";
    import { ADMIN_SET_USER } from "../../store/mutations.type";

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
            options() {
                return [
                    { text: 'Gruppe auswählen', value: null, disabled: true }
                ].concat(this.groups.map(group => {
                    return {
                        text: group.name,
                        value: group.id,
                        disabled: this.user.groups.map(userGroup => userGroup.id).includes(group.id)
                    }
                }))
            },
        },
        data() {
            return {
                selectedGroup: null,
                form: new Form({}),
                changed: false
            }
        },
        methods: {
            formChanged(event) {
                this.changed = true
                this.form.errors.clear(event.target.name)
            },
            addUserGroup() {
                store.dispatch(ADMIN_JOIN_GROUP, { user_id: this.id, group_id: this.selectedGroup })
                this.selectedGroup = null
            },
            removeUserGroup(group_id) {
                store.dispatch(ADMIN_LEAVE_GROUP, { user_id: this.id, group_id: group_id })
            },
            updateUser() {

                const payload = this.form.data()
                payload.user_id = this.id

                const updateRequest = this.$store.dispatch(ADMIN_UPDATE_USER, payload)

                updateRequest.then(data => {
                    this.form.update(data)
                })

                this.form.submit(updateRequest)

            }
        },
        mounted() {
            store.dispatch(FETCH_USER, this.id)
            store.dispatch(ADMIN_FETCH_GROUPS)
            store.subscribe((mutation) => {
                if (mutation.type === ADMIN_SET_USER) {
                    this.changed = false
                    this.form.update(mutation.payload)
                }
            })
        }
    }
</script>

<style scoped>

</style>