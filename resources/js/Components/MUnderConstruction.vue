<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <div class="text-center grid grid-cols-2 gap-4">
                <div class="col-span-2 text-center lg:col-span-1">
                    <img src="@/Assets/illustrations/maintenance.png" class="w-9/12 h-auto inline-block" alt="Under Construction">
                </div>
                <div class="col-span-2 lg:col-span-1 text-left w-full relative">
                    <p class="font-semibold text-purple-400 text-xl">Oops...</p>
                    <p class="font-bold text-purple-700 text-3xl">Halaman yang dituju masih belum tersedia</p>
                    <p class="text-gray-400">
                        Halaman ini masih dalam proses development oleh tim developer kami (^_^;)
                    </p>
                    <div class="justify-self-start mt-8">
                        <button @click="gotoIndex('dashboard')" type="button" class="focus:outline-none text-purple-900 hover:text-white bg-purple-200 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                            <chevron-left-icon size="18" class="inline-block"/>
                            <span class="inline-block ml-2">
                                Kembali ke halaman awal
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { ChevronLeftIcon, } from '@zhuowenli/vue-feather-icons'

export default defineComponent({
    components: {
        ChevronLeftIcon,
    },
    methods: {
        gotoIndex(path) {
            this.$inertia.get(this.route(path))
        },
    }
})
</script>
