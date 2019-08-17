<template>

    <div>
        <can I="create-poll" a="Poll">
            <b-card bg-variant="secondary" text-variant="black" class="my-4">
                <div class="d-flex justify-content-between">
                    <h3 class="m-0">Abstimmung erstellen</h3>
                </div>
            </b-card>
            <b-card class="mt-3">
                <b-form @submit.prevent="submit()" @keydown="form.errors.clear($event.target.name)">
                    <b-form-group
                            id="question-group"
                            label="Frage:"
                            label-for="question">
                        <b-form-input
                                id="question"
                                required
                                placeholder="Gib die Frage der Abstimmung ein."
                                v-model="form.question">
                        </b-form-input>
                        <b-form-invalid-feedback :force-show="form.errors.has('question')" v-text="form.errors.get('question')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                            id="description-group"
                            label="Beschreibung:"
                            label-for="description">
                        <b-form-textarea
                                id="description"
                                rows="3"
                                placeholder="Füge eine Beschreibung für die Abstimmung hinzu."
                                v-model="form.description">
                        </b-form-textarea>
                        <b-form-invalid-feedback :force-show="form.errors.has('description')" v-text="form.errors.get('description')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                            id="group-group"
                            label="Gruppe für die Abstimmung:"
                            label-for="group">
                        <b-form-select
                                id="group"
                                :options="groupOptions"
                                v-model="form.group_id">
                        </b-form-select>
                        <b-form-invalid-feedback :force-show="form.errors.has('group_id')" v-text="form.errors.get('group_id')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                            id="max_check-group"
                            label="Anzahl der auswählbaren Antworten:"
                            label-for="max_check">
                        <b-form-input
                                id="max_check"
                                type="number"
                                min="1"
                                :step="1"
                                v-model="form.max_check">
                        </b-form-input>
                        <b-form-invalid-feedback :force-show="form.errors.has('max_check')" v-text="form.errors.get('max_check')">
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                            label="Antwortmöglichkeiten:">
                        <b-card v-for="(option, index) in form.options" :key="index" class="mb-2" bg-variant="secondary">
                            <div class="d-flex">
                                <b-input placeholder="Titel der Antwortmöglichkeit eingeben." v-model="form.options[index]"></b-input>
                                <b-button v-if="canDelete" @click="deletePollOption(index)" variant="danger" class="ml-3">Löschen</b-button>
                            </div>
                        </b-card>
                        <b-form-invalid-feedback :force-show="form.errors.has('options')" v-text="form.errors.get('questions')">
                        </b-form-invalid-feedback>
                        <div class="d-flex justify-content-end mt-4">
                            <b-button @click="addPollOption" variant="primary">Weitere Antwortmöglichkeit hinzufügen</b-button>
                        </div>
                    </b-form-group>
                    <b-alert class="mt-2 mb-4" :show="form.errors.has('common')" variant="danger" v-text="form.errors.get('common')">
                    </b-alert>
                    <b-button type="submit" :disabled="!isSubmitEnabled || form.errors.any()" block variant="success" size="lg">Abstimmung veröffentlichen</b-button>
                </b-form>
            </b-card>
        </can>
    </div>

</template>

<script>
    import { mapGetters } from "vuex";
    import { ability } from "../../store";
    import Form from "../../core/Form";
    import {STORE_POLL} from "../../store/actions.type";

    export default {
        name: "CreatePoll",
        data() {
            return {
                form: new Form({
                    question: null,
                    description: null,
                    group_id: null,
                    max_check: 1,
                    options: ['', ''],
                })
            }
        },
        computed: {
            ...mapGetters(["isAuthenticated", "currentUser"]),
            canDelete() {
                return this.form.options.length > 2
            },
            groupOptions() {
                if (this.currentUser.groups !== undefined) {
                    // TODO: Implement Conditions for Groups
                    return this.currentUser.groups
                        .filter(group => ability.can('create-poll', 'Poll'))
                        .map(group => {
                            return { value: group.id, text: group.name }
                        })
                }
            },
            isSubmitEnabled() {
                if (this.form.question === null || this.form.question === "") {
                    return false
                }
                if (this.form.description === null || this.form.description === "") {
                    return false
                }
                if (this.form.group_id === null) {
                    return false
                }
                if (this.form.max_check < 1 || this.form.max_check >= this.form.options.length) {
                    return false
                }
                for (let i = 0; i < this.form.options.length; i++) {
                    if (this.form.options[i] === '') {
                        return false
                    }
                }
                return true
            }
        },
        methods: {
            addPollOption() {
                this.form.options.push('')
            },
            deletePollOption(index) {
                this.form.options.splice(index, 1)
            },
            submit() {

                const payload = this.form.data()
                const storeRequest = this.$store.dispatch(STORE_POLL, payload)

                storeRequest.then(() => {
                    this.$router.push({ name: "polls" });
                })

                storeRequest.catch((errors) => {

                })

                this.form.submit(storeRequest)

            }
        }
    }
</script>

<style scoped>

</style>