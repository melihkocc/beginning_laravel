<script setup>
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const breadcrumbs = ref([
    { title: "Anasayfa", route: route("dashboard") },
]);

const user = usePage().props.auth.user;
</script>

<template>
  <Head title="Anasayfa" />

  <AuthenticatedLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-7xl mx-auto p-6 space-y-6">
      <div class="text-2xl font-semibold text-gray-800">
        👋 Merhaba, {{ user.name }}!
      </div>

      <!-- İstatistik Kartları -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 shadow rounded-xl">
          <div class="text-gray-500 text-sm">Toplam Tahmin</div>
          <div class="text-2xl font-bold text-blue-600">14</div>
        </div>
        <div class="bg-white p-4 shadow rounded-xl">
          <div class="text-gray-500 text-sm">AI Sohbetleri</div>
          <div class="text-2xl font-bold text-green-600">8</div>
        </div>
        <div class="bg-white p-4 shadow rounded-xl">
          <div class="text-gray-500 text-sm">Kayıtlı Formlar</div>
          <div class="text-2xl font-bold text-purple-600">5</div>
        </div>
        <div class="bg-white p-4 shadow rounded-xl">
          <div class="text-gray-500 text-sm">Son Giriş</div>
          <div class="text-md font-medium">{{ new Date().toLocaleDateString() }}</div>
        </div>
      </div>

      <!-- Hızlı Erişim Butonları -->
      <div class="flex flex-wrap gap-4">
        <Link
          href="/cancer-form"
          class="px-5 py-3 bg-pink-500 text-white rounded-xl shadow hover:bg-pink-600 transition"
        >
          Tahmin Yap
        </Link>
        <Link
          href="/ai-chat"
          class="px-5 py-3 bg-blue-500 text-white rounded-xl shadow hover:bg-blue-600 transition"
        >
          AI Sohbet
        </Link>
        <Link
          href="/profile"
          class="px-5 py-3 bg-gray-800 text-white rounded-xl shadow hover:bg-gray-900 transition"
        >
          Profilim
        </Link>
      </div>

      <!-- Son Tahminler (örnek) -->
      <div class="bg-white p-4 shadow rounded-xl mt-6">
        <div class="text-lg font-semibold mb-3">📄 Son Tahminler</div>
        <ul class="divide-y">
          <li class="py-2 flex justify-between">
            <span>Göğüs Kanseri Tahmini</span>
            <span class="text-sm text-gray-500">08 Mayıs 2025</span>
          </li>
          <li class="py-2 flex justify-between">
            <span>Rahim Kanseri Tahmini</span>
            <span class="text-sm text-gray-500">03 Mayıs 2025</span>
          </li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
