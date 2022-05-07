<template>
    <div>
        <div class="container mx-auto px-14">
            <div class="columns-1">
                <div id="nav" class="py-6 grid grid-cols-2">
                    <div>
                        <div class="image-brand">
                            <img src="@/Assets/logo.png" class="w-14 inline-block" alt="Logo Aplikasi Monitoring">
                            <p class="text-xl font-semibold ml-4 hidden md:inline-block">Monitoring</p>
                        </div>
                    </div>
                    <div class="justify-self-end">
                        <button @click="gotoLogin()" type="button" class="mt-2 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-8 py-2.5 mb-2 light:bg-purple-600 light:hover:bg-purple-700 light:focus:ring-purple-900">Masuk</button>
                    </div>
                </div>
                <div id="header" class="grid grid-cols-2">
                    <div class="self-center col-span-2 lg:col-span-1">
                        <div class=" text mt-12 lg:px-6">
                            <p class="text-4xl mb-2 font-bold">Sistem Monitoring dan Informasi <span class="text-purple-700">Fasilitas Kereta Api</span></p>
                            <p>Sistem internal untuk mengakses sumber informasi dan memonitoring fasilitas fasilitas kereta api yang bertujuan untuk membangun dan meningkatkan sarana dan prasarana</p>
                            <button @click="gotoLogin()" type="button" class="mt-6 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-12 py-4 mb-2 light:bg-purple-600 light:hover:bg-purple-700 light:focus:ring-purple-900">Mulai Sekarang</button>
                        </div>
                    </div>
                    <div class="my-8 col-span-2 lg:col-span-1">
                        <div class="flex flex-nowrap">
                            <img src="https://images.unsplash.com/photo-1622599656962-59ea819860aa?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=326&q=80"
                                alt="Kereta Api Indonesia"
                                class="w-6/12 rounded-xl mr-2">
                            <img src="https://images.unsplash.com/photo-1634553492003-ceecfb2323bc?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80"
                                alt="Kereta Api Indonesia"
                                class="w-6/12 rounded-xl mx-2">
                            <img src="https://images.unsplash.com/photo-1628453297537-d3f3819691f1?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=327&q=80"
                                alt="Kereta Api Indonesia"
                                class="w-6/12 rounded-xl mx-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 mt-4 py-12">
            <div class="container mx-auto px-14">
                <div class="columns-1">
                    <p class="text-4xl font-bold">Fitur Inovatif</p>
                </div>
                <div class="grid grid-cols-4 gap-4 mt-8">

                    <div class="col-span-4 sm:col-span-2 md:col-span-1">
                        <div class="block w-full p-6 max-w-sm bg-white rounded-xl border border-gray-100 hover:text-purple-700">
                            <monitor-icon size="2x"/>
                            <h5 class="my-2 text-2xl font-semibold mt-3 tracking-tight">Monitoring</h5>
                            <p class="font-normal text-gray-700">Memonitoring keadaan dan kondisi fasilitas kereta api apakah bagus atau tidak.</p>
                        </div>
                    </div>

                    <div class="col-span-4 sm:col-span-2 md:col-span-1">
                        <div class="block w-full p-6 max-w-sm bg-white rounded-xl border border-gray-100 hover:text-purple-700">
                            <database-icon size="2x"/>
                            <h5 class="my-2 text-2xl font-semibold mt-3 tracking-tight">Sistem Informasi</h5>
                            <p class="font-normal text-gray-700">Berupa penyimpanan dan pengolahan data hasil monitoring fasilitas kereta api.</p>
                        </div>
                    </div>

                    <div class="col-span-4 sm:col-span-2 md:col-span-1">
                        <div class="block w-full p-6 max-w-sm bg-white rounded-xl border border-gray-100 hover:text-purple-700">
                            <file-text-icon size="2x"/>
                            <h5 class="my-2 text-2xl font-semibold mt-3 tracking-tight">Pemberitahuan</h5>
                            <p class="font-normal text-gray-700">Fitur untuk bookmark agar semua user bisa mengetahui sesuatu seperti pengumuman.</p>
                        </div>
                    </div>

                    <div class="col-span-4 sm:col-span-2 md:col-span-1">
                        <div class="block w-full p-6 max-w-sm bg-white rounded-xl border border-gray-100 hover:text-purple-700">
                            <user-icon size="2x"/>
                            <h5 class="my-2 text-2xl font-semibold mt-3 tracking-tight">Data Pegawai</h5>
                            <p class="font-normal text-gray-700">Pengolahan data pegawai sebagai subjek yang melakukan kegiatan monitoring.</p>
                        </div>
                    </div>

                    <div class="col-span-4 sm:col-span-2 md:col-span-1">
                        <div class="block w-full p-6 max-w-sm bg-white rounded-xl border border-gray-100 hover:text-purple-700">
                            <monitor-icon size="2x"/>
                            <h5 class="my-2 text-2xl font-semibold mt-3 tracking-tight">Data Tim / Group</h5>
                            <p class="font-normal text-gray-700">Pengolahan data tim sebagai kelompok dari subjek kegiatan monitoring.</p>
                        </div>
                    </div>

                    <div class="col-span-4 sm:col-span-2 md:col-span-1">
                        <div class="block w-full p-6 max-w-sm bg-white rounded-xl border border-gray-100 hover:text-purple-700">
                            <map-icon size="2x"/>
                            <h5 class="my-2 text-2xl font-semibold mt-3 tracking-tight">Visualisasi Peta</h5>
                            <p class="font-normal text-gray-700">Monitoring terdapat data lokasi yang bisa divualisasikan agar lebih inovatif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer" class="bg-slate-900 py-8">
            <div class="container mx-auto px-12">
                <div class="grid grid-cols-2">
                    <div class="col-span-2 sm:col-span-1 justify-self-start text-slate-300">
                        2022 Copyright by Balai Teknik Perkeretaapian Jawa Barat.
                        <!-- <div class="mt-4">
                            <img src="@/Assets/logo-btp-jabar.png" class="w-14 inline-block mr-2" alt="Logo BTP Jabar">
                            <img src="@/Assets/logo-dishub.png" class="w-14 inline-block mx-2" alt="Logo Dishub">
                        </div> -->
                    </div>
                    <div class="col-span-2 sm:col-span-1 justify-self-end text-slate-300">
                        2022 Developed by <a href="https://sidescript.id" class="underline" target="_blank">Sidescript Indonesia</a>.
                        <!-- <div class="mt-4">
                            <img src="@/Assets/logo-dev.png" class="w-16 inline-block mr-2" alt="Logo BTP Jabar">
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { MonitorIcon, DatabaseIcon, FileTextIcon, UserIcon, UsersIcon, MapIcon } from "@zhuowenli/vue-feather-icons"
export default {
    props: ['reload'],
    components: {
        DatabaseIcon,
        FileTextIcon,
        MonitorIcon,
        UserIcon,
        MapIcon,
    },
    mounted() {
        this.checkUrlReload()
    },
    methods: {
        checkUrlReload() {
            let url = new URL(window.location.href)
            let searchParams = new URLSearchParams(url.search)
            if(searchParams.get('reload') == 1) {
                window.location.href = '/'
            } else return false
        },
        gotoLogin() {
            this.$inertia.get(route('login'))
        }
    }
}
</script>
