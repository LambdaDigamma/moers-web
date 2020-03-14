<template>

    <div>

        <header>
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Profil
                </h2>
            </div>
        </header>

        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Persönliche Informationen</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Diese Informationen werden mit Vorsicht behandelt.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <TextInput label="Name" placeholder="Name" v-model="form.name" :is-optional="true" />
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label for="about" class="block text-sm leading-5 font-medium text-gray-700">
                                        About
                                    </label>
                                    <div class="rounded-md shadow-sm">
                                        <textarea id="about" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                  placeholder="you@example.com" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief description for your profile.
                                    </p>
                                </div>
                            </div>


                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                        Speichern
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import LayoutAdmin from "../../Shared/LayoutAdmin";
    import TextInput from "../../Shared/TextInput";

    export default {
        name: "Details",
        components: {TextInput},
        layout: LayoutAdmin,
        metaInfo: {
            title: 'Profil'
        },
        props: {
            personalInformation: Object
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    name: this.personalInformation.name,
                    description: this.personalInformation.description,
                },
            }
        },
    }
</script>

<style scoped>

</style>