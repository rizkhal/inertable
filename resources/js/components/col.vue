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
      <th v-else scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" @click="$emit('onSort', column.column)">
        <div class="flex flex-row">
          <span>{{ column.text }}</span>
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
  columns: Object,
  filters: Object,
});
</script>