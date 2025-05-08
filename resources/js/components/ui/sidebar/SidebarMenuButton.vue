<script setup>
import Tooltip from '@/components/ui/tooltip/Tooltip.vue';
import TooltipContent from '@/components/ui/tooltip/TooltipContent.vue';
import TooltipTrigger from '@/components/ui/tooltip/TooltipTrigger.vue';
import { useBreakpoints } from '@/composables/breakpoints';
import { useSidebarStore } from '@/stores/sidebar';
import { storeToRefs } from 'pinia';
import { computed } from 'vue';
import SidebarMenuButtonChild from './SidebarMenuButtonChild.vue';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    tooltip: {
        type: [String, Object],
        required: false,
        default: undefined,
    },
    as: {
        type: [String, Object],
        required: false,
        default: 'button',
    },
    variant: {
        type: String,
        required: false,
        default: 'default',
    },
    size: {
        type: String,
        required: false,
        default: 'default',
    },
});
const sidebarStore = useSidebarStore();
const { state } = storeToRefs(sidebarStore);

const { isMobile } = useBreakpoints();

const delegatedProps = computed(() => {
    const { tooltip: _, ...delegated } = props;
    return delegated;
});
</script>

<template>
    <SidebarMenuButtonChild v-if="!tooltip" v-bind="{ ...delegatedProps, ...$attrs }">
        <slot />
    </SidebarMenuButtonChild>

    <Tooltip v-else>
        <TooltipTrigger as-child>
            <SidebarMenuButtonChild v-bind="{ ...delegatedProps, ...$attrs }">
                <slot />
            </SidebarMenuButtonChild>
        </TooltipTrigger>
        <TooltipContent side="right" align="center" :hidden="state !== 'collapsed' || isMobile">
            <template v-if="typeof tooltip === 'string'">
                {{ tooltip }}
            </template>
            <component :is="tooltip" v-else />
        </TooltipContent>
    </Tooltip>
</template>
