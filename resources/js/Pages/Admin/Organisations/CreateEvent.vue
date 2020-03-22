<template>


    <div class="pb-32">

        <div class="flex flex-col md:flex-row justify-between">
            <div>
                <h3 class="text-gray-900 text-3xl font-bold">Neue Veranstaltung erstellen</h3>
                <p class="text-gray-600">Erstelle eine neue Veranstaltung für diese Organisation.</p>
            </div>
            <LanguagePicker class="mt-4 md:mt-0" />
        </div>

        <div class="mt-8 bg-white shadow px-4 py-5 rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Allgemeine Informationen</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        This information will be displayed publicly so be careful what you share.
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">

                        <div class="sm:col-span-4">
                            <TextInput
                                    id="title"
                                    label="Titel"
                                    placeholder="Titel">

                            </TextInput>
                        </div>

                        <PictureInput class="mt-4"
                                      label="Titelbild" />


                    </form>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Datum</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Wähle den Veranstaltungszeitpunkt aus.
                    </p>
                </div>
                <div class="relative mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">

                        <div class="grid grid-cols-6 gap-6">

                            <DatePicker
                                class="col-span-6 sm:col-span-3"
                                id="startDate"
                                label="Anfangsdatum"
                                placeholder="Anfangsdatum"
                                :disabled="form.noDate">

                            </DatePicker>

                            <TimePicker
                                    class="col-span-6 sm:col-span-3"
                                    id="startTime"
                                    label="Anfangszeit"
                                    placeholder="Anfangszeit"
                                    :disabled="form.noDate">

                            </TimePicker>

                            <DatePicker
                                    class="col-span-6 sm:col-span-3"
                                    id="endDate"
                                    label="Enddatum"
                                    placeholder="Enddatum"
                                    :disabled="form.noDate">

                            </DatePicker>

                            <TimePicker
                                    class="col-span-6 sm:col-span-3"
                                    id="endTime"
                                    label="Endzeit"
                                    placeholder="Endzeit"
                                    :disabled="form.noDate">

                            </TimePicker>

                        </div>

                        <Checkbox
                                class="mt-4"
                                id="no-date"
                                label="Datum unbekannt"
                                hint="Das Datum ist noch nicht bekannt und wird erst später veröffentlicht."
                                v-model="form.noDate">

                        </Checkbox>

                    </form>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
                <PrimaryButton>
                    Speichern
                </PrimaryButton>
            </div>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Veranstaltungsort</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Wähle den Veranstaltungsort aus der Liste aus oder trage die Adresse ein.
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">

                        <!-- Select: Entry -->
                        <div class="col-span-6 sm:col-span-3">
                            <SelectInput
                                    label="Veranstaltungsort"
                                    :disabled="form.useTempLocation">
                                <option :value="null">
                                    Ort noch nicht bekannt
                                </option>
                                <option v-for="entry in entries" :value="entry.id">
                                    {{ entry.name }}
                                </option>
                            </SelectInput>
                        </div>

                        <!-- Checkbox: Use Temp Location -->
                        <div class="flex">
                            <Checkbox
                                    class="mt-4"
                                    id="use-temp-location"
                                    label="Anderen Ort verwenden"
                                    hint="Wenn der Ort nicht in der Liste verfügbar ist, kannst du ihn hier temporär eintragen."
                                    v-model="form.useTempLocation">

                            </Checkbox>
                        </div>


                        <!-- Form: Temporary Location -->
<!--                        <transition>-->
                            <div class="mt-4 grid grid-cols-6 gap-6" v-if="form.useTempLocation">

                                <TextInput class="col-span-5"
                                           id="street_address"
                                           label="Straße"
                                           placeholder="Straße" />

                                <TextInput class="col-span-1"
                                           id="house_number"
                                           label="Hausnummer"
                                           placeholder="Nr" />


                                <TextInput class="col-span-6 sm:col-span-6 lg:col-span-3"
                                           id="city"
                                           label="Stadt"
                                           placeholder="Stadt" />

                                <TextInput class="col-span-6 sm:col-span-6 lg:col-span-3"
                                           id="postcode"
                                           label="PLZ"
                                           placeholder="PLZ" />

                            </div>
<!--                        </transition>-->

                    </form>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <PrimaryButton>
                    Speichern
                </PrimaryButton>
            </div>
        </div>

    </div>

</template>

<script>
    import CardContainer from "../../../Shared/UI/CardContainer";
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import LoadingButton from "../../../Shared/LoadingButton";
    import TextInput from "../../../Shared/TextInput";
    import TextareaInput from "../../../Shared/TextareaInput";
    import PageEditor from "../../../Shared/PageEditor";
    import LanguagePicker from "../../../Shared/UI/LanguagePicker";
    import ImagePreviewInput from "../../../Shared/UI/ImagePreviewInput";
    import PictureInput from "../../../Shared/UI/PictureInput";
    import SelectInput from "../../../Shared/UI/SelectInput";
    import PrimaryButton from "../../../Shared/UI/PrimaryButton";
    import vuejsDatepicker from 'vuejs-datepicker';
    import {de} from 'vuejs-datepicker/dist/locale'
    import DatePicker from "../../../Shared/UI/DatePicker";
    import TimePicker from "../../../Shared/UI/TimePicker";
    import Checkbox from "../../../Shared/UI/Checkbox";

    export default {
        name: "CreateEvent",
        components: {
            Checkbox,
            TimePicker,
            DatePicker,
            PrimaryButton,
            SelectInput,
            vuejsDatepicker,
            ImagePreviewInput, PictureInput,
            LanguagePicker, PageEditor, TextareaInput, TextInput, LoadingButton, CardContainer},
        layout: LayoutAdmin,
        props: {
            entries: Array
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                de: de,
                form: {
                    name: null,
                    description: null,
                    useTempLocation: false,
                    noDate: false
                },
            }
        },
        methods: {
            submit() {
                // this.$inertia
                //     .put(this.route('admin.polls.update', this.poll.id), this.form)
                //     .then(() => this.sending = false)
            },
        }
    }
</script>

<style scoped>

</style>