<script setup>
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, useForm } from "@inertiajs/vue3";
import { Input } from "@/components/ui/input";
import { Edit } from "lucide-vue-next";
import { inject, ref } from "vue";
const dayjs = inject("dayjs");
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
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
import Button from "@/components/ui/button/Button.vue";
import InputError from "@/Components/InputError.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
const { props } = usePage();
const breadcrumbs = ref([
    {
        title: "Kullanıcılar",
        route: route("users.index"),
    },
    {
        title: "Kullanıcı Düzenle",
    },
]);

const form = useForm({
    name: props.user.name,
    surname: props.user.surname,
    email: props.user.email,
    plan: props.user.plan,
    description: props.user.description,
});

const editUser = () => {
    form.patch(route("users.update", props.user.id));
};
</script>

<template>
    <Head title="Kullanıcı Düzenle" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div>
                    <Title text="Kullanıcı Düzenle" />
                    <div class="mt-1 text-sm text-gray-500">
                        Oluşturulma Tarihi :
                        {{ $dayjs(props.user.created_at).format("DD/MM/YYYY") }}
                    </div>
                </div>
                <div
                    class="flex lg:justify-end md:justify-end justify-start items-center gap-5"
                >
                    <Button @click="editUser" processbutton>
                        <Edit /> Düzenle</Button
                    >
                </div>
            </div>
            <Form class="mt-5" @submit="onSubmit">
                <div
                    class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5"
                >
                    <FormField name="username">
                        <FormItem>
                            <FormLabel>İsim <span class="text-red-500">*</span></FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="İsim"
                                    v-model="form.name"
                                />
                            </FormControl>
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="username">
                        <FormItem>
                            <FormLabel>Soyisim <span class="text-red-500">*</span></FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="İsim"
                                    v-model="form.surname"
                                />
                            </FormControl>
                            <InputError
                                class="mt-2"
                                :message="form.errors.surname"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="username">
                        <FormItem>
                            <FormLabel>E-posta <span class="text-red-500">*</span></FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="İsim"
                                    v-model="form.email"
                                />
                            </FormControl>
                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </FormItem>
                    </FormField>
                    <FormField name="username">
                        <FormItem>
                            <FormLabel>Plan <span class="text-red-500">*</span></FormLabel>
                            <FormControl>
                                <Select v-model="form.plan">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Plan Seç" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Fruits</SelectLabel>
                                            <SelectItem value="free">
                                                Ücretsiz Sürüm
                                            </SelectItem>
                                            <SelectItem value="paid">
                                                Ücretli Sürüm
                                            </SelectItem>
                                            <SelectItem value="doctor">
                                                Doktor
                                            </SelectItem>
                                            <SelectItem value="admin">
                                                Admin
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <InputError
                                class="mt-2"
                                :message="form.errors.plan"
                            />
                        </FormItem>
                    </FormField>
                </div>
                <FormField
                    v-if="form.plan == 'doctor'"
                    v-slot="{ componentField }"
                    name="username"
                >
                    <FormItem class="mt-5">
                        <FormLabel>Özgeçmiş (Açıklama)</FormLabel>
                        <FormControl>
                            <Textarea
                                type="text"
                                placeholder="Özgeçmiş (Açıklama)"
                                v-model="form.description"
                                disabled
                                class="!cursor-default !opacity-100"
                                rows="10"
                            />
                        </FormControl>
                    </FormItem>
                </FormField>
            </Form>
        </div>
    </AuthenticatedLayout>
</template>
