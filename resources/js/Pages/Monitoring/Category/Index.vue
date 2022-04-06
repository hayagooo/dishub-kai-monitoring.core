<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitoring
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7">
                        <button @click="goHome()" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            <arrow-left-icon size="18" class="inline-block mr-3"/>
                            <span class="inline-block">Kembali</span>
                        </button>
                        <div class="mt-6 relative">
                            <img src="@/Assets/features/monitoring.png" class="inline-block h-20 w-auto" alt="Monitoring">
                            <span class="inline-block text-2xl text-gray-600 ml-6 font-semibold">
                                Monitoring Data
                            </span>
                        </div>
                    </div>
                    <div id="categories" class="bg-gray-100 relative sm:rounded-xl p-7">
                        <h2 class="text-xl text-gray-700 font-semibold">Kategori Monitoring</h2>
                        <button type="button" class="w-full mt-4 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                            <plus-circle-icon size="18" class="inline-block mr-4"/>
                            <span class="inline-block">
                                Tambah Kategori
                            </span>
                        </button>
                        <div v-if="categories.length > 0">

                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Tidak ada kategori"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, PlusCircleIcon } from '@zhuowenli/vue-feather-icons'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['categories'],
    components: {
        AppLayout,
        MNoData,
        ArrowLeftIcon,
        PlusCircleIcon,
        MUnderConstruction,
    },
    methods: {
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        }
    }
})
</script>
