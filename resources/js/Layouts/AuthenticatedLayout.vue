<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import AppWrapper from '@/Components/AppWrapper.vue'

const showingNavigationDropdown = ref(false);
</script>

<template class="custom-scrollbar">
    <Toaster />
    <AppWrapper>
        <template #page>
            <slot />
        </template>
    </AppWrapper>
</template>

