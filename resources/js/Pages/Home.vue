<script setup>
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex flex-col items-center p-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Hoş Geldiniz</h1>
    <p class="text-lg text-gray-600 mb-8 text-center max-w-md">
      Uygulamamıza giriş yaparak veya kaydolarak daha fazla özelliğe erişebilirsiniz.
    </p>

    <div class="flex space-x-4 mb-10">
      <Link :href="route('login')">
        <button class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
          Giriş Yap
        </button>
      </Link>
      <Link :href="route('register')">
        <button class="px-6 py-3 bg-gray-300 text-gray-800 rounded-xl hover:bg-gray-400 transition">
          Kayıt Ol
        </button>
      </Link>
    </div>

    <!-- Üyelik Planları -->
    <div class="grid md:grid-cols-3 gap-6 max-w-5xl w-full">
      <!-- Ücretsiz Plan -->
      <div class="bg-white rounded-2xl shadow p-6 text-center">
        <h2 class="text-xl font-bold mb-2">Ücretsiz</h2>
        <p class="text-gray-600 mb-4">₺0 / ay</p>
        <ul class="text-gray-500 text-sm mb-4 space-y-1">
          <li>✔ Sınırlı analiz hakkı</li>
          <li>✔ Temel raporlar</li>
          <li>✘ Kişisel öneriler yok</li>
        </ul>
        <Link :href="route('register')">
          <button class="w-full py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition">Başla</button>
        </Link>
      </div>

      <!-- Standart Plan -->
      <div class="bg-white rounded-2xl shadow-lg p-6 text-center border-2 border-blue-500">
        <h2 class="text-xl font-bold mb-2 text-blue-600">Standart</h2>
        <p class="text-gray-700 mb-4">₺29 / ay</p>
        <ul class="text-gray-600 text-sm mb-4 space-y-1">
          <li>✔ Aylık 20 analiz</li>
          <li>✔ Kişisel raporlar</li>
          <li>✔ Genel öneriler</li>
        </ul>
        <Link :href="route('register')">
          <button class="w-full py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">Kayıt Ol</button>
        </Link>
      </div>

      <!-- Premium Plan -->
      <div class="bg-white rounded-2xl shadow p-6 text-center">
        <h2 class="text-xl font-bold mb-2 text-yellow-600">Premium</h2>
        <p class="text-gray-700 mb-4">₺59 / ay</p>
        <ul class="text-gray-600 text-sm mb-4 space-y-1">
          <li>✔ Sınırsız analiz</li>
          <li>✔ Detaylı öneriler</li>
          <li>✔ Öncelikli destek</li>
        </ul>
        <Link :href="route('register')">
          <button class="w-full py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition">Kayıt Ol</button>
        </Link>
      </div>
    </div>
  </div>
</template>
