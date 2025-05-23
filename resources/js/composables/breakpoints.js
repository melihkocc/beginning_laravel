import { computed, onMounted, onUnmounted, ref } from 'vue';

export const useBreakpoints = () => {
    const windowWidth = ref(window.innerWidth);

    const onWidthChange = () => (windowWidth.value = window.innerWidth);

    onMounted(() => window.addEventListener('resize', onWidthChange));
    onUnmounted(() => window.removeEventListener('resize', onWidthChange));

    const type = computed(() => {
        if (windowWidth.value < 640) return 'sm';
        if (windowWidth.value >= 640 && windowWidth.value < 769) return 'md';
        if (windowWidth.value >= 768 && windowWidth.value < 1024) return 'lg';
        if (windowWidth.value >= 1024 && windowWidth.value < 1280) return 'xl';
        return '2xl';
    });

    const width = computed(() => windowWidth.value);

    const isMobile = computed(() => type.value === 'sm' || type.value === 'md');

    return { isMobile, width, type };
};
