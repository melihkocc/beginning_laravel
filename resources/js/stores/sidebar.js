import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

import { useBreakpoints } from '@/composables/breakpoints';

export const useSidebarStore = defineStore('sidebar', () => {
    const { isMobile } = useBreakpoints();

    const open = ref(!isMobile.value);
    const openMobile = ref(false);

    const toggleSidebar = () => {
        if (isMobile.value) {
            openMobile.value = !openMobile.value;
            return;
        }
        open.value = !open.value;
    };

    const state = computed(() => {
        return open.value ? 'expanded' : 'collapsed';
    });

    const setOpen = (value) => {
        open.value = value;
    };

    const setOpenMobile = (value) => {
        openMobile.value = value;
    };

    return {
        state,
        open,
        setOpen,
        openMobile,
        setOpenMobile,
        toggleSidebar,
    };
});
