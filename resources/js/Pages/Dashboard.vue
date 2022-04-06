<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="grid grid-cols-2">
                        <div id="information" class="col-span-2 lg:col-span-1 p-6 lg:border-r-2 border-gray-200">
                            <div class="grid grid-cols-2">
                                <div>
                                    <h2 class="text-2xl text-gray-800 leading-tight font-semibold">Pemberitahuan</h2>
                                </div>
                                <div v-if="$page.props.user.level != 'user'" class="col-span-2 mt-8 md:mt-0 md:col-span-1 justify-self-end">
                                    <button type="button" class="w-full md:w-auto focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                        <plus-circle-icon size="18" class="inline-block"/>
                                        <span class="inline-block ml-2">
                                            Pemberitahuan Baru
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div id="content-information" class="mt-4">
                                <div v-if="informations.data.length > 0">
                                    <div v-for="(item, index) in informations.data" :key="index" class="grid grid-cols-3 mb-3 flex-col items-center bg-white rounded-lg border shadow-md hover:bg-gray-100">
                                        <div class="col-span-1 relative w-full h-full">
                                            <img class="object-cover absolute top-0 bottom-0 left-0 h-full w-full rounded-l-lg"
                                            src="https://images.unsplash.com/photo-1541427468627-a89a96e5ca1d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="Pemberitahuan">
                                        </div>
                                        <div class="col-span-2 justify-between p-4 leading-normal">
                                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Surat Pemberitahuan : Prosedur operasi standar {{ item }}</h5>
                                            <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti cumque eum, quibusdam, ad porro tempore aspernatur delectus dolorem maiores autem adipisci inventore asperiores dolor voluptate? Commodi possimus aliquid ipsum? Laborum neque enim minus aspernatur ex quia!</p>
                                            <a href="#" class="inline-block ml-auto items-center py-2 px-3 text-sm font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300">
                                                <span class="inline-block mr-2">
                                                    Selengkapnya
                                                </span>
                                                <arrow-right-icon size="18" class="inline-block"/>
                                            </a>
                                        </div>
                                    </div>
                                    <button class="relative w-full inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <span class="relative w-full px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md">
                                            Lebih Banyak
                                        </span>
                                    </button>
                                </div>
                                <div v-else class="text-center">
                                    <m-no-data text="Tidak ada pemberitahuan"/>
                                </div>
                            </div>
                        </div>
                        <div id="list-menu" class="col-span-2 lg:col-span-1 p-6 border-gray-200">
                            <h2 class="text-2xl text-gray-800 leading-tight font-semibold">Pilihan Menu</h2>
                            <div class="grid grid-cols-2 h-full gap-8 text-center justify-center items-center pb-12">
                                <div class="col-span-1 lg:col-span-1 my-3">
                                    <div @click="gotoIndex('app.category.index')" class="transition-all ease-in hover:scale-110" role="button">
                                        <img src="@/Assets/features/monitoring.png" class="inline-block h-20 w-auto" alt="Monitoring">
                                        <div>
                                            <p class="text-lg inline-block font-semibold">Monitoring</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 lg:col-span-1 my-3">
                                    <div @click="gotoIndex('app.information.index')" class="transition-all ease-in hover:scale-110" role="button">
                                        <img src="@/Assets/features/information.png" class="inline-block h-20 w-auto" alt="Monitoring">
                                        <div>
                                            <p class="text-lg inline-block font-semibold">Sistem Informasi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 lg:col-span-1 my-3" v-if="$page.props.user.level == 'coordinator'">
                                    <div @click="gotoIndex('app.user.index')" class="transition-all ease-in hover:scale-110" role="button">
                                        <img src="@/Assets/features/user.png" class="inline-block h-20 w-auto" alt="Monitoring">
                                        <div>
                                            <p class="text-lg inline-block font-semibold">Manage Pengguna</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 lg:col-span-1 my-3" v-if="$page.props.user.level == 'coordinator'">
                                    <div @click="gotoIndex('app.team.index')" class="transition-all ease-in hover:scale-110" role="button">
                                        <img src="@/Assets/features/team.png" class="inline-block h-20 w-auto" alt="Monitoring">
                                        <div>
                                            <p class="text-lg inline-block font-semibold">Manage Tim</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import { PlusCircleIcon, ArrowRightIcon } from '@zhuowenli/vue-feather-icons'
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['informations'],
    components: {
        AppLayout,
        ArrowRightIcon,
        Welcome,
        MNoData,
        PlusCircleIcon,
    },
    methods: {
        gotoIndex(path) {
            this.$inertia.get(this.route(path))
        },
    }
})
</script>
