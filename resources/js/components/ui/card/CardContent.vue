<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
    class: { type: null, required: false },
});
</script>

<template>
    <div :class="cn('p-4 pt-0 md:p-6', props.class)">
        <slot />
    </div>
</template>
