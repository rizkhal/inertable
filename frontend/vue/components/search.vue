<template>
  <form class="lg:pr-3">
    <label class="sr-only">Search</label>
    <div class="mt-1 relative lg:w-64 xl:w-96">
      <input
        type="search"
        autocomplete="off"
        v-model="modelValue"
        placeholder="Search here.."
        @input="$emit('update:modelValue', $event.target.value)"
        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
      />
    </div>
  </form>
</template>
<script setup>
const props = defineProps({
  modelValue: String,
});

const emits = defineEmits(["update:modelValue"]);
</script>