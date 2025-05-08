<script setup lang="ts">
import { useBreakpoints } from '@/composables/breakpoints';
import { cn } from '@/lib/utils';
import { useSidebarStore } from '@/stores/sidebar';
import { storeToRefs } from 'pinia';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
const sidebarStore = useSidebarStore();

const { open } = storeToRefs(sidebarStore);
const { isMobile } = useBreakpoints();
</script>

<template>
    <main
        :class="
            cn(
                'relative flex min-h-svh w-full max-w-full flex-1 flex-col bg-background',
                'peer-data-[variant=inset]:min-h-[calc(100svh-theme(spacing.4))] md:peer-data-[variant=inset]:m-2 md:peer-data-[state=collapsed]:peer-data-[variant=inset]:ml-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow',
                props.class,
            )
        "
        :style="!isMobile && open ? 'max-width: calc(100% - var(--sidebar-width))' : ''"
    >
        <slot />
    </main>
</template>
