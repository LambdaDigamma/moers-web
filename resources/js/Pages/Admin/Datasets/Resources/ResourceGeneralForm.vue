<template>

    <div>
        <div class="mt-8 bg-white rounded-lg shadow">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Allgemeines</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Trage die allgemeinen Informationen ein.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">

                        <div class="grid grid-cols-3 gap-6">

                            <div class="col-span-3 sm:col-span-2">
                                <TextInput
                                        label="Name der Resource"
                                        placeholder="Name"
                                        v-model="form.name"
                                        :errors="$page.errors.name">

                                </TextInput>
                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <SelectInput
                                        label="Format"
                                        v-model="form.format"
                                        :errors="$page.errors.format">
                                    <option v-for="(format, index) in formats" :value="format" :key="index">
                                        {{ format.toUpperCase() }}
                                    </option>
                                </SelectInput>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <Checkbox
                                        id="auto-import"
                                        label="Auto-Import"
                                        hint="Soll diese Resource automatisch aktualisiert werden, wenn eine URL hinterlegt ist?"
                                        v-model="form.shouldAutoImport">

                                </Checkbox>
                            </div>
                            <div class="col-span-3 sm:col-span-2" v-if="form.shouldAutoImport">
                                <TextInput label="Update-Interval (in h)"
                                           type="number"
                                           placeholder="Interval"
                                           v-model="form.autoUpdatingInterval"
                                           :min="1"
                                           :max="10000"
                                           :errors="$page.errors.auto_updating_interval"></TextInput>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="px-4 py-3 text-right rounded-b-lg bg-gray-50 sm:px-6">
                    <PrimaryButton type="submit">
                        Speichern
                    </PrimaryButton>
                </div>
            </form>
        </div>
        <div class="mt-8 bg-white rounded-lg shadow">
            <form @submit.prevent="">
                <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Daten</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Füge eine Resource manuell hinzu oder gib eine Quelle ein.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">

                        <div class="grid grid-cols-3 gap-6">

                            <div class="col-span-3 sm:col-span-3">
                                <TextInput
                                        label="Datenquelle"
                                        placeholder="URL"
                                        hint="Füge eine Datenquelle hinzu, von der die Daten periodisch geladen werden." />
                            </div>


<!--                            <div class="col-span-3 sm:col-span-3">-->

<!--                                <TextareaInput-->
<!--                                        label="Beschreibung"-->
<!--                                        placeholder="Beschreibung"-->
<!--                                        hint="Eine kurze Beschreibung für dein Profil."-->
<!--                                        :no-wrap="true"-->
<!--                                        :errors="$page.errors.description" />-->

<!--                            </div>-->
                        </div>

                    </div>
                </div>
                <div class="px-4 py-3 text-right rounded-b-lg bg-gray-50 sm:px-6">
                    <PrimaryButton type="submit">
                        Speichern
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    import {de} from "vuejs-datepicker/dist/locale";
    import NumberInput from "../../../../Shared/UI/NumberInput";
    import TextareaInput from "../../../../Shared/UI/TextareaInput";
    import TextInput from "../../../../Shared/UI/TextInput";
    import PrimaryButton from "../../../../Shared/UI/PrimaryButton";

    export default {
        name: "ResourceGeneralForm",
        components: {PrimaryButton, TextInput, TextareaInput, NumberInput},
        props: {
            resource: {
                type: Object,
                default() {
                    return {
                        name: null,
                        format: null,
                        shouldAutoImport: true,
                        autoUpdatingInterval: 24
                    }
                }
            }
        },
        data() {
            return {
                de: de,
                standardCode: "de",
                formats: ['csv', 'json', 'geojson', 'text'],
                form: {
                    name: this.resource.name,
                    format: this.resource.format,
                    shouldAutoImport: this.resource.auto_updating_interval !== null,
                    autoUpdatingInterval: this.resource.autoUpdatingInterval !== null ? this.resource.auto_updating_interval : 24
                }
            }
        },
        computed: {
            formData() {

                let data = new FormData()
                data.append('name', this.form.name || '')
                data.append('format', this.form.format || '')

                if (this.form.shouldAutoImport) {
                    data.append('auto_updating_interval', this.form.autoUpdatingInterval || '')
                } else {
                    data.append('auto_updating_interval', "")
                }

                return data
            },
        },
        methods: {
            submit() {
                this.$emit('submit', this.formData)
            },
        }
    }
</script>

<style scoped>

</style>