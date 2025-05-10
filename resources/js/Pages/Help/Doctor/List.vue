<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
const breadcrumbs = ref([{ title: "Talepler" }]);

</script>

<template>
        <AuthenticatedLayout :breadcrumbs="breadcrumbs">
                
        </AuthenticatedLayout>
</template>