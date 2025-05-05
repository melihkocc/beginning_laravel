<template>
    <div class="p-10">
      <h1 class="text-2xl font-bold mb-4">Afet Yardım Platformu</h1>
  
      <div ref="map" style="width: 100%; height: 500px;"></div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  
  const map = ref(null)
  
  onMounted(() => {
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyC_ebf1LyWIkeITRy9L4FfzkWP5lBPLYcc&libraries=places`;
    script.async = true;
    document.head.appendChild(script);
  
    script.onload = () => {
      const myMap = new google.maps.Map(map.value, {
        center: { lat: 39.92077, lng: 32.85411 }, // Ankara başlangıç
        zoom: 6
      });
    }
  })
  </script>
  