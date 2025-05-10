<script setup>
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { inject, onMounted, ref } from "vue";
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Head, usePage, useForm, Link } from "@inertiajs/vue3";
import Button from "@/components/ui/button/Button.vue";
import { Edit, Trash } from "lucide-vue-next";
import Textarea from "@/components/ui/textarea/Textarea.vue";
const dayjs = inject("dayjs");

const { props } = usePage();
console.log(props);
const breadcrumbs = ref([
    {
        title: "Kullanıcılar",
        route: route("users.index"),
    },
    {
        title: "Kullanıcı Görüntüle",
    },
]);

const form = useForm({
    name: props.user.name,
    surname: props.user.surname,
    email: props.user.email,
    plan: props.user.plan,
    description: props.user.description,
});

const deleteUser = () => {
    form.delete(route("users.delete", props.user.id));
};

const plan = ref("");

onMounted(() => {
    if (props.user.plan === "free") {
        plan.value = "Ücretsiz Sürüm";
    } else if (props.user.plan === "paid") {
        plan.value = "Ücretli Sürüm";
    } else if (props.user.plan === "doctor") {
        plan.value = "Doktor";
    } else if (props.user.plan === "admin") {
        plan.value = "Admin";
    } else {
        plan.value = "-";
    }
});
</script>

<template>
    <Head title="Kullanıcı Görüntüle" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div>
                    <Title text="Kullanıcı Görüntüle" />
                    <div class="mt-1 text-sm text-gray-500">
                        Oluşturulma Tarihi :
                        {{ $dayjs(props.user.created_at).format("DD/MM/YYYY") }}
                    </div>
                </div>
                <div
                    class="flex lg:justify-end md:justify-end justify-start items-center gap-5"
                >
                    <Link :href="route('users.edit', props.user.id)"
                        ><Button processbutton> <Edit /> Düzenle</Button></Link
                    >
                    <Button @click="deleteUser" variant="destructive">
                        <Trash /> Sil</Button
                    >
                </div>
            </div>

            <Form class="mt-5" @submit="onSubmit">
                <div
                    class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5"
                >
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel>İsim</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="İsim"
                                    v-model="form.name"
                                    disabled
                                    class="!cursor-default !opacity-100"
                                />
                            </FormControl>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel>Soyisim</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="İsim"
                                    v-model="form.surname"
                                    disabled
                                    class="!cursor-default !opacity-100"
                                />
                            </FormControl>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel>E-posta</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="İsim"
                                    v-model="form.email"
                                    disabled
                                    class="!cursor-default !opacity-100"
                                />
                            </FormControl>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel>Plan</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="İsim"
                                    v-model="plan"
                                    disabled
                                    class="!cursor-default !opacity-100"
                                />
                            </FormControl>
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
                                placeholder="İsim"
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
