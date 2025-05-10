<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { Hospital } from "lucide-vue-next";
import { computed, ref } from "vue";
const breadcrumbs = ref([
    {
        title: "Kadın Hastalıkları Kayıtlarınız",
        route: route("women-disease.index"),
    },
    {
        title: "Kadın Hastalıkları Kaydı Görüntüle",
    },
]);

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
                    class="flex lg:justify-end md:justify-end justify-start items-center"
                >
                    <Link :href="route('find-doctor.index')">
                        <Button processbutton>
                            <Hospital class="w-4 h-4 mr-2" /> Uzman Yardım Al
                        </Button>
                    </Link>
                </div>
            </div>

            <!-- Sonuç Kartı -->
            <div
                class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200"
            >
                <h2 class="text-2xl font-bold text-red-600 mb-4">
                    Olası Tanı Sonucu
                </h2>
                <div class="text-gray-700 text-lg font-semibold">
                    {{ props.womenDisease.result }}
                </div>
            </div>

            <!-- Açıklamalar Listesi -->
            <div
                class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200"
            >
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    Açıklamalar
                </h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li
                        v-for="(item, index) in parsedDescriptionData"
                        :key="index"
                    >
                        {{ item }}
                    </li>
                </ul>
            </div>
            <div
                class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200"
            >
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    Form Verileri
                </h3>
                <table
                    class="w-full table-auto text-left border-t border-gray-300"
                >
                    <thead>
                        <tr class="text-gray-600 uppercase text-sm border-b">
                            <th class="py-2 px-4">Soru</th>
                            <th class="py-2 px-4">Cevap</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 font-medium capitalize">
                                HPV Enfeksiyonunuz Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{ props.womenDisease.hpv ? "Evet" : "Hayır" }}
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 font-medium capitalize">
                                Ödeminiz Var Mı?
                            </td>
                            <td class="py-2 px-4">
                                {{
                                    props.womenDisease.edema ? "Evet" : "Hayır"
                                }}
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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

                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
                        <tr class="border-b hover:bg-gray-50">
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
