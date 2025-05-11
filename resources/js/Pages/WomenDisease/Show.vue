<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { AlertCircle, Brain, Hospital } from "lucide-vue-next";
import { computed, onMounted, ref } from "vue";
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
        title: "Kadın Hastalıkları Kayıtlarınız",
        route: route("women-disease.index"),
    },
    {
        title: "Kadın Hastalıkları Kaydı Görüntüle",
    },
]);

import { GoogleGenAI } from "@google/genai";

const userMessage = ref("");
const messages = ref([
  { sender: "ai", text: "Merhaba! Kadın hastalıklarıyla ilgili nasıl yardımcı olabilirim?" },
]);
const loading = ref(false);

// DİKKAT: Güvenlik için bu anahtar frontend'de kullanılmamalı!
const ai = new GoogleGenAI({ apiKey: "AIzaSyAmX3uDh6iagPmtQTNdc7op08IjUfbIn4M" });

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
        systemInstruction: "Sen bir kadın hastalıkları uzmanı gibi cevap ver.",
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
        return JSON.parse(props.womenDisease.description);
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
    <Head title="Kadın Hastalıkları Kaydı Görüntüle" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4 space-y-6">
            <!-- Üst başlık ve buton -->
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div>
                    <Title text="Kadın Hastalıkları Kaydı Görüntüle" />
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
                                Sohbet
                            </Button>
                        </SheetTrigger>
                        <SheetContent class="flex flex-col h-full">
                            <SheetHeader>
                                <SheetTitle>Sohbet</SheetTitle>
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

            <!-- Sonuç Kartı -->
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
            <div
                class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 dark:bg-gray-900 dark:border-gray-700"
            >
                <h2 class="text-2xl font-bold text-red-600 mb-4">
                    Olası Tanı Sonucu
                </h2>
                <div class="text-lg font-semibold">
                    {{ props.womenDisease.result }}
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
                <h3 class="text-xl font-bold mb-4">
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
                                HPV Enfeksiyonunuz Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{ props.womenDisease.hpv ? "Evet" : "Hayır" }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Sigara Kullanıyor Musunuz?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.cigarette
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Erken Yaşta Cinsel İlişkiniz Oldu Mu?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.early_sexual
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Cinsel İlişki Sonrası Kanamanız Oluyor Mu?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.sexual_blood
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Kötü Kokulu Akıntınız Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.bad_smell_stream
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                İdrarda Kanamanız Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.urine_blood
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Ödeminiz Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.edema ? "Evet" : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Birden Çok Gebelik Geçirdiniz Mi?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.more_pregnancy
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Adet Kanamanızda Anormallikler (Yoğunlaşma,
                                Arada bir kanama, Uzun ve fazla olması) Var Mı
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.adet_blood
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Kasık - Belde Basınç Hissi Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.pressure
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Menepoz Sonrası Kanamalarınız Oluyor Mu?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.menepoz_blood
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>

                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                Menepoza Geç Girdiniz Mi?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.late_menepoz
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                (Fazla kilolu - Diyabet - Polikistik Over
                                Sendromu - Daha önce doğum yapmayan) Kaç Tanesi
                                Sizi Tanımlıyor
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.special_1
                                        ? "Evet"
                                        : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b ">
                            <td class="py-2 px-4 font-medium capitalize">
                                (İdrar yaparken ağrı, Çok idrar yapma, Ani
                                sıkışma hissi, Kanlı idrar, Kötü koku idrar
                                yapma) Kaç Tanesi Sizi Tanımlıyor
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.special_2
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
