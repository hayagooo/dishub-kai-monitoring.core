<template>
    <app-layout title="Monitoring">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="$page.props.flash.message"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitoring
            </h2>
        </template>

        <div class="fixed bottom-0 md:inset-y-0 right-0 p-8 w-full md:w-40 flex z-50">
            <div class="self-center inline-block w-full text-center md:w-auto bg-white shadow p-4 text-sm rounded-lg">
                <div class="relative inline-block">
                    <button @mouseover="toggleTooltip('plus-circle')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 mb-0 md:mb-3 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <plus-circle-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'plus-circle', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'plus-circle'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Input Baru
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>
                <div class="relative inline-block">
                    <button @mouseover="toggleTooltip('image')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 mb-0 md:mb-3 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <image-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'image', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'image'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Gambar Baru
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>
                <div class="relative inline-block">
                    <button @mouseover="toggleTooltip('file-document')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 mb-0 md:mb-3 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <file-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'file-document', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'file-document'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Dokumen Baru
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>
                <div class="relative inline-block">
                    <button @mouseover="toggleTooltip('description')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 mb-0 md:mb-3 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <type-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'description', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'description'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Deskripsi & Judul
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>
                <div class="relative inline-block">
                    <button @mouseover="toggleTooltip('media-youtube')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <youtube-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'media-youtube', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'media-youtube'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Media Youtube
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7 border-b-2 border-gray-100">
                        <button @click="goBack()" type="button" class="py-2.5 mx-2 md:mx-0 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            <arrow-left-icon size="18" class="inline-block mr-3"/>
                            <span class="inline-block">Kembali</span>
                        </button>
                        <div class="mt-6 relative">
                            <img src="@/Assets/features/monitoring.png" class="inline-block h-16 md:h-20 w-auto" alt="Monitoring">
                            <span class="inline-block text-lg md:text-2xl text-gray-600 ml-6 font-semibold">
                                Monitoring Data
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2">
                         <div v-if="datas.category != null && datas.category != undefined" class="border-gray-100 flex flex-nowrap p-7"
                            :class="{'col-span-2 md:col-span-1 border-b-2 md:border-b-0': datas.object != null && datas.object != undefined,
                                'col-span-2': datas.object == null || datas.monitoring == undefined}">
                            <img src="@/Assets/defaults/category.png" class="h-12 w-auto inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-xl text-gray-700 inline-block ml-4">{{ datas.category.name }}</p>
                        </div>
                        <div v-if="datas.object != null && datas.object != undefined" class="col-span-2 md:col-span-1 p-7 flex flex-nowrap">
                            <img src="@/Assets/defaults/object.png" class="h-12 w-auto inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-xl text-gray-700 inline-block ml-4">{{ datas.object.name }}</p>
                        </div>
                    </div>
                    <div id="objects" class="bg-gray-50 relative sm:rounded-xl p-7">
                        <div class="my-2">
                            <h2 class="text-xl text-gray-700 font-semibold">Data Formulir</h2>
                            <p class="text-base text-gray-600">Formulir berdasarkan kebutuhan {{ setModelByData() }}.</p>
                        </div>
                        <div v-if="inputs.length > 0">
                            <div class="grid grid-cols-4 md:grid-cols-3 gap-6 mt-3">
                                <div class="col-span-4 md:col-span-3" v-for="(item, index) in inputs" :key="`input-${index}`">
                                    {{ item.label }}
                                </div>

                                <div id="option-modal" tabindex="-1" :class="{'hidden' : !optionModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                    Pengaturan Monitoring
                                                </h3>
                                                <button @click="toggleOptionModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <div class="p-6 space-y-4">
                                                <div role="button" @click="gotoMonitoring(category.id, objects[optionModal.index].id)" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                    <div class="flex h-12 w-12 rounded-lg bg-purple-100 relative">
                                                        <eye-icon class="mx-auto text-purple-600 self-center" size="24"/>
                                                    </div>
                                                    <div>
                                                        <p class="text-lg font-semi-bold text-gray-700 pt-2">Lihat Data</p>
                                                    </div>
                                                </div>
                                                <div v-if="$page.props.user.level != 'user'" role="button" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                    <div class="flex h-12 w-12 rounded-lg bg-indigo-100 relative">
                                                        <file-text-icon class="mx-auto text-indigo-600 self-center" size="24"/>
                                                    </div>
                                                    <div>
                                                        <p class="text-lg font-semi-bold text-gray-700 pt-2">Formulir Monitoring</p>
                                                    </div>
                                                </div>
                                                <div role="button" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                    <div class="flex h-12 w-12 rounded-lg bg-green-100 relative">
                                                        <edit-icon class="mx-auto text-green-600 self-center" size="24"/>
                                                    </div>
                                                    <div>
                                                        <p class="text-lg font-semi-bold text-gray-700 pt-2">Edit Data</p>
                                                    </div>
                                                </div>
                                                <div role="button" @click="toggleDeleteModal(true, optionModal.index)" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                    <div class="flex h-12 w-12 rounded-lg bg-red-100 relative">
                                                        <trash-icon class="mx-auto text-red-600 self-center" size="24"/>
                                                    </div>
                                                    <div>
                                                        <p class="text-lg font-semi-bold text-gray-700 pt-2">Hapus Data</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-row-reverse items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                <button @click="toggleOptionModal(false)" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="option-modal" tabindex="-1" :class="{'hidden' : !deleteModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                    Hapus Objek ?
                                                </h3>
                                                <button @click="toggleDeleteModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <div class="p-6 space-y-4">
                                                <div class="flex justify-center">
                                                    <div class="flex h-14 w-14 rounded-lg bg-red-100 relative">
                                                        <trash-icon class="text-red-600 self-center mx-auto" size="30"/>
                                                    </div>
                                                </div>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 text-center text-dark">
                                                    Objek dan monitoring data berdasarkan objek ini akan tehapus secara permanen
                                                </h3>
                                                <div class="flex justify-between">
                                                    <button @click="toggleDeleteModal(false)" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                                                    <button @click="deleteData()" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Belum ada data formulir"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import MToast from '@/Components/MToast'
import AppLayout from '@/Layouts/AppLayout.vue'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, PlusCircleIcon, FileIcon, YoutubeIcon, TypeIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['inputs', 'datas'],
    components: {
        FileIcon,
        YoutubeIcon,
        MoreVerticalIcon,
        EyeIcon,
        AppLayout,
        MToast,
        TypeIcon,
        FileTextIcon,
        TrashIcon,
        MNoData,
        EditIcon,
        ArrowLeftIcon,
        ImageIcon,
        PlusCircleIcon,
        MUnderConstruction,
    },
    data() {
        return {
            optionModal: {
                show: false,
                index: null,
                item: null,
            },
            tooltip: {
                show: null,
            },
            deleteModal: {
                show: false,
                index: null
            },
            form: this.$inertia.form({
                preview: null,
                name: '',
                icon: null,
            }),
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
        }
    },
    mounted() {
        this.toast.active = this.$page.props.flash.message != null || this.$page.props.flash.message != undefined ? true : false
        if(this.$page.props.flash.status == 'success') this.toast.color = 'green'
        else if(this.$page.props.flash.status == 'failed') this.toast.color = 'red'
        setTimeout(() => {
            this.toast.active = false
        }, 5000);
    },
    methods: {
        toggleTooltip(element = null) {
            this.tooltip.show = element
            console.log(this.tooltip.show)
        },
        goBack() {
            if(this.datas.monitoring != null && this.datas.monitoring != undefined) {
                this.$inertia.get(this.route('app.monitoring.index'), {
                    categoryId: this.datas.category.id,
                    objectId: this.datas.object.id,
                })
            }
            else if(this.datas.object != null && this.datas.object != undefined) {
                this.$inertia.get(this.route('app.object.index'), {
                    categoryId: this.datas.category.id
                })
            }
            else {
                this.$inertia.get(this.route('app.category.index'))
            }
        },
        setModelByData() {
            var model_name = ''
            if(this.datas.monitoring != null && this.datas.monitoring != undefined) model_name = 'monitoring data'
            else if(this.datas.object != null && this.datas.object != undefined) model_name = 'objek'
            else model_name = 'kategori'
            return model_name
        },
        goObject() {
            this.$inertia.get(this.route('app.object.index'), {
                categoryId: this.category.id
            })
        },
        store() {
            if(this.formModal.mode == 'create') {
                this.form.post(this.route('app.object.store'))
            } else {
                this.form.transform(data => ({
                    ... data,
                    _method: 'PATCH'
                })).post(this.route('app.object.update', {
                    id: this.objects[this.optionModal.index].id
                }))
            }
        },
        deleteData() {
            this.$inertia.delete(this.route('app.object.destroy', {
                id: this.objects[this.optionModal.index].id
            }), {
               onSuccess: () => {
                   this.toggleDeleteModal(false)
               }
            })
        },
        setOverflow(status) {
            let body = document.querySelector('body').classList
            if(status == true)  body.add('overflow-hidden')
            else body.remove('overflow-hidden')
        },
        setNullForm() {
            this.form.name = ''
            this.form.icon = null
        },
        toggleOptionModal(status, index = null, item = null) {
            this.setOverflow(status)
            this.optionModal.show = status
            this.optionModal.index = index
            this.optionModal.item = item
        },
        toggleDeleteModal(status, index = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.deleteModal.show = status
            this.deleteModal.index = index
        },
    },
})
</script>
