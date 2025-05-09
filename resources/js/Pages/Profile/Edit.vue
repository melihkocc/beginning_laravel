<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import Title from "@/Components/Title.vue";
import { ref } from "vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const breadcrumbs = ref([
    {
        title: 'Profil',
        route: route('profile.edit'),
    },
]);
</script>

<template>
    <Head title="Profil" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <Title text="Profil"></Title>
            <div
                class="bg-white dark:bg-black border dark:text-white p-4 shadow sm:rounded-lg sm:p-8"
            >
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div
                class="bg-white dark:bg-black border dark:text-white p-4 shadow sm:rounded-lg sm:p-8"
            >
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div
                class="bg-white dark:bg-black border dark:text-white p-4 shadow sm:rounded-lg sm:p-8"
            >
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
