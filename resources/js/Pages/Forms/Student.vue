<template>

    <div class="pb-48">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Steckbrief Abizeitung</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        This information will be displayed publicly so be careful what you share.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <TextInput
                                    v-model="form.name"
                                    label="Name"
                                    class="w-full"
                                    :errors="$page.errors.name">

                            </TextInput>
                            <TextInput
                                    v-model="form.nickname"
                                    label="a.k.a."
                                    class="w-full mt-2"
                                    :errors="$page.errors.nickname">

                            </TextInput>
                            <TextInput
                                    v-model="form.birthday"
                                    label="Geburtsdatum (dd.MM.yyyy)"
                                    class="w-full mt-2"
                                    :errors="$page.errors.birthday">

                            </TextInput>
                            <TextInput
                                    v-model="form.slogan"
                                    label="Meine Redewendung (100 Zeichen)"
                                    class="w-full mt-2"
                                    :errors="$page.errors.slogan">

                            </TextInput>
                            <TextInput
                                    v-model="form.motto"
                                    label="Lebensmotto (100 Zeichen)"
                                    class="w-full mt-2"
                                    :errors="$page.errors.motto">

                            </TextInput>
                            <TextInput
                                    v-model="form.strengths"
                                    label="Stärken (100 Zeichen)"
                                    class="w-full mt-2"
                                    :errors="$page.errors.strengths">

                            </TextInput>
                            <TextInput
                                    v-model="form.weaknesses"
                                    label="Schwächen (100 Zeichen)"
                                    class="w-full mt-2"
                                    :errors="$page.errors.weaknesses">

                            </TextInput>
                            <TextInput
                                    v-model="form.lkA"
                                    label="LK A (Fach + Nachname Lehrer)"
                                    class="w-full mt-2"
                                    :errors="$page.errors.lkA">

                            </TextInput>
                            <TextInput
                                    v-model="form.lkB"
                                    class="w-full mt-2"
                                    label="LK B (Fach + Nachname Lehrer)"
                                    :errors="$page.errors.lkB">

                            </TextInput>
                            <TextareaInput
                                    v-model="form.highlight"
                                    class="w-full mt-2"
                                    label="Mein Schulhighlight (400 Zeichen)"
                                    :errors="$page.errors.highlight">

                            </TextareaInput>
                            <TextInput
                                    v-model="form.soundtrack"
                                    class="w-full mt-2"
                                    label="Soundtrack des Lebens"
                                    :errors="$page.errors.soundtrack">

                            </TextInput>
                            <TextInput
                                    v-model="form.miss_least"
                                    class="w-full mt-2"
                                    label="Was werde ich am wenigsten vermissen"
                                    :errors="$page.errors.miss_least">

                            </TextInput>
                            <TextInput
                                    v-model="form.miss_most"
                                    class="w-full mt-2"
                                    label="Was werde ich am meisten vermissen"
                                    :errors="$page.errors.miss_most">

                            </TextInput>
                            <FileInput
                                    v-model="form.photo_old"
                                    label="Neues Bild (Kindheit) hochladen"
                                    :errors="$page.errors.photo_old"
                                    class="w-full mt-2"
                                    type="file"
                                    accept="image/*">

                            </FileInput>
                            <FileInput
                                    v-model="form.photo_new"
                                    label="Neues Bild (Jetzt) hochladen"
                                    :errors="$page.errors.photo_new"
                                    class="w-full mt-2"
                                    type="file"
                                    accept="image/*">

                            </FileInput>

                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <PrimaryButton type="submit">
                                Speichern
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import TextInput from "../../Shared/UI/TextInput";
    import TextareaInput from "../../Shared/UI/TextareaInput";
    import FileInput from "../../Shared/FileInput";
    import PrimaryButton from "../../Shared/UI/PrimaryButton";

    export default {
        name: "Student",
        components: {PrimaryButton, FileInput, TextareaInput, TextInput},
        layout: LayoutGeneral,
        props: {
            existingInformation: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                sending: false,
                form: {
                    name: this.existingInformation?.name || null,
                    nickname: this.existingInformation?.nickname || null,
                    birthday: this.existingInformation?.birthday || null,
                    slogan: this.existingInformation?.slogan || null,
                    motto: this.existingInformation?.motto || null,
                    strengths: this.existingInformation?.strengths || null,
                    weaknesses: this.existingInformation?.weaknesses || null,
                    lkA: this.existingInformation?.lkA || null,
                    lkB: this.existingInformation?.lkB || null,
                    highlight: this.existingInformation?.highlight || null,
                    soundtrack: this.existingInformation?.soundtrack || null,
                    miss_least: this.existingInformation?.miss_least || null,
                    miss_most: this.existingInformation?.miss_most || null,
                    photo_old: null,
                    photo_new: null,
                }
            }
        },
        methods: {
            submit() {
                this.sending = true

                var data = new FormData()
                data.append('name', this.form.name || '')
                data.append('nickname', this.form.nickname || '')
                data.append('birthday', this.form.birthday || '')
                data.append('slogan', this.form.slogan || '')
                data.append('motto', this.form.motto || '')
                data.append('strengths', this.form.strengths || '')
                data.append('weaknesses', this.form.weaknesses || '')
                data.append('lkA', this.form.lkA || '')
                data.append('lkB', this.form.lkB || '')
                data.append('highlight', this.form.highlight || '')
                data.append('soundtrack', this.form.soundtrack || '')
                data.append('miss_least', this.form.miss_least || '')
                data.append('miss_most', this.form.miss_most || '')
                data.append('photo_old', this.form.photo_old || '')
                data.append('photo_new', this.form.photo_new || '')

                this.$inertia.post(this.route('forms.student.save').url(), data)
                    .then(() => this.sending = false)
            }
        }
    }
</script>

<style scoped>

</style>