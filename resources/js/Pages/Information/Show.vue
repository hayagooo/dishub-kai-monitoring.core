<template>
    <app-layout title="Manage Team">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="$page.props.flash.message"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Informasi
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-12">
                <div class="bg-white p-7 overflow-hidden shadow-xl sm:rounded-xl">
                    <button @click="goHome()" type="button" class="py-2.5 px-5 mr-2 mb-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <arrow-left-icon size="18" class="inline-block mr-3"/>
                        <span class="inline-block">Kembali</span>
                    </button>
                    <h5 class="font-semibold text-2xl">{{ information.title }}</h5>
                    <p class="text-lg text-gray-400">{{ showTimestamps(information.created_at) }}</p>
                    <img v-if="information.image != null" class="rounded-lg w-full" :src="`/information/image/${information.image}`" :alt="information.image">
                    <div v-if="information.description != null" class="mt-6" v-html="information.description"></div>
                </div>
            </div>
            <div v-if="information.link != null || information.document != null" class="fixed text-right w-full bottom-0 left-0 p-5">
                <div class="bg-white p-4 rounded-xl shadow inline-block w-56 text-center">
                    <a v-if="information.link != null" :href="information.link" type="button" class="w-full focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        <file-text-icon size="18" class="inline-block"/>
                        <span class="inline-block ml-2">Buka tautan</span>
                    </a>
                    <a v-if="information.document != null" :href="route('app.information.download', {id: information.id})" type="button" class="w-full focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        <file-text-icon size="18" class="inline-block"/>
                        <span class="inline-block ml-2">Unduh dokument</span>
                    </a>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import moment from 'moment'
import { ArrowLeftIcon, FileTextIcon } from '@zhuowenli/vue-feather-icons'
import axios from 'axios'
import AppLayout from '@/Layouts/AppLayout.vue'
export default defineComponent({
    props: ['information'],
    data() {
        return {
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
        }
    },
    components: {
        AppLayout,
        ArrowLeftIcon,
        FileTextIcon,
    },
    methods: {
        showTimestamps(timestamp) {
            return moment(timestamp).format('dddd, DD MMMM YYYY, HH:SS')
        },
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        onViewFile() {
            if(this.information.document == null) window.open(this.information.link)
            else {
                axios.get(this.route('app.information.download'), {
                    id: this.information.id
                })
            }
        },
    }
})
</script>
