<template>
  <main>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
      <div class="mb-1 w-full">
        <div class="sm:flex">
          <div class="hidden sm:flex items-center sm:divide-x sm:divide-gray-100 mb-3 sm:mb-0">
            <v-search v-model="params.search" />
          </div>
          <div class="flex items-center space-x-2 sm:space-x-3 ml-auto">
            <slot v-if="$slots['actions']" name="actions" />
            <template v-else v-for="(action, index) in actions" :key="index">
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
        <div class="bg-white p-4 border-b border-dashed">
          <div v-if="selected.length" class="inline-flex items-center mr-4">
            <span class="mr-2">{{ selected.length }} Row Selected</span>
            <div class="inline-flex gap-2">
              <button @click="handleSelectAll" class="bg-cyan-600 px-2 py-1 text-white text-sm rounded focus:ring-2 focus:ring-offset-2 focus:ring-cyan-600">Select All</button>
              <button @click="handleUnselectAll" class="bg-gray-600 px-2 py-1 text-white text-sm rounded focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">Unselect All</button>
            </div>
          </div>
          <div v-if="params.column && params.direction" class="inline-flex items-center">
            <div>
              <span class="font-semibold">{{ sortedColumnName.charAt(0).toUpperCase() + sortedColumnName.slice(1) }}:</span>
              Applied sorting
              <div class="inline-flex text-white">
                <div class="px-2 py-1 bg-cyan-600 rounded-l">{{ params.direction === "asc" ? "A-Z" : "Z-A" }}</div>
                <span @click="handleClearFilter" class="bg-gray-600 px-2 py-1 rounded-r cursor-pointer">&times;</span>
              </div>
            </div>
          </div>
        </div>
        <div class="align-middle inline-block min-w-full">
          <div class="shadow overflow-hidden">
            <table class="table-fixed min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <v-col :columns="inertable.columns" :direction="params.direction" :column="params.column" @onSort="handleSort" @onCheckAll="handleCheckAll" />
              </thead>
              <tbody class="bg-white divide-y divide-gray-200" v-if="inertable.data.data.length">
                <tr v-for="(item, index) in inertable.data.data" :key="index" class="hover:bg-gray-100">
                  <template v-for="(column, i) in inertable.columns" :key="i">
                    <td v-if="column.blank && column.checkbox" class="p-4 w-4">
                      <div class="flex items-center">
                        <input
                          type="checkbox"
                          :value="item.id"
                          v-model="selected"
                          :id="`checkbox-${id}`"
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

    <slot name="paginate" v-if="$slots['paginate']" :data="inertable" />
    <div v-else>
      <v-simple-pagination
        v-if="pagination === PaginationType.SIMPLE"
        :total="inertable.data.total"
        :last="inertable.data.last_page"
        :current="params.page"
        :from="inertable.data.from"
        :to="inertable.data.to"
        @onLoadPage="handleOnLoadPage"
      />
    </div>
  </main>
</template>
<script>
import { v4 as uuid } from "uuid";
import { throttle, pickBy } from "lodash";
import { PaginationType } from "../utils/enum";

export default {
  props: {
    inertable: {
      type: Object,
      required: true,
    },
    pagination: {
      type: String,
      default: PaginationType.SIMPLE,
    },
    actions: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    const { data, filters } = this.inertable;

    return {
      id: uuid(),
      filters: filters,
      selected: [],
      params: {
        column: filters.column,
        direction: filters.direction,
        search: filters.search,
        perpage: filters.perpage ?? 15,
        page: data.current_page,
      },
      PaginationType: PaginationType,
    };
  },
  computed: {
    sortedColumnName() {
      if (this.params.column) {
        return this.inertable.columns.filter((v) => v.column === this.params.column)[0].text;
      }
    },
  },
  methods: {
    handleSort(column) {
      if (!this.filters) return;

      this.params.column = column;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },
    handleCheckAll(selectAll) {
      const { data } = this.inertable.data;
      this.selected = [];

      if (selectAll) {
        for (const item in data) {
          this.selected.push(data[item]["id"]);
        }
      }
    },
    handleOnLoadPage(page) {
      this.params.page = page;
    },
    handleSelectAll() {
      console.log("handleSelectAll");
    },
    handleUnselectAll() {
      this.selected = [];
    },
    handleClearFilter() {
      this.params.column = null;
      this.params.direction = null;
    },
  },
  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(`${window.location.pathname}`, params, {
          replace: true,
          preserveState: true,
        });
      }, 250),
      deep: true,
    },
  },
};
</script>