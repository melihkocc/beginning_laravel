<script setup>
import { cn } from '@/lib/utils';
import { Primitive } from 'radix-vue';
import { buttonVariants } from '.';

const props = defineProps({
    variant: { type: null, required: false },
    size: { type: null, required: false },
    class: { type: null, required: false },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false, default: 'button' },
    authenticatebutton : { type: Boolean, default: false },
    processbutton : { type: Boolean, default:false },
    purplebutton : { type: Boolean, default:false }
});
</script>

<template>
    <Primitive :as="as" :as-child="asChild" :class="cn(buttonVariants({ variant, size }), props.class, { 'mt-4 w-full border border-black bg-black text-white hover:bg-white hover:text-black dark:bg-[#fafafa] dark:text-black dark:hover:bg-black dark:hover:text-white dark:border-[#fafafa] transition-all duration-300 ease-in-out' : authenticatebutton}, { 'dark:bg-[#fafafa] dark:text-black dark:hover:bg-black dark:hover:text-white dark:border-[#fafafa]  bg-[#9B51E0] border border-[#9B51E0] hover:bg-white hover:text-[#9B51E0] transition-all duration-300 ease-in-out' : processbutton })">
        <slot />
    </Primitive>
</template>
