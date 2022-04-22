<template>
    <nav aria-label="Page navigation example">
  <ul class="inline-flex items-center -space-x-px">
    <li v-for="(page, index) in paginationData.links" :key="`pagination-${index}`">
      <inertia-link v-if="page.label == 'pagination.previous'" :href="page.url != null ? page.url+'&'+toParams(data) : '#'" class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
        <span class="sr-only">Previous</span>
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
      </inertia-link>
      <inertia-link v-if="page.label == 'pagination.next'" :href="page.url != null ? page.url+'&'+toParams(data) : '#'" class="block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
        <span class="sr-only">Next</span>
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
      </inertia-link>
      <inertia-link :href="page.url != null ? page.url+'&'+toParams(data) : '#'" v-if="page.label != 'pagination.next' && page.label != 'pagination.previous'"
        :class="{'z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700': page.active,
        'py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ': !page.active}" v-html="page.label">
      </inertia-link>
    </li>
  </ul>
</nav>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
export default {
  name: 'Pagination',
  props: {
    paginationData: {
      required: true,
      type: Object
    },
    data: {
        type: Object,
    },
    preserveState: {
      default: false,
      type: Boolean,
    },
  },
  methods: {
      toParams(obj) {
        var str = []
        for (var p in obj)
            if(obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]))
            }
        return str.join("&")
    }
  }
}
</script>
