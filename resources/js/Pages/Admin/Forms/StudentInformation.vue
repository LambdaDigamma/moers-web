<template>

    <div class="space-y-6">

        <div class="grid grid-cols-2 gap-6">
            <div class="flex items-center justify-center h-64">
                <img :src="'/image/' + studentInformation.photo_old_path" class="h-full" />
            </div>
            <div class="flex items-center justify-center h-64">
                <img :src="'/image/' + studentInformation.photo_new_path" class="h-full" />
            </div>
        </div>

        <Panel>

            <h2 class="text-xl font-semibold">Name:</h2>

            <div class="mt-2 flex items-center space-x-6">
                <span class="font-medium">
                    {{ studentInformation.name }}
                </span>

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                            v-clipboard:copy="studentInformation.name">
                        Kopieren
                    </button>
                </span>
            </div>

        </Panel>

        <div class="grid grid-cols-2 gap-6">
            <Panel>

                <h2 class="text-xl font-semibold">a.k.a.:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.nickname }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.nickname">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
            <Panel>

                <h2 class="text-xl font-semibold">LK A:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.lkA }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.lkA">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <Panel>

                <h2 class="text-xl font-semibold">Geburtstag:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.birthday }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.birthday">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
            <Panel>

                <h2 class="text-xl font-semibold">LK B:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.lkB }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.lkB">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
        </div>

        <Panel>

            <h2 class="text-xl font-semibold">Redewendung:</h2>

            <div class="mt-2 flex items-center space-x-6">
                <span class="font-medium">
                    {{ studentInformation.slogan }}
                </span>

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.slogan">
                        Kopieren
                    </button>
                </span>
            </div>

        </Panel>

        <div class="grid grid-cols-2 gap-6">
            <Panel>

                <h2 class="text-xl font-semibold">Lebensmotto:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.motto }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.motto">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
            <Panel>

                <h2 class="text-xl font-semibold">Soundtrack des Lebens:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.soundtrack }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.soundtrack">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <Panel>

                <h2 class="text-xl font-semibold">Stärken:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.strengths }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.strengths">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
            <Panel>

                <h2 class="text-xl font-semibold">Schwächen:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.weaknesses }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.weaknesses">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <Panel>

                <h2 class="text-xl font-semibold">Das werde ich am wenigsten vermissen:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.miss_least }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.miss_least">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
            <Panel>

                <h2 class="text-xl font-semibold">Das werde ich am meisten vermissen:</h2>

                <div class="mt-2 flex items-center space-x-6">
                    <span class="font-medium">
                        {{ studentInformation.miss_most }}
                    </span>

                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.miss_most">
                            Kopieren
                        </button>
                    </span>
                </div>

            </Panel>
        </div>

        <Panel>

            <h2 class="text-xl font-semibold">Mein Schulhighlight:</h2>

            <div class="mt-2 flex items-center space-x-6">
                <span class="font-medium">
                    {{ studentInformation.highlight }}
                </span>

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" v-clipboard:copy="studentInformation.highlight">
                        Kopieren
                    </button>
                </span>
            </div>

        </Panel>

    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import Panel from "../../../Shared/UI/Panels/Panel";

    export default {
        name: "StudentInformation",
        components: {Panel},
        layout: LayoutAdmin,
        props: {
            studentInformation: Object
        }
    }
</script>

<style scoped>

</style>