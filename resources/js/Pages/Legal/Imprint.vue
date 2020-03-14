<template>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <inertia-link :href="route('landingPage')" class="block py-6 font-bold text-4xl text-center mx-auto">Mein Moers</inertia-link>

        <header class="mt-6">
            <h2 class="text-3xl font-bold leading-tight text-gray-900">
                Impressum
            </h2>
        </header>

        <main class="flex flex-row">

            <div class="w-1/2">
                <h2 class="my-5 text-lg font-semibold">Angaben gemäß § 5 TMG und § 55 Abs. 2 RStV, V.i.S.d.P</h2>
                <p class="mt-3">
                    Open Knowledge Foundation Deutschland e.V.<br />
                    Singerstr. 109<br />
                    10179 Berlin<br />
                    Deutschland<br />
                </p>

                <p class="mt-4">
                    Vereinsregister Nr: VR 30468 B<br />
                    Steuernummer: 27/674/52428<br />
                    VAT: DE278022128
                </p>

                <h2 class="my-5 text-lg font-semibold">Kontakt:</h2>
                <p class="mt-3">
                    Mail: info[at]codefor.de<br />
                    Tel: +49 30 57703666-0<br />
                    Fax: +49 30 57703666-9<br />
                </p>

                <h2 class="my-5 text-lg font-semibold">Kontakt zu unserem Lab:</h2>
                <p class="mt-3">
                    Ansprechpartner: Lennart Fischer<br />
                    <br />
                    Telefon: 015678 522333<br />
                    E-Mail: info@lambdadigamma.com<br />
                </p>
            </div>

            <div class="w-1/2">
                <h2 class="my-5 text-lg font-semibold">Entwickler und inhaltlich Verantworlicher</h2>
                <p class="mt-3">
                    Lennart Fischer<br />
                    Telefon: 015678 522333<br />
                    E-Mail: info@lambdadigamma.com<br />
                </p>

            </div>

        </main>

    </div>

</template>

<script>
    export default {
        name: "Imprint"
    }
</script>

<style scoped>

</style>