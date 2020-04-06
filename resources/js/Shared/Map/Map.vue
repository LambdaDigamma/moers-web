<template>

    <div id="map" ref="map">

    </div>

</template>

<script>
    export default {
        name: "Map",
        props: {
            entries: {
                type: Array,
                default: () => []
            },
            isRotationEnabled: {
                type: Boolean,
                default: true
            },
            isZoomEnabled: {
                type: Boolean,
                default: true
            },
            showsZoomControl: {
                type: Boolean,
                default: true
            },
        },
        data() {
            return {
                map: null
            }
        },
        watch: {
            entries: function (entries) {
                this.addEntryMarker()
            }
        },
        methods: {
            initializeMap() {
                mapkit.init({
                    authorizationCallback: function(done) {
                        fetch("/maps/auth")
                            .then(res => res.text())
                            .then(done);
                    },
                    language: "de"
                });
            },
            setupMap() {
                this.map = new mapkit.Map("map", {
                    isRotationEnabled: this.isRotationEnabled,
                    isZoomEnabled: this.isZoomEnabled,
                    showsZoomControl: this.showsZoomControl
                });
            },
            setRegion() {
                let moers = {
                    region: new mapkit.CoordinateRegion(
                        new mapkit.Coordinate(51.4510, 6.6286),
                        new mapkit.CoordinateSpan(0.01, 0.01)
                    ),
                    zoomRange: new mapkit.CameraZoomRange(250, 15000)
                }
                this.map.cameraZoomRange = moers.zoomRange;
                this.map.cameraBoundary = moers.region;
                this.map.region = moers.region;
            },
            addEntryMarker() {
                let annotations = this.entries.map(entry => this.generateAnnotation(entry.lat, entry.lng, '#000000', entry.name, 'M'));
                console.log(annotations.length)
                this.map.showItems(annotations)
            },
            generateAnnotation(latitude, longitude, color, title, glyphText) {

                let coordinate = new mapkit.Coordinate(latitude, longitude);
                let annotation = new mapkit.MarkerAnnotation(coordinate, {
                    color: color,
                    title: title,
                    glyphText: glyphText
                });

                return annotation;

            }

        },
        mounted() {
            this.initializeMap()
            this.setupMap()
            this.setRegion()
            this.addEntryMarker()
        },
    }
</script>

<style scoped>

</style>