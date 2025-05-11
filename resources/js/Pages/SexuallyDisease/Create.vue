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
        title: "Cinsel Hastalık Kayıtlarınız",
        route: route("sexually-disease.index"),
    },
    {
        title: "Cinsel Hastalık Kaydı Oluştur",
    },
]);

const form = useForm({
    age: "",
    stream: "",
    is_more_stream: null,
    smell: "",
    color: "",
    edema: "",
    burning_urine: "",
    itching_or_burning: "",
    sankr: "",
    lenf_node: null,
    plaque_rash: "",
    vezikul: "",
    need_to_urinate: "",
});

const submit = () => {
    form.age = String(form.age);
    form.post(route("sexually-disease.store"));
};
</script>

<template>
    <Head title="Cinsel Hastalık Kaydı Oluştur" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div><Title text="Cinsel Hastalık Kaydı Oluştur" /></div>
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
                    <FormField name="age">
                        <FormItem>
                            <FormLabel
                                >Yaş
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Input
                                    type="number"
                                    id="age"
                                    placeholder="Yaş"
                                    v-model="form.age"
                                    required
                                    autofocus
                                    min="0"
                                />
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.age"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="stream">
                        <FormItem>
                            <FormLabel
                                >Akıntınız Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.stream">
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
                                :message="form.errors.stream"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="is_more_stream">
                        <FormItem>
                            <FormLabel
                                >Akıntı Fazla Miktarda mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.is_more_stream">
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
                                            <SelectItem :value="null">
                                                Emin Değilim
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.is_more_stream"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="smell">
                        <FormItem>
                            <FormLabel
                                >Kokuyu Tarif Edin?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.smell">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="kotukokulu">
                                                Kötü Kokulu
                                            </SelectItem>
                                            <SelectItem value="kokusuz"
                                                >Kokusuz</SelectItem
                                            >
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.smell"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="color">
                        <FormItem>
                            <FormLabel
                                >Akıntı Rengi Nasıl?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.color">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Seçiniz.." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="sariyesil">
                                                Sarı - Yeşil
                                            </SelectItem>
                                            <SelectItem value="beyazsari"
                                                >Beyaz - Sarı</SelectItem
                                            >
                                            <SelectItem value="seffaf">
                                                Şeffaf ve Jelimsi Kıvamda
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.color"
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
                    <FormField name="burning_urine">
                        <FormItem>
                            <FormLabel
                                >İdrar Yaparken Yanma Hissediyor Musunuz?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.burning_urine">
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
                                :message="form.errors.burning_urine"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="itching_or_burning">
                        <FormItem>
                            <FormLabel
                                >Kaşıntı veya yanma hissiniz var mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.itching_or_burning">
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
                                :message="form.errors.itching_or_burning"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="sankr">
                        <FormItem>
                            <FormLabel
                                >Düzgün Kenarlı Ağrısız Sert Yuvarlak Cilt
                                Lezyonu (Şankr) Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.sankr">
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
                                :message="form.errors.sankr"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="lenf_node">
                        <FormItem>
                            <FormLabel
                                >Lenf Nodlarınızda Şişme Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.lenf_node">
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
                                            <SelectItem :value="null">
                                                Bilmiyorum
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.lenf_node"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="plaque_rash">
                        <FormItem>
                            <FormLabel
                                >Nemli Bölgelerinizde Plak veya Döküntü Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.plaque_rash">
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
                                :message="form.errors.plaque_rash"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="need_to_urinate">
                        <FormItem>
                            <FormLabel
                                >İdrar Yapma İhtiyacı Hissedip İdrarınız
                                Yapamadığınız Oluyor Mu
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.need_to_urinate">
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
                                :message="form.errors.need_to_urinate"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="vezikul">
                        <FormItem>
                            <FormLabel
                                >Ağrı Hassasiyet ve Genital Bölgenizde İçi Sıvı
                                Dolu Kabarcıklar (Vezikül) Var Mı?
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.vezikul">
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
                                :message="form.errors.vezikul"
                            />
                        </FormItem>
                    </FormField>
                </div>
            </Form>
        </div>
    </AuthenticatedLayout>
</template>
