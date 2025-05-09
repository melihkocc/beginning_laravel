<script setup>
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const breadcrumbs = ref([
    {
        title: 'Anasayfa',
        route: route('dashboard'),
    },
]);


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <Title text="Anasayfa"></Title>
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">Anasayfa!</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
