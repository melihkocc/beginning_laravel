<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { SaveIcon } from "lucide-vue-next";
import { ref } from "vue";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
} from "@/components/ui/form";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import InputError from "@/Components/InputError.vue";
import { string } from "zod";

const breadcrumbs = ref([
    {
        title: "Kadın Hastalıkları Kayıtlarınız",
        route: route("women-disease.index"),
    },
    {
        title: "Kadın Hastalıkları Kaydı Oluştur",
    },
]);

const form = useForm({
    hpv: "",
    cigarette: "",
    early_sexual: "",
    sexual_blood: "",
    bad_smell_stream: "",
    urine_blood: "",
    edema: "",
    more_pregnancy: "",
    adet_blood: "",
    pressure: "",
    menepoz_blood: "",
    late_menepoz: "",
    special_1: "",
    special_2: "",
});

const submit = () => {
    form.age = String(form.age);
    form.post(route("women-disease.store"));
};
</script>

<template>
    <Head title="Kadın Hastalıkları Kaydı Oluştur" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div class="text-start">
                    <Title text="Kadın Hastalıkları Kaydı Oluştur" />
                </div>
                <div
                    class="flex lg:justify-end md:justify-end justify-start items-center"
                >
                    <Button @click="submit" processbutton
                        ><SaveIcon /> Kaydet</Button
                    >
                </div>
            </div>
            <Form class="space-y-4">
                <div
                    class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5"
                >
                    <FormField name="hpv">
                        <FormItem>
                            <FormLabel
                                >HPV Enfeksiyonunuz Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.hpv">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.hpv"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="cigarette">
                        <FormItem>
                            <FormLabel
                                >Sigara Kullanıyor Musunuz?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.cigarette">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.cigarette"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="early_sexual">
                        <FormItem>
                            <FormLabel
                                >Erken Yaşta Cinsel İlişkiniz Oldu Mu?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.early_sexual">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0"
                                                >Hayır</SelectItem
                                            >
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.early_sexual"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="sexual_blood">
                        <FormItem>
                            <FormLabel
                                >Cinsel İlişki Sonrası Kanamanız Oluyor Mu?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.sexual_blood">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0"
                                                >Hayır</SelectItem
                                            >
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.sexual_blood"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="bad_smell_stream">
                        <FormItem>
                            <FormLabel
                                >Kötü Kokulu Akıntınız Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.bad_smell_stream">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0"
                                                >Hayır</SelectItem
                                            >
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.bad_smell_stream"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="urine_blood">
                        <FormItem>
                            <FormLabel
                                >İdrarda Kanamanız Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.urine_blood">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.urine_blood"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="edema">
                        <FormItem>
                            <FormLabel
                                >Ödeminiz Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.edema">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.edema"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="more_pregnancy">
                        <FormItem>
                            <FormLabel
                                >Birden Çok Gebelik Geçirdiniz Mi?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.more_pregnancy">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.more_pregnancy"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="adet_blood">
                        <FormItem>
                            <FormLabel
                                >Adet Kanamanızda Anormallikler (yoğunlaşma,
                                arada bir kanama, uzun ve fazla olması) Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.adet_blood">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.adet_blood"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="pressure">
                        <FormItem>
                            <FormLabel
                                >Kasık - Belde Basınç Hissi Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.pressure">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.pressure"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="menepoz_blood">
                        <FormItem>
                            <FormLabel
                                >Menepoz Sonrası Kanamalarınız Oluyor Mu?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.menepoz_blood">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.menepoz_blood"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="late_menepoz">
                        <FormItem>
                            <FormLabel
                                >Menepoza Geç Mi Girdiniz Mi?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.late_menepoz">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="1">
                                                Evet
                                            </SelectItem>
                                            <SelectItem value="0">
                                                Hayır
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.late_menepoz"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="special_1">
                        <FormItem>
                            <FormLabel
                                >(Fazla kilolu - Diyabet - Polikistik Over
                                Sendromu - Daha önce doğum yapmayan) Kaç tanesi
                                sizi tanımlıyor
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.special_1">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="0">
                                                0
                                            </SelectItem>
                                            <SelectItem value="1">
                                                1
                                            </SelectItem>
                                            <SelectItem value="2">
                                                2
                                            </SelectItem>
                                            <SelectItem value="3">
                                                3
                                            </SelectItem>
                                            <SelectItem value="4">
                                                4
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.special_1"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="special_2">
                        <FormItem>
                            <FormLabel
                                >(İdrar yaparken ağrı, Çok idrar yapma, Ani
                                sıkışma hissi, Kanlı İdrar, Kötü koku idrar
                                yapma) Kaç Tanesi Sizi Tanımlıyor
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.special_2">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="0">
                                                0
                                            </SelectItem>
                                            <SelectItem value="1">
                                                1
                                            </SelectItem>
                                            <SelectItem value="2">
                                                2
                                            </SelectItem>
                                            <SelectItem value="3">
                                                3
                                            </SelectItem>
                                            <SelectItem value="4">
                                                4
                                            </SelectItem>
                                            <SelectItem value="5">
                                                5
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.special_2"
                            />
                        </FormItem>
                    </FormField>
                </div>
            </Form>
        </div>
    </AuthenticatedLayout>
</template>
