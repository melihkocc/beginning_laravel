<script setup>
defineProps({
  text: {
    type: String,
    required: true
  },
  level: {
    type: Number,
    default: 1
  }
})
</script>

<template>
  <component :is="'h' + level" class="text-2xl font-bold">
    {{ text }}
  </component>
</template>
