<script setup>
import { onMounted, ref } from "vue";
import { Loader } from "@googlemaps/js-api-loader";

const loader = new Loader({
    apiKey: "AIzaSyC_ebf1LyWIkeITRy9L4FfzkWP5lBPLYcc",
    version: "weekly",
    libraries: ["places"],
});

const map = ref(null);
const marker = ref(null);
const markerPosition = ref({ lat: -34.397, lng: 150.644 });

onMounted(async () => {
    await loader
        .load()
        .then((google) => {
            map.value = new google.maps.Map(document.getElementById("map"), {
                center: markerPosition.value,
                zoom: 8,
            });

            // Marker'ı haritaya ekle
            marker.value = new google.maps.Marker({
                position: markerPosition.value,
                map: map.value,
                title: "Yardım Talep Edilen Konum",
            });

            // Harita üzerinde tıklama ile marker'ı yeni bir yere taşı
            google.maps.event.addListener(map.value, 'click', (event) => {
                const latLng = event.latLng;
                markerPosition.value = { lat: latLng.lat(), lng: latLng.lng() };
                marker.value.setPosition(markerPosition.value);
            });
        })
        .catch((error) => {
            console.log(error);
        });
});

const requestHelp = () => {
    console.log("Yardım talep ediliyor...");
    console.log("Marker Konumu:", markerPosition.value);
    // Burada marker'ın konumunu bir API'ye veya veritabanına gönderebilirsiniz.
};
</script>

<template>
    <div class="p-10">
        <h1 class="text-2xl font-bold mb-4">Afet Yardım Platformu</h1>
        <div id="map" style="width: 100%; height: 500px"></div>
        <button @click="requestHelp" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">
            Yardım Talep Et
        </button>
    </div>
</template>
