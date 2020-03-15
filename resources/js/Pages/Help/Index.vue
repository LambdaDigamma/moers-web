<template>

    <div>
        <div class="mt-4 md:mt-8">

            <div class="bg-gray-200 overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900">
                        Hilf mit, die Krise gemeinsam zu bewältigen!
                    </h2>
                    <p class="my-2">Ab heute bieten wir eine Platform an, um als Moerserinnen und Moerser zusammen zu stehen und einander zu helfen!</p>
                    <p class="mb-2">
                        In der aktuellen Zeit halten sich viele Menschen in freiwilliger oder angeordneter Quarantäne auf.
                        Auch andere Menschen und besonders gefährdete Gruppen versuchen, den Kontakt mit anderen Menschen zu beschränken.
                        Wenn du diesen Menschen helfen willst, kannst du deine Hilfe anbieten oder Aufgaben wahrnehmen.
                        Falls du Hilfe brauchst, kannst du sie hier suchen und finden!
                    </p>
                    <div class="mt-5 flex flex-col md:flex-row">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button type="button" class="inline-flex w-full items-center px-6 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-500 hover:bg-green-400 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-700 transition ease-in-out duration-150">
                                <svg class="-ml-1 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd" />
                                </svg>
                                Ich möchte helfen!
                            </button>
                        </span>
                        <span class="ml-0 mt-4 md:ml-4 md:mt-0 inline-flex rounded-md shadow-sm">
                            <button type="button" class="inline-flex w-full items-center px-6 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150">
                                <svg class="-ml-1 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                </svg>
                                Ich benötige Hilfe!
                            </button>
                        </span>
                    </div>
                </div>
            </div>


        </div>

    </div>


</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";

    export default {
        name: "Index",
        layout: LayoutGeneral
    }
</script>

<style scoped>

</style>