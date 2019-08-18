<template>
    <div class="mt-5">

        <hr class="my-4">
        <h3>Profil</h3>

        <div class="my-4">
            <b-form>
                <b-form-group
                        id="input-group-name"
                        label="Name:"
                        label-for="name"
                        label-cols-sm="2">
                    <b-form-input
                            id="name"
                            required
                            v-model="currentUser.name"
                            placeholder="Namen eingeben"></b-form-input>
                </b-form-group>
                <b-form-group
                        id="input-group-bio"
                        label="Bio:"
                        label-for="bio"
                        label-cols="12"
                        label-cols-sm="2">
                    <b-form-input
                            id="bio"
                            required
                            v-model="currentUser.description"
                            placeholder="Bio eingeben"></b-form-input>
                </b-form-group>

                <div class="d-flex justify-content-end">
                    <b-button type="submit" variant="primary">Speichern</b-button>
                </div>
            </b-form>
        </div>

        <hr class="my-4">
        <h3>Benutzerkonto</h3>

        <div class="my-4">
            <b-form>
                <b-form-group
                        id="input-group-email"
                        label="E-Mail:"
                        label-for="email"
                        label-cols-sm="2"
                        description="Deine E-Mail Adresse dient nur Verifikationszwecken. Sie wird nicht mit Dritten geteilt oder zu Werbezwecken genutzt.">
                    <b-form-input
                            id="email"
                            type="email"
                            required
                            v-model="currentUser.email"
                            placeholder="E-Mail eingeben"></b-form-input>
                </b-form-group>
                <div class="d-flex justify-content-end">
                    <b-button type="submit" variant="primary">Speichern</b-button>
                </div>
            </b-form>
            <b-form class="mt-4">
                <b-form-group
                        id="input-group-password-1"
                        label="Neues Passwort:"
                        label-for="password-1"
                        label-cols-sm="2">
                    <b-form-input
                            id="password-1"
                            type="password"
                            required
                            placeholder="Passwort"></b-form-input>
                </b-form-group>
                <b-form-group
                        id="input-group-password-2"
                        label=""
                        label-for="password-2"
                        label-cols-sm="2">
                    <b-form-input
                            id="password-2"
                            type="password"
                            required
                            placeholder="Passwort bestätigen"></b-form-input>
                </b-form-group>
                <div class="d-flex justify-content-end">
                    <b-button type="submit" variant="warning">Ändern</b-button>
                </div>
            </b-form>
        </div>

        <hr class="my-4">
        <h3>Gefahrenbereich</h3>

        <div class="mt-4">
            <h5>Konto löschen</h5>
            <p class="text-muted my-2 mb-4">Du möchtest Dein Benutzerkonto und somit auch alle Deine Daten endgültig löschen?</p>
            <b-button variant="danger" block>Benutzerkonto löschen</b-button>
        </div>


    </div>
</template>

<script>

import { mapGetters } from "vuex"

export default {
    name: "ProfileSettings",
    computed: {
        ...mapGetters(["currentUser"])
    },
}

</script>

<style scoped>

</style>