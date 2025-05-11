<script setup>
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center p-6">
        <h1 class="text-4xl font-bold text-[#9B51E0] mb-4">DoktorYanımda</h1>
        <h2 class="text-2xl text-gray-500 font-bold mb-4">Hoş Geldiniz</h2>
        <p class="text-lg text-gray-600 mb-8 text-center max-w-md">
            Uygulamamıza giriş yaparak veya kaydolarak daha fazla özelliğe
            erişebilirsiniz.
        </p>

        <div class="flex space-x-4 mb-10">
            <Link :href="route('login')">
                <button
                    class="px-6 py-3 bg-[#9B51E0] text-white rounded-xl hover:bg-[#7A3FB0] transition"
                >
                    Giriş Yap
                </button>
            </Link>
            <Link :href="route('register')">
                <button
                    class="px-6 py-3 bg-gray-300 text-gray-800 rounded-xl hover:bg-gray-400 transition"
                >
                    Kayıt Ol
                </button>
            </Link>
            <Link :href="route('doctor-register')">
                <button
                    class="px-6 py-3 bg-gray-300 text-gray-800 rounded-xl hover:bg-gray-400 transition"
                >
                    Doktor Kayıt
                </button>
            </Link>
        </div>

        <!-- Üyelik Planları -->
        <div class="grid md:grid-cols-3 gap-6 max-w-5xl w-full">
            <!-- Ücretsiz Plan -->
            <div>

            </div>
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <h2 class="text-xl font-bold text-[#9B51E0] mb-2">Ücretsiz</h2>
                <p class="text-gray-600 mb-4">₺50 / ay</p>
                <ul class="text-gray-500 text-sm mb-4 space-y-1">
                    <li>✔ Sınırlı analiz hakkı</li>
                    <li>✔ Temel raporlar</li>
                    <li>✘ Kişisel öneriler yok</li>
                </ul>
                <Link :href="route('register')">
                    <button
                        class="w-full py-2 bg-[#9B51E0] text-white rounded-xl hover:bg-[#7A3FB0] transition"
                    >
                        Başla
                    </button>
                </Link>
            </div>

        </div>
    </div>
</template>
