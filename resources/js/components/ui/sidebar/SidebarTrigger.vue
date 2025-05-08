<script setup>
import Button from '@/components/ui/button/Button.vue';
import { cn } from '@/lib/utils';
import { useSidebarStore } from '@/stores/sidebar';
import { PanelLeft } from 'lucide-vue-next';
import { onMounted } from 'vue';

const props = defineProps({
    class: {
        type: null,
        required: false,
        default: "",
    },
});

const { toggleSidebar,setOpenMobile } = useSidebarStore();

onMounted(() => {
    setOpenMobile(false);
});
</script>

<template>
    <Button
        data-sidebar="trigger"
        variant="ghost"
        size="icon"
        :class="cn('h-7 w-7', props.class)"
        @click="toggleSidebar"
    >
        <PanelLeft />
        <span class="sr-only">Toggle Sidebar</span>
    </Button>
</template>
