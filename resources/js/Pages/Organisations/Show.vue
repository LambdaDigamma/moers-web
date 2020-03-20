<template>

    <div>

        <div class="mt-6">

            <div class="h-64 w-full relative overflow-hidden rounded-lg shadow-md" v-if="organisation.header_path">
                <img class="absolute object-center object-cover w-full h-full"
                     :src="organisation.header_path" />
            </div>



            <div class="mt-6 bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">

                    <div class="flex items-center">
                        <div class="flex-shrink-0 items-center">
                            <div class="w-32 h-32 relative rounded-md overflow-hidden">
                                <img class="absolute inset-0 inset-y-0 w-32 h-auto object-center object-scale-down"
                                     :src="organisation.logo_path"
                                     alt="" />
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ organisation.name }}
                            </h3>
                            <p class="text-sm leading-5 text-gray-500">
                                {{ organisation.description }}
                            </p>
                        </div>
                    </div>





<!--                    <div class="mt-4">-->
<!--                        <div class="sm:hidden">-->
<!--                            <select class="form-select block w-full">-->
<!--                                <option>My Account</option>-->
<!--                                <option>Company</option>-->
<!--                                <option selected>Team Members</option>-->
<!--                                <option>Billing</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="hidden sm:block">-->
<!--                            <nav class="flex">-->
<!--                                <a href="#" class="px-3 py-2 font-medium text-sm leading-5 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600 focus:bg-indigo-50">-->
<!--                                    My Account-->
<!--                                </a>-->
<!--                                <a href="#" class="ml-4 px-3 py-2 font-medium text-sm leading-5 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600 focus:bg-indigo-50">-->
<!--                                    Company-->
<!--                                </a>-->
<!--                                <a href="#" class="ml-4 px-3 py-2 font-medium text-sm leading-5 rounded-md text-indigo-700 bg-indigo-100 focus:outline-none focus:text-indigo-800 focus:bg-indigo-200">-->
<!--                                    Team Members-->
<!--                                </a>-->
<!--                                <a href="#" class="ml-4 px-3 py-2 font-medium text-sm leading-5 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600 focus:bg-indigo-50">-->
<!--                                    Billing-->
<!--                                </a>-->
<!--                            </nav>-->
<!--                        </div>-->
<!--                    </div>-->




                </div>

            </div>


        </div>

    </div>

</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import WhiteButton from "../../Shared/UI/WhiteButton";
    import SecondaryButton from "../../Shared/UI/SecondaryButton";
    import PrimaryButton from "../../Shared/UI/PrimaryButton";

    export default {
        name: "Show",
        components: {PrimaryButton, SecondaryButton, WhiteButton},
        layout: LayoutGeneral,
        props: {
            organisation: Object
        }
    }
</script>

<style scoped>

</style>