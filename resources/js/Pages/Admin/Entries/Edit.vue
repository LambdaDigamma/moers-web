<template>

    <div>
        <FormColumnPanel method="PUT" @save="updateEntry">
            <div slot="description">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Allgemeines
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Bearbeite die allgemeinen Informationen
                </p>
            </div>
            <div>
                <div class="grid grid-cols-6 gap-6">
                    <TextInput class="col-span-6 sm:col-span-4"
                               label="Name" placeholder="Name"
                               v-model="form.name"
                               :errors="$page.errors.name">

                    </TextInput>
<!--                    <TextInput class="col-span-6 sm:col-span-4"-->
<!--                               label="Schlagworte" placeholder="Schlagworte"-->
<!--                               v-model="form.tags"-->
<!--                               :errors="$page.errors.tags">-->

<!--                    </TextInput>-->
                </div>
            </div>
        </FormColumnPanel>

        <FormColumnPanel class="mt-6" method="PUT"  @save="updateEntry">
            <div slot="description">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Adresse
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Bearbeite die Adresse des Eintrags.
                </p>
            </div>
            <div>
                <div class="grid grid-cols-6 gap-6">
                    <TextInput class="col-span-6 sm:col-span-4"
                               label="Straße" placeholder="Straße"
                               v-model="form.street"
                               :errors="$page.errors.street">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-2"
                               label="Hausnummer" placeholder="Hausnummer"
                               v-model="form.house_number"
                               :errors="$page.errors.house_number">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Ort" placeholder="Ort"
                               v-model="form.place"
                               :errors="$page.errors.place">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Postleitzahl" placeholder="PLZ"
                               v-model="form.postcode"
                               :errors="$page.errors.postcode">

                    </TextInput>

                </div>
            </div>
        </FormColumnPanel>

        <FormColumnPanel class="mt-6" method="PUT" @save="updateEntry">
            <div slot="description">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Öffnungszeiten
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Bearbeite die Öffnungszeiten des Eintrags.
                </p>
            </div>
            <div>
                <div class="grid grid-cols-6 gap-6">
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Montag" placeholder="Montag"
                               v-model="form.monday"
                               :errors="$page.errors.monday">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Dienstag" placeholder="Dienstag"
                               v-model="form.tuesday"
                               :errors="$page.errors.tuesday">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Mittwoch" placeholder="Wednesday"
                               v-model="form.wednesday"
                               :errors="$page.errors.wednesday">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Donnerstag" placeholder="Donnerstag"
                               v-model="form.thursday"
                               :errors="$page.errors.thursday">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Freitag" placeholder="Freitag"
                               v-model="form.friday"
                               :errors="$page.errors.friday">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Samstag" placeholder="Samstag"
                               v-model="form.saturday"
                               :errors="$page.errors.saturday">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Sonntag" placeholder="Sonntag"
                               v-model="form.sunday"
                               :errors="$page.errors.sunday">

                    </TextInput>
                    <TextInput class="col-span-6 sm:col-span-3"
                               label="Sonstiges" placeholder="Sonstiges"
                               v-model="form.other"
                               :errors="$page.errors.other">

                    </TextInput>
                </div>
            </div>
        </FormColumnPanel>
    </div>

</template>

<script>
    import FormColumnPanel from "../../../Shared/UI/Panels/FormColumnPanel";
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import Form from "../../../Helper/Form";
    export default {
        name: "Edit",
        components: {FormColumnPanel},
        layout: LayoutAdmin,
        props: {
            entry: Object
        },
        data() {
            return {
                form: {
                    name: this.entry.name,
                    url: this.entry.url,
                    phone: this.entry.phone,
                    // tags: this.entry.tags,
                    street: this.entry.street,
                    house_number: this.entry.house_number,
                    place: this.entry.place,
                    postcode: this.entry.postcode,
                    monday: this.entry.monday,
                    tuesday: this.entry.tuesday,
                    wednesday: this.entry.wednesday,
                    thursday: this.entry.thursday,
                    friday: this.entry.friday,
                    saturday: this.entry.saturday,
                    sunday: this.entry.sunday,
                    other: this.entry.other
                }
            }
        },
        methods: {
            updateEntry() {
                let formData = new Form(this.form)
                    .toFormData('put')
                this.$inertia
                    .post(this.route('admin.entries.update', [this.entry.id]).url(), formData)
            }
        }
    }
</script>

<style scoped>

</style>