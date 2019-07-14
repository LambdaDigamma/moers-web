<template>

    <b-container class="mt-0">

        <b-img src="img/hero.png" fluid alt="Responsive image"></b-img>

        <h1 class="text-center">
            Mein Moers.
            Dein Moers.
            Unser Moers!
        </h1>

        <b-row class="mt-4">
            <a href="https://apps.apple.com/de/app/mein-moers/id1305862555?mt=8" class="mx-auto" style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/de-de/badge-lrg.svg?releaseDate=2018-02-19&kind=iossoftware&bubble=ios_apps) no-repeat; width:135px; height:40px;"></a>
        </b-row>

        <hr class="mt-4">

        <b-row class="mt-5">
            <p class="text-justify">
                Suche Moerser Geschäfte & Parkplätze mit Live-Daten und bewege Dich mit interaktiven 360° Panoramen durch die Stadt!<br>
                Finde tolle Veranstaltungen in Moers und Umgebung und vergleiche die aktuellen Kraftstoffpreise.<br>
                Der straßen-basierte Abfallkalendar den Überblick über Leerungstermine zu behalten und kann am Vorabend an die Leerungstermine erinnern.
            </p>
        </b-row>

        <Footer></Footer>

    </b-container>
</template>

<script>

    import Footer from '../components/Footer'

    export default {
        name: "Home",
        components: {
            Footer
        }
    }

</script>

<style scoped>

</style>