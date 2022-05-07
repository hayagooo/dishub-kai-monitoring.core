<template>
    <img src="@/Assets/illustrations/not_found.png" class="mt-4 w-2/5 inline-block" alt="Not Found">
    <div class="mt-4 mb-4">
        <h4 class="text-2xl font-semibold text-gray-600">{{ text }}</h4>
    </div>
    <button v-if="link_route != null && link_route != undefined" @click="onReload()" type="button" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-8 py-2.5 text-center mr-2 mb-4">Muat Ulang</button>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true,
        },
        link_route: {
            type: String,
        },
        data_route: {
            type: Object,
        }
    },
    methods: {
        onReload() {
            this.$inertia.get(this.route(this.link_route), this.data_route, {
                preserveState: true,
                preserveScroll: true,
            })
        }
    }
}
</script>
