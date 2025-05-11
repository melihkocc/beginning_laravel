<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { AlertCircle, Brain, Hospital } from "lucide-vue-next";
import { computed, ref } from "vue";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/components/ui/sheet";
const breadcrumbs = ref([
    {
        title: "Cinsel Hastalık Kayıtlarınız",
        route: route("sexually-disease.index"),
    },
    {
        title: "Cinsel Hastalık Kaydı Görüntüle",
    },
]);

import { GoogleGenAI } from "@google/genai";

const userMessage = ref("");
const messages = ref([
    {
        sender: "ai",
        text: "Merhaba! Kadın hastalıklarıyla ilgili nasıl yardımcı olabilirim?",
    },
]);
const loading = ref(false);

// DİKKAT: Güvenlik için bu anahtar frontend'de kullanılmamalı!
const ai = new GoogleGenAI({
    apiKey: "AIzaSyAmX3uDh6iagPmtQTNdc7op08IjUfbIn4M",
});

const sendMessage = async () => {
    const content = userMessage.value.trim();
    if (!content) return;

    // Kullanıcı mesajını ekle
    messages.value.push({ sender: "user", text: content });
    userMessage.value = "";
    loading.value = true;

    try {
        const response = await ai.models.generateContent({
            model: "gemini-2.0-flash",
            contents: content,
            config: {
                systemInstruction:
                    "Sen bir kadın hastalıkları uzmanı gibi cevap ver.",
            },
        });

        messages.value.push({
            sender: "ai",
            text: response.text || "Yanıt alınamadı.",
        });
    } catch (error) {
        messages.value.push({
            sender: "ai",
            text: "Bir hata oluştu. Lütfen tekrar deneyin.",
        });
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const { props } = usePage();
console.log(props);

const parsedDescriptionData = computed(() => {
    try {
        return JSON.parse(props.sexuallyDisease.description);
    } catch (e) {
        console.error("JSON parsing error:", e);
        return [];
    }
});

const formatAnswer = (value) => {
    if (typeof value === "boolean") {
        return value ? "Evet" : "Hayır";
    }
    if (value === null || value === undefined || value === "") {
        return "Belirtilmedi";
    }
    return value.toString();
};
</script>
<template>
    <Head title="Cinsel Hastalık Kaydı Görüntüle" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4 space-y-6">
            <!-- Üst başlık ve buton -->
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div>
                    <Title text="Cinsel Hastalık Kaydı Görüntüle" />
                </div>
                <div
                    v-if="props.auth.user.plan != 'doctor'"
                    class="flex lg:justify-end md:justify-end justify-start items-center"
                >
                    <Link :href="route('find-doctor.index')">
                        <Button processbutton>
                            <Hospital class="w-4 h-4" /> Uzman Yardım Al
                        </Button>
                    </Link>
                    <Sheet>
                        <SheetTrigger>
                            <Button class="ms-3" processbutton>
                                <Brain class="w-4 h-4" />
                                AI Sohbet
                            </Button>
                        </SheetTrigger>
                        <SheetContent class="flex flex-col h-full">
                            <SheetHeader>
                                <SheetTitle>AI Sohbet</SheetTitle>
                                <SheetDescription>
                                    Kadın hastalıkları hakkında sorularınızı
                                    sorabilirsiniz.
                                </SheetDescription>
                            </SheetHeader>

                            <!-- Sohbet Geçmişi -->
                            <div
                                class="flex-1 overflow-y-auto mt-4 px-2 space-y-3"
                            >
                                <div
                                    v-for="(msg, index) in messages"
                                    :key="index"
                                    :class="
                                        msg.sender === 'user'
                                            ? 'text-right'
                                            : 'text-left'
                                    "
                                >
                                    <div
                                        :class="[
                                            'inline-block px-4 py-2 rounded-lg max-w-[80%]',
                                            msg.sender === 'user'
                                                ? 'bg-blue-500 text-white ml-auto'
                                                : 'bg-gray-200 text-black mr-auto',
                                        ]"
                                    >
                                        {{ msg.text }}
                                    </div>
                                </div>
                                <div
                                    v-if="loading"
                                    class="text-center text-gray-500 text-sm"
                                >
                                    Yazıyor...
                                </div>
                            </div>

                            <!-- Mesaj Yazma Alanı -->
                            <div class="flex items-center gap-2 p-2 border-t">
                                <textarea
                                    v-model="userMessage"
                                    rows="1"
                                    placeholder="Mesajınızı yazın..."
                                    class="flex-1 resize-none border rounded px-3 py-2 dark:text-black"
                                    @keyup.enter.exact.prevent="sendMessage"
                                ></textarea>
                                <Button
                                    processbutton
                                    :disabled="loading || !userMessage.trim()"
                                    @click="sendMessage"
                                >
                                    Gönder
                                </Button>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>
            </div>

            <Alert variant="destructive">
                <AlertCircle class="h-4 w-4" />
                <AlertTitle>Dikkat</AlertTitle>
                <AlertDescription>
                    Bu analiz, yapay zeka tarafından bilgilendirme amacıyla
                    oluşturulmuştur. Tıbbi tavsiye, teşhis veya tedavi yerine
                    geçmez. Herhangi bir sağlık sorununuzda lütfen doktorunuza
                    veya yetkili bir sağlık uzmanına danışın.
                </AlertDescription>
            </Alert>
            <!-- Sonuç Kartı -->
            <div
                class="bg-white dark:bg-gray-900 dark:border-gray-700 text-black dark:text-white shadow-xl rounded-2xl p-6 border border-gray-200"
            >
                <h2 class="text-2xl font-bold text-red-600 mb-4">
                    Olası Tanı Sonucu
                </h2>
                <div class="text-lg font-semibold">
                    {{ props.sexuallyDisease.result }}
                </div>
            </div>

            <!-- Açıklamalar Listesi -->
            <div
                class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 dark:bg-gray-900 dark:border-gray-700"
            >
                <h3 class="text-xl font-bold mb-4">
                    Açıklamalar
                </h3>
                <ul class="list-disc list-inside space-y-2">
                    <li
                        v-for="(item, index) in parsedDescriptionData"
                        :key="index"
                    >
                        {{ item }}
                    </li>
                </ul>
            </div>
            <div
                class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 dark:bg-gray-900 dark:border-gray-700"
            >
                <h3 class="text-xl font-bold  mb-4">
                    Form Verileri
                </h3>
                <table
                    class="w-full table-auto text-left border-t border-gray-300"
                >
                    <thead>
                        <tr class="uppercase text-sm border-b">
                            <th class="py-2 px-4">Soru</th>
                            <th class="py-2 px-4">Cevap</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Yaş
                            </td>
                            <td class="py-2 px-4">
                                {{ props.sexuallyDisease.age }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Akıntınız Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.stream
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Akıntı Fazla Miktarda Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.is_more_stream
                                        ? "Evet"
                                        : props.sexuallyDisease
                                              .is_more_stream == null
                                        ? "Emin Değiim"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Kokuyu Tarif Edin?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.smell == "kokusuz"
                                        ? "Kokusuz"
                                        : "Kötü Kokulu"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Akıntı Rengi Nasıl?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.color == "sariyesil"
                                        ? "Sarı-Yeşil"
                                        : props.sexuallyDisease.color ==
                                          "beyazsari"
                                        ? "Beyaz - Sarı"
                                        : "Şeffaf ve Jelimsi Kıvamda"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Ödeminiz Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.edema
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                İdrar Yaparken Yanma Hissediyor Musunuz?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.burning_urine
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Kaşıntı veya Yanma Hissiniz Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.itching_or_burning
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Düzgün Kenarlı Ağrısız Sert Yuvarlak Cilt
                                Lezyonu (Şankr) Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.sankr
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Lenf Nodlarınızda Şişme Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.lenf_node
                                        ? "Evet"
                                        : props.sexuallyDisease.lenf_node ==
                                          null
                                        ? "Bilmiyorum"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Nemli Bölgelerinizde Plak veya Döküntü Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.plaque_rash
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>

                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                İdrar Yapma İhtiyacı Hissedip İdrarınız
                                Yapamadığınız Oluyor Mu?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.need_to_urinate
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Ağrı Hassasiyet ve Genital Bölgenizde İçi Sıvı
                                Dolu Kabarcıklar (vezikül) Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.sexuallyDisease.vezikul
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
