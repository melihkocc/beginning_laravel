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

const form = useForm({
    name: "",
    surname: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
const showPassword = ref(false);
const showPasswordRePassword = ref(false);

</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <Label>İsim</Label>
                <Input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="mt-4">
                <Label>Soyisim</Label>

                <Input
                    id="surname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.surname"
                    required
                    autofocus
                    autocomplete="surname"
                />

                <InputError class="mt-2" :message="form.errors.surname" />
            </div>
            <div class="mt-4">
                <Label>E-posta</Label>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <Label>Şifre</Label>

                <div class="relative">
                    <Input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
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
                <Label>Şifre Tekrar</Label>

                <div class="relative">
                    <Input
                        id="password_confirmation"
                        :type="showPasswordRePassword ? 'text' : 'password'"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <span
                        class="absolute right-0 top-0 flex size-10 items-center justify-center"
                    >
                        <button
                            type="button"
                            @click="showPasswordRePassword = !showPasswordRePassword"
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
                    class="w-full mb-5"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Kayıt Ol
                </Button>
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Zaten kayıtlı mısın?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
