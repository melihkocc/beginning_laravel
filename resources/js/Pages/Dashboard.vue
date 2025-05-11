<script setup>
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const breadcrumbs = ref([{ title: "Anasayfa", route: route("dashboard") }]);

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
                    <div class="text-md font-medium">
                        {{ new Date().toLocaleDateString() }}
                    </div>
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
                        <span>Chlamidya Trochomatis Enfeksiyonu Tahmini</span>
                        <span class="text-sm text-gray-500">11 Mayıs 2025</span>
                    </li>
                    <li class="py-2 flex justify-between">
                        <span>Serviks Kanseri Tahmini</span>
                        <span class="text-sm text-gray-500">11 Mayıs 2025</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-4xl mx-auto px-6 py-10 bg-white shadow rounded-2xl">
            <h1 class="text-3xl font-bold text-[#9B51E0] mb-6 text-center">
                DoktorYanımda'ya Hoş Geldiniz
            </h1>

            <p class="text-gray-700 mb-4">
                Bu platform, sizin sağlık durumunuzu kolayca takip edebilmeniz
                için yapay zekâ destekli çözümler sunar. Kanser risk tahmini,
                kadın hastalıkları değerlendirmesi ve sağlık asistanı sohbet
                gibi özelliklerle size yardımcı olur.
            </p>

            <h2 class="text-xl font-semibold text-[#9B51E0] mt-6 mb-2">
                📌 Ne Yapabilirsiniz?
            </h2>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li>
                    Risk Tahmini Formunu doldurarak yapay zekadan sağlık analizi
                    alabilirsiniz.
                </li>
                <li>
                    AI destekli sohbet asistanı ile merak ettiklerinizi
                    konuşabilirsiniz.
                </li>
                <li>
                    Geçmiş tahminlerinizi ve sonuçlarınızı sonuç sayfanızda
                    görebilirsiniz.
                </li>
            </ul>

            <h2 class="text-xl font-semibold text-[#9B51E0] mt-6 mb-2">
                ℹ️ Nasıl Kullanılır?
            </h2>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li>
                    Anasayfadan tahmin formuna giderek gerekli bilgileri
                    doldurun.
                </li>
                <li>
                    Sonuç ekranında risk seviyenizi ve önerileri görüntüleyin.
                </li>
                <li>Sohbet bölümünden doktor asistanına sorular yöneltin.</li>
                <li>Geçmiş ekranından tüm tahminlerinize ulaşabilirsiniz.</li>
            </ul>

            <p class="text-gray-600 mt-8 italic text-sm">
                Not: Bu sistem yalnızca bilgilendirme amaçlıdır, kesin tanı için
                doktorunuza danışın.
            </p>
        </div>
    </AuthenticatedLayout>
</template>
