<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from '@/Components/Datatable.vue';
import { ref, h } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';

const breadcrumbs = ref([
  { title: 'Kullanıcılar' },
])

const users = ref([
  { id: 1, name: 'Ali Yılmaz', email: 'ali@example.com', role: 'Admin' },
  { id: 2, name: 'Ayşe Demir', email: 'ayse@example.com', role: 'User' },
])

const columnHelper = createColumnHelper<any>()

const columns = [
  columnHelper.accessor('name', {
    header: 'Ad Soyad',
    cell: info => h('span', info.getValue())
  }),
  columnHelper.accessor('email', {
    header: 'Email',
    cell: info => h('span', info.getValue())
  }),
  columnHelper.accessor('role', {
    header: 'Rol',
    cell: info => h('span', info.getValue())
  }),
]
</script>

<template>
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <DataTable :data="users" :columns="columns" />
    </AuthenticatedLayout>
</template>
