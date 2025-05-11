<!-- components/ui/StarRating.vue -->
<template>
  <div class="flex items-center">
    <span
      v-for="index in 5"
      :key="index"
      class="text-yellow-400"
      :class="{
        'text-yellow-400': index <= fullStars,
        'text-yellow-300': index > fullStars && index <= halfStars,
        'text-gray-300': index > halfStars
      }"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="20"
        height="20"
        fill="currentColor"
        class="bi bi-star-fill"
        :class="{
          'text-yellow-400': index <= fullStars,
          'text-yellow-300': index > fullStars && index <= halfStars,
          'text-gray-300': index > halfStars
        }"
      >
        <path
          d="M9.049 2.927C9.31 2.25 10.689 2.25 10.95 2.927l1.451 2.924 3.24.467c.833.119 1.164 1.14.562 1.724l-2.35 2.288.554 3.243c.143.832-.732 1.463-1.475 1.071l-2.909-1.53-2.91 1.53c-.743.392-1.617-.239-1.475-1.071l.554-3.243-2.35-2.288c-.602-.584-.271-1.605.562-1.724l3.24-.467L9.049 2.927z"
        />
      </svg>
    </span>
  </div>
</template>

<script setup>
const props = defineProps({
  rating: {
    type: Number,
    required: true
  }
});

const fullStars = Math.floor(props.rating); // Tam yıldız sayısı
const halfStars = props.rating % 1 >= 0.5 ? fullStars + 1 : fullStars; // Yarım yıldız var mı?
</script>

<style scoped>
/* Yıldızlar için stil */
.bi-star-fill {
  transition: all 0.2s ease;
}
</style>
