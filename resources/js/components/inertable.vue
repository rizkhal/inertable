<template>
  <main>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
      <div class="mb-1 w-full">
        <div class="sm:flex">
          <div class="hidden sm:flex items-center sm:divide-x sm:divide-gray-100 mb-3 sm:mb-0">
            <v-search v-model="filters.search" />
          </div>
          <div class="flex items-center space-x-2 sm:space-x-3 ml-auto">
            <template v-for="(action, index) in actions" :key="index">
              <button
                type="button"
                @click="$emit(action.emit)"
                class="
                  w-1/2
                  text-white
                  bg-cyan-600
                  hover:bg-cyan-700
                  focus:ring-4 focus:ring-cyan-200
                  font-medium
                  inline-flex
                  items-center
                  justify-center
                  rounded-lg
                  text-sm
                  px-3
                  py-2
                  text-center
                  sm:w-auto
                "
              >
                <!-- <v-icon :name="action.icon" type="outline" class="-ml-1 h-6 w-6" /> -->
                {{ action.text }}
              </button>
            </template>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-col">
      <div class="overflow-x-auto">
        <div class="bg-white p-4 border-b border-dashed" v-if="selected.length">
          <span class="mr-4">{{ selected.length }} Row Selected</span>
          <div class="inline-flex gap-2">
            <button @click="handleSelectAll" class="bg-cyan-600 px-2 py-1 text-white text-sm rounded focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600">Select All</button>
            <button class="bg-gray-600 px-2 py-1 text-white text-sm rounded focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">Unselect All</button>
          </div>
        </div>
        <div class="align-middle inline-block min-w-full">
          <div class="shadow overflow-hidden">
            <table class="table-fixed min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <v-col :columns="columns" :filters="filters" @onSort="handleSort" @onCheckAll="handleCheckAll" />
              </thead>
              <tbody class="bg-white divide-y divide-gray-200" v-if="data.data.length">
                <tr v-for="(item, index) in data.data" :key="index" class="hover:bg-gray-100">
                  <template v-for="(column, i) in columns" :key="i">
                    <td v-if="column.blank && column.checkbox" class="p-4 w-4">
                      <div class="flex items-center">
                        <input
                          :id="`checkbox-${id}`"
                          v-model="selected"
                          :value="item.id"
                          type="checkbox"
                          class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded"
                        />
                        <label :for="`checkbox-${id}`" class="sr-only">checkbox</label>
                      </div>
                    </td>
                    <td v-else class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                      <slot :name="column.column" :item="item" />
                      <div v-if="!$slots[column.column]">
                        {{ item[column.column] }}
                      </div>
                    </td>
                  </template>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <v-simple-pagination
      v-if="pagination === PaginationType.SIMPLE"
      :total="data.total"
      :last="data.last_page"
      :current="data.current_page"
      :from="data.from"
      :to="data.to"
      @onLoadPage="handleOnLoadPage"
    />
  </main>
</template>
<script>
import { v4 as uuid } from "uuid";
import { defineComponent, watch, reactive, ref } from "vue";
import { throttle, pickBy } from "lodash";
import { PaginationType } from "../utils/enum";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
  props: {
    pagination: {
      type: String,
      required: true,
    },
    actions: {
      type: Array,
      default: () => [],
    },
  },
  setup(__, { attrs }) {
    const {
      inertable: { columns, data, fields, filters },
    } = attrs;

    const id = uuid();

    const selected = ref([]);
    const filtersParams = reactive({
      column: filters.column,
      direction: filters.direction,
      search: filters.search,
      perpage: filters.perpage ?? 15,
      page: data.current_page,
    });

    const handleOnLoadPage = (page) => {
      filtersParams.page = page;
    };

    const handleSort = () => {
      //
    };

    const handleCheckAll = (selectedAll) => {
      selected.value = [];

      if (selectedAll) {
        for (let item in data.data) {
          selected.value.push(data.data[item]["id"]);
        }
      }
    };

    const handleSelectAll = () => {
      console.log("it will be select all row");
    };

    // watcher
    watch(
      () => filtersParams,
      (filterParams, prevFilterParams) => {
        let params = pickBy(filtersParams);

        Inertia.get(`${window.location.pathname}`, params, {
          replace: true,
          preserveState: true,
        });
      },
      { deep: true },
    );

    return {
      id,
      columns,
      data,
      fields,
      filters,
      selected,
      PaginationType,
      handleSort,
      handleCheckAll,
      handleSelectAll,
      handleOnLoadPage,
    };
  },
});
</script>