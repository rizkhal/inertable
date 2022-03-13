<template>
  <tr>
    <template v-for="(column, index) in props.columns" :key="index">
      <th v-if="column.blank && column.checkbox" scope="col" class="p-4 cursor-pointer">
        <div class="flex items-center">
          <input
            type="checkbox"
            v-model="checkbox"
            :id="`checkbox-${uuid()}`"
            @change="$emit('onCheckAll', checkbox)"
            class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded"
          />
          <label :for="`checkbox-${uuid()}`" class="sr-only">checkbox</label>
        </div>
      </th>
      <th v-else scope="col" @click="handleSort(column)" class="p-4 text-left text-xs font-medium text-gray-500 uppercase" :class="[column.sortable ? 'cursor-pointer' : 'cursor-default']">
        <div class="flex flex-row items-center">
          <span class="mr-2">{{ column.text }}</span>

          <svg
            v-if="column.sortable && props.column === column.column && props.direction === 'asc'"
            class="w-4 h-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            width="2.3em"
            height="2.3em"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
          </svg>
          <svg
            v-if="column.sortable && props.column === column.column && props.direction === 'desc'"
            class="w-4 h-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            width="2.3em"
            height="2.3em"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </div>
      </th>
    </template>
  </tr>
</template>
<script setup>
import { ref } from "vue";
import { v4 as uuid } from "uuid";

const checkbox = ref(false);

const emits = defineEmits(["onSort", "onCheckAll"]);

const props = defineProps({
  column: String,
  columns: Object,
  direction: String,
});

const handleSort = ({ column, sortable }) => {
  if (!sortable) return;
  emits("onSort", column);
};
</script>