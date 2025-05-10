<script setup>
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
const breadcrumbs = ref([
    {
        title: "Yardım Talepleri",
        route: route("help-disease.index"),
    },
    {
        title: "Talep Detay Görüntüle",
    },
]);

const { props } = usePage();
console.log(props);
</script>

<template>
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4 space-y-6">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div>
                    <Title text="Talep Detay Görüntüle" />
                    <div class="mt-1 text-sm text-gray-500">
                        Oluşturulma Tarihi :
                        {{ $dayjs(props.help.created_at).format("DD/MM/YYYY") }}
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6">
                <!-- Doctor Details -->
                <div
                    class="bg-white border border-gray-200 rounded-lg shadow-md p-6"
                >
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        Doktor Bilgileri
                    </h3>
                    <p class="text-gray-700">
                        <strong>Cinsiyet:</strong>
                        {{ props.help.doctor.gender }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Ad Soyad:</strong> {{ props.help.doctor.name }}
                        {{ props.help.doctor.surname }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Uzmanlık:</strong>
                        {{ props.help.doctor.specialization }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Deneyim Süresi:</strong>
                        {{ props.help.doctor.years_of_experience }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Çalıştığı Kurum:</strong>
                        {{ props.help.doctor.clinic_name }}
                    </p>
                    <p class="text-gray-700">
                        <strong>İl:</strong> {{ props.help.doctor.city }}
                    </p>
                    <p class="text-gray-700">
                        <strong>İlçe:</strong> {{ props.help.doctor.district }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Adres:</strong> {{ props.help.doctor.address }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Danışmanlık Ücreti:</strong>
                        {{ props.help.doctor.consultation_price }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Puanı:</strong>
                        {{ props.help.doctor.ratings }}
                    </p>
                </div>

                <!-- Patient Details -->
                <div
                    class="bg-white border border-gray-200 rounded-lg shadow-md p-6"
                >
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        Hasta Bilgileri
                    </h3>
                    <p class="text-gray-700">
                        <strong>Ad Soyad:</strong>
                        {{ props.help.patient.name }}
                        {{ props.help.patient.surname }}
                    </p>
                    <p class="text-gray-700">
                        <strong>E-posta:</strong> {{ props.help.patient.email }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Telefon:</strong> {{ props.help.patient.phone }}
                    </p>
                </div>
            </div>

            <!-- Complaint Description -->
            <div
                class="bg-white border border-gray-200 rounded-lg shadow-md p-6"
            >
                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                    Şikayet Açıklaması
                </h3>
                <p class="text-gray-700">
                    {{ props.help.complaint_description }}
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
