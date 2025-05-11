<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import Label from "@/components/ui/label/Label.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { Calendar, MessageCircle } from "lucide-vue-next";
import { ref, watch } from "vue";
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/components/ui/sheet";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
} from "@/components/ui/form";

import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { useDarkModeStore } from "@/stores/dark-mode";

const breadcrumbs = ref([
    {
        title: "Yardım Talepleri",
        route: route("help-disease.index"),
    },
    {
        title: "Talep Detay Görüntüle",
    },
]);

const format = (date) => {
    const day = date.getDate().toString().padStart(2, "0");
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, "0");
    const minutes = date.getMinutes().toString().padStart(2, "0");

    return `${day}/${month}/${year} ${hours}:${minutes}`;
};

const parseValue = (value) => {
    return new Date(value);
};

const darkModeStore = useDarkModeStore();
const isDark = ref(darkModeStore.darkMode === "light" ? false : true);

watch(
    () => darkModeStore.darkMode,
    (newMode) => {
        if (newMode === "dark") {
            isDark.value = true;
        } else if (newMode === "light") {
            isDark.value = false;
        } else {
            isDark.value = true;
        }
    }
);

const { props } = usePage();
console.log(props);

const meetForm = useForm({
    meeting_date: "",
});

const meetModal = ref(false);

const meet = () => {
    meetModal.value = false;
    meetForm.post(route("help-meeting.store", props.help.id), {
        onSuccess: () => {
            meetForm.reset();
            meetModal.value = false;
        },
        onError: () => {
            console.log("error");
        },
    });
};
</script>

<template>
    <Head title="Talep Detay Görüntüle" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-6 space-y-8">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6">
                <div>
                    <Title text="Talep Detay Görüntüle" />
                    <div class="mt-2 text-sm">
                        Oluşturulma Tarihi :
                        {{ $dayjs(props.help.created_at).format("DD/MM/YYYY") }}
                    </div>
                </div>
                <div
                    class="flex items-center lg:justify-end md:justify-end justify-start gap-5"
                >
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
                    <div
                        v-if="
                            props.help.status &&
                            (props.help.meeting_status == 'Reddedildi' ||
                                props.help.meeting_status == 'Tamamlandı' ||
                                props.help.meeting_status == null)
                        "
                        class="flex lg:justify-end md:justify-end justify-start items-center"
                    >
                        <Sheet>
                            <SheetTrigger>
                                <Button processbutton
                                    ><Calendar /> Randevu Al</Button
                                >
                            </SheetTrigger>
                            <SheetContent>
                                <SheetHeader>
                                    <SheetTitle>Randevu Al</SheetTitle>
                                    <SheetDescription>
                                        {{ props.help.doctor.name }}
                                        {{ props.help.doctor.surname }} adlı
                                        doktordan randevu alıyorsunuz.
                                    </SheetDescription>
                                    <div>
                                        <Label>Randevu Zamanı</Label>
                                        <VueDatePicker
                                            v-model="meetForm.meeting_date"
                                            :select-text="'Seç'"
                                            :cancel-text="'İptal'"
                                            :locale="'tr'"
                                            :enable-time="true"
                                            :enable-date="true"
                                            :time-format="24"
                                            :format="format"
                                            :parse-value="parseValue"
                                            :dark="isDark"
                                            placeholder="Anımsatıcı Tarihi"
                                            :min-date="
                                                new Date().setHours(0, 0, 0, 0)
                                            "
                                        ></VueDatePicker>
                                    </div>
                                    <Button
                                        @click="meet"
                                        class="mt-3"
                                        processbutton
                                    >
                                        <Calendar /> Randevu Al</Button
                                    >
                                </SheetHeader>
                            </SheetContent>
                        </Sheet>
                    </div>
                    <div
                        class="flex lg:justify-end md:justify-end justify-start items-center text-sm font-semibold"
                        v-else
                    >
                        Randevu için Doktor Onayı Beklenmektedir
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-8">
                <!-- Doctor Details -->
                <div
                    class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6 dark:bg-gray-900 dark:border-gray-700"
                >
                    <h3 class="text-lg font-bold mb-4">Doktor Bilgileri</h3>
                    <ul class="space-y-3">
                        <li class="">
                            <strong>Cinsiyet:</strong>
                            {{ props.help.doctor.gender }}
                        </li>
                        <li class="">
                            <strong>Ad Soyad:</strong>
                            {{ props.help.doctor.name }}
                            {{ props.help.doctor.surname }}
                        </li>
                        <li class="">
                            <strong>Uzmanlık:</strong>
                            {{ props.help.doctor.specialization }}
                        </li>
                        <li class="">
                            <strong>Deneyim Süresi:</strong>
                            {{ props.help.doctor.years_of_experience }}
                        </li>
                        <li class="">
                            <strong>Çalıştığı Kurum:</strong>
                            {{ props.help.doctor.clinic_name }}
                        </li>
                        <li class="">
                            <strong>İl:</strong> {{ props.help.doctor.city }}
                        </li>
                        <li class="">
                            <strong>İlçe:</strong>
                            {{ props.help.doctor.district }}
                        </li>
                        <li class="">
                            <strong>Adres:</strong>
                            {{ props.help.doctor.address }}
                        </li>
                        <li class="">
                            <strong>Danışmanlık Ücreti:</strong>
                            {{ props.help.doctor.consultation_price }}
                        </li>
                        <li class="">
                            <strong>Puanı:</strong>
                            {{ props.help.doctor.ratings }}
                        </li>
                    </ul>
                </div>

                <!-- Patient Details -->
                <div
                    class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6 dark:bg-gray-900 dark:border-gray-700"
                >
                    <h3 class="text-lg font-bold mb-4">Hasta Bilgileri</h3>
                    <ul class="space-y-3">
                        <li class="">
                            <strong>Ad Soyad:</strong>
                            {{ props.help.patient.name }}
                            {{ props.help.patient.surname }}
                        </li>
                        <li class="">
                            <strong>Cinsiyet:</strong>
                            {{
                                props.help.patient.gender == "erkek"
                                    ? "Erkek"
                                    : "Kadın"
                            }}
                        </li>
                        <li class="">
                            <strong>E-posta:</strong>
                            {{ props.help.patient.email }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Complaint Description -->
            <div
                class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6 dark:bg-gray-900 dark:border-gray-700"
            >
                <h3 class="text-lg font-bold mb-4">Şikayet Açıklaması</h3>
                <p class="leading-relaxed">
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
