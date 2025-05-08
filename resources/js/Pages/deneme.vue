<script setup>
import { onMounted, ref } from "vue";
import { Loader } from "@googlemaps/js-api-loader";

const loader = new Loader({
    apiKey: "AIzaSyC_ebf1LyWIkeITRy9L4FfzkWP5lBPLYcc",
    version: "weekly",
    libraries: ["places"],
});

const map = ref([]);

onMounted(async () => {
    await loader
        .load()
        .then((google) => {
            map.value = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8,
            });
        })
        .catch((error) => {
            console.log(error);
        })
        .then(function () {
            // always executed
        });
});
</script>

<template>
    <div class="map" id="map"></div>
</template>
