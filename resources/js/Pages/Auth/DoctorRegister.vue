<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Label from "@/components/ui/label/Label.vue";
import Input from "@/components/ui/input/Input.vue";
import Button from "@/components/ui/button/Button.vue";
import { Eye, EyeOff } from "lucide-vue-next";
import { ref } from "vue";
import Title from "@/Components/Title.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import Textarea from "@/components/ui/textarea/Textarea.vue";
const form = useForm({
    gender: '',
    name: "",
    surname: "",
    email: "",
    specialization: "",
    years_of_experience: "",
    clinic_name: "",
    city: "",
    district: "",
    address: "",
    consultation_price: "",
    description: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("doctor-register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
const showPassword = ref(false);
const showPasswordRePassword = ref(false);
</script>

<template>
    <Head title="Kayıt Ol"/>
    <GuestLayout>
        <div class="mb-3 text-center">
            <Title text="Doktor Olarak Kaydol" />
        </div>
        <form @submit.prevent="submit">
            <div class="">
                <FormField name="username">
                    <FormItem>
                        <FormLabel
                            >Cinsiyet
                            <span class="text-red-500">*</span></FormLabel
                        >
                        <FormControl>
                            <Select v-model="form.gender">
                                <SelectTrigger>
                                    <SelectValue placeholder="Cinsiyet Seç" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Cinsiyet</SelectLabel>
                                        <SelectItem value="kadin">
                                            Kadın
                                        </SelectItem>
                                        <SelectItem value="erkek">
                                            Erkek
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <InputError
                            class="mt-2"
                            :message="form.errors.gender"
                        />
                    </FormItem>
                </FormField>
            </div>
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div class="mt-4">
                    <Label>İsim <span class="text-red-500">*</span></Label>
                    <Input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="mt-4">
                    <Label>Soyisim <span class="text-red-500">*</span></Label>

                    <Input
                        id="surname"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.surname"
                        autofocus
                        autocomplete="surname"
                    />

                    <InputError class="mt-2" :message="form.errors.surname" />
                </div>
            </div>
            <div class="mt-4">
                <Label>E-posta <span class="text-red-500">*</span></Label>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div class="mt-4">
                    <FormField name="username">
                        <FormItem>
                            <FormLabel
                                >Uzmanlık Alanı
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.specialization">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Uzmanlık Alanı Seç"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel
                                                >Uzmanlık Alanı</SelectLabel
                                            >
                                            <SelectItem
                                                value="Kadın Hastalıkları"
                                            >
                                                Kadın Hastalıkları
                                            </SelectItem>
                                            <SelectItem value="Dermatoloji">
                                                Dermatoloji
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="mt-2"
                                :message="form.errors.specialization"
                            />
                        </FormItem>
                    </FormField>
                </div>

                <div class="mt-4">
                    <FormField name="username">
                        <FormItem>
                            <FormLabel
                                >Deneyim Yılı
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Select v-model="form.years_of_experience">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Deneyim Yılı Seç"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel
                                                >Deneyim Yılı</SelectLabel
                                            >
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
                                            <SelectItem value="+5">
                                                +5
                                            </SelectItem>
                                            <SelectItem value="+10">
                                                +10
                                            </SelectItem>
                                            <SelectItem value="+15">
                                                +15
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="mt-2"
                                :message="form.errors.years_of_experience"
                            />
                        </FormItem>
                    </FormField>
                </div>
            </div>

            <div class="mt-4">
                <Label
                    >Çalıştığınız Hastane Adı veya Klinik Adı
                    <span class="text-red-500">*</span></Label
                >
                <Input
                    id="clinic_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.clinic_name"
                    autofocus
                    autocomplete="clinic_name"
                />

                <InputError class="mt-2" :message="form.errors.clinic_name" />
            </div>
            <div class="mt-4">
                <Label
                    >Danışma Ücreti
                    <span class="text-red-500">*</span></Label
                >
                <Input
                    id="consultation_price"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.consultation_price"
                    autofocus
                    autocomplete="consultation_price"
                />

                <InputError class="mt-2" :message="form.errors.consultation_price" />
            </div>
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div class="mt-4">
                    <Label>İl <span class="text-red-500">*</span></Label>
                    <Input
                        id="city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.city"
                        autofocus
                        autocomplete="city"
                    />

                    <InputError class="mt-2" :message="form.errors.city" />
                </div>

                <div class="mt-4">
                    <Label>İlçe <span class="text-red-500">*</span></Label>
                    <Input
                        id="district"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.district"
                        autofocus
                        autocomplete="district"
                    />

                    <InputError class="mt-2" :message="form.errors.district" />
                </div>
            </div>
            <div class="mt-4">
                <Label>Adres <span class="text-red-500">*</span></Label>
                <Textarea
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    autofocus
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div class="mt-4">
                <Label
                    >Özgeçmiş (Açıklama)
                    <span class="text-red-500">*</span></Label
                >

                <Textarea
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    maxlength="1000"
                    autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="mt-4">
                <Label>Şifre <span class="text-red-500">*</span></Label>

                <div class="relative">
                    <Input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        autocomplete="new-password"
                    />
                    <span
                        class="absolute right-0 top-0 flex size-10 items-center justify-center"
                    >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            :aria-label="
                                showPassword
                                    ? 'Parolayı gizle'
                                    : 'Parolayı göster'
                            "
                            class="text-muted-foreground hover:text-primary"
                        >
                            <EyeOff size="18" v-if="showPassword" />
                            <Eye size="18" v-else />
                        </button>
                    </span>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <Label>Şifre Tekrar <span class="text-red-500">*</span></Label>

                <div class="relative">
                    <Input
                        id="password_confirmation"
                        :type="showPasswordRePassword ? 'text' : 'password'"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        autocomplete="new-password"
                    />

                    <span
                        class="absolute right-0 top-0 flex size-10 items-center justify-center"
                    >
                        <button
                            type="button"
                            @click="
                                showPasswordRePassword = !showPasswordRePassword
                            "
                            :aria-label="
                                showPasswordRePassword
                                    ? 'Parolayı gizle'
                                    : 'Parolayı göster'
                            "
                            class="text-muted-foreground hover:text-primary"
                        >
                            <EyeOff size="18" v-if="showPasswordRePassword" />
                            <Eye size="18" v-else />
                        </button>
                    </span>
                </div>

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex flex-col items-center justify-center">
                <Button
                    processbutton
                    class="w-full mb-5"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Kayıt Ol
                </Button>
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-[#9B51E0] underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Zaten kayıtlı mısın?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
