<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import Label from "@/components/ui/label/Label.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { MessageCircle } from "lucide-vue-next";
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
    <Head title="Talep Detay Görüntüle" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-6 space-y-8">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6">
                <div>
                    <Title text="Talep Detay Görüntüle" />
                    <div class="mt-2 text-sm text-gray-600">
                        Oluşturulma Tarihi :
                        {{ $dayjs(props.help.created_at).format("DD/MM/YYYY") }}
                    </div>
                </div>
                <div
                    v-if="props.help.status"
                    class="flex lg:justify-end md:justify-end justify-start items-center"
                >
                    <Link :href="route('help-message.show', props.help.id)"
                        ><Button processbutton>
                            <MessageCircle /> Mesajlaş</Button
                        ></Link
                    >
                </div>
                <div
                    class="flex lg:justify-end md:justify-end justify-start items-center text-sm font-semibold"
                    v-else
                >
                    Doktor Onayı Beklenmektedir
                </div>
            </div>

            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-8">
                <!-- Doctor Details -->
                <div
                    class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6"
                >
                    <h3 class="text-lg font-bold text-gray-700 mb-4">
                        Doktor Bilgileri
                    </h3>
                    <ul class="space-y-3">
                        <li class="text-gray-600">
                            <strong>Cinsiyet:</strong>
                            {{ props.help.doctor.gender }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Ad Soyad:</strong>
                            {{ props.help.doctor.name }}
                            {{ props.help.doctor.surname }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Uzmanlık:</strong>
                            {{ props.help.doctor.specialization }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Deneyim Süresi:</strong>
                            {{ props.help.doctor.years_of_experience }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Çalıştığı Kurum:</strong>
                            {{ props.help.doctor.clinic_name }}
                        </li>
                        <li class="text-gray-600">
                            <strong>İl:</strong> {{ props.help.doctor.city }}
                        </li>
                        <li class="text-gray-600">
                            <strong>İlçe:</strong>
                            {{ props.help.doctor.district }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Adres:</strong>
                            {{ props.help.doctor.address }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Danışmanlık Ücreti:</strong>
                            {{ props.help.doctor.consultation_price }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Puanı:</strong>
                            {{ props.help.doctor.ratings }}
                        </li>
                    </ul>
                </div>

                <!-- Patient Details -->
                <div
                    class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6"
                >
                    <h3 class="text-lg font-bold text-gray-700 mb-4">
                        Hasta Bilgileri
                    </h3>
                    <ul class="space-y-3">
                        <li class="text-gray-600">
                            <strong>Ad Soyad:</strong>
                            {{ props.help.patient.name }}
                            {{ props.help.patient.surname }}
                        </li>
                        <li class="text-gray-600">
                            <strong>E-posta:</strong>
                            {{ props.help.patient.email }}
                        </li>
                        <li class="text-gray-600">
                            <strong>Telefon:</strong>
                            {{ props.help.patient.phone }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Complaint Description -->
            <div
                class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6"
            >
                <h3 class="text-lg font-bold text-gray-700 mb-4">
                    Şikayet Açıklaması
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ props.help.complaint_description }}
                </p>
            </div>

            <div v-if="props.help.doctor_description">
                <div class="mt-4">
                    <Label
                        >Doktor Önerisi
                        <span class="text-red-500">*</span></Label
                    >
                    <Textarea
                        id="address"
                        type="text"
                        class="mt-1 block w-full !opacity-100 !cursor-default"
                        v-model="props.help.doctor_description"
                        placeholder="Doktor Önerisi"
                        autofocus
                        autocomplete="address"
                        :disabled="props.help.doctor_description"
                        rows="9"
                        maxlength="1000"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
