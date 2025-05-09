<script setup>
import { ref, watch } from 'vue';
import AppWrapper from '@/Components/AppWrapper.vue'
import { useToast } from '@/components/ui/toast/use-toast';
import { usePage } from '@inertiajs/vue3';
import Toaster from '@/components/ui/toast/Toaster.vue';

const showingNavigationDropdown = ref(false);

const { toast, toasts } = useToast();

const page = usePage();
const props = defineProps({
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});

watch(
    () => page.props.flash,
    (value) => {
        if (value.error) {
            // if not already shown bug due inertiajs partial reloads?
            if (!toasts.value.find((t) => t.description === value.error)) {
                toast({
                    variant: 'destructive',
                    title: 'Hata',
                    description: value.error,
                });
            }
        } else if (value.success) {
            if (!toasts.value.find((t) => t.description === value.success)) {
                toast({
                    variant: 'success',
                    title: 'Başarılı',
                    description: value.success,
                });
            }
        }
    },
    { deep: true, immediate: true },
);
</script>

<template class="custom-scrollbar">
    <Toaster />
    <AppWrapper :breadcrumbs="props.breadcrumbs">
        <template #page>
            <slot />
        </template>
    </AppWrapper>
</template>

