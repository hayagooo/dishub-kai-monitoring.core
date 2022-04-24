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

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7 border-b-2 border-gray-100">
                        <button @click="goObject()" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
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
                         <div class="col-span-2 md:col-span-1 p-7 border-b-2 md:border-b-0 border-gray-100 flex flex-nowrap">
                            <img v-if="category.icon == null" src="@/Assets/defaults/category.png" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+category.icon" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ category.name }}</p>
                        </div>
                        <div class="col-span-2 md:col-span-1 p-7 flex flex-nowrap">
                            <img v-if="object.icon == null" src="@/Assets/defaults/object.png" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+object.icon" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ object.name }}</p>
                        </div>
                    </div>
                    <div id="objects" class="bg-gray-50 relative sm:rounded-xl p-7">
                        <div v-if="$page.props.user.level != 'user'">
                            <button @click="goCreate()" type="button" class="w-full mb-4 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                <plus-circle-icon size="18" class="inline-block mr-4"/>
                                <span class="inline-block">
                                    Monitoring Sekarang
                                </span>
                            </button>
                            <button v-if="monitorings.data.length > 0" type="button" @click="onExportExcel()" class="w-full text-purple-700 border border-purple-700 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                <file-icon size="18" class="inline-block mr-4"/>
                                <span class="inline-block">
                                    Export Excel
                                </span>
                            </button>
                        </div>
                        <h2 class="text-xl text-gray-700 my-2 font-semibold">Daftar Monitoring</h2>
                        <div class="grid grid-cols-3 gap-x-4 mt-3">
                            <div class="col-span-2">
                                <input @keyup="onSearch()" placeholder="Cari berdasarkan judul monitoring" v-model="dataNeed.title" type="text" id="title-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div class="col-span-1">
                                <select @change="onSearch()" id="sort-select" v-model="dataNeed.sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option v-for="(item, index) in sorts" :key="`value-sort-${index}`" :value="item.value">{{ item.label }}</option>
                                </select>
                            </div>
                        </div>
                        <div v-if="monitorings.data.length > 0">
                            <div class="grid grid-cols-4 md:grid-cols-3 gap-6 mt-3">
                                <div class="col-span-4 md:col-span-3" v-for="(item, index) in monitorings.data" :key="`object-${index}`">
                                    <div role="button" class="text-center transition-all ease-in-out relative rounded-lg bg-white hover:shadow-lg">
                                        <div class="absolute right-0 top-0 p-2 z-20">
                                            <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2 mt-1">
                                                <more-vertical-icon size="20"/>
                                            </button>
                                        </div>
                                        <div class="w-10/12 text-left p-4 z-10">
                                            <p class="text-lg font-semibold text-dark">{{ item.title }}</p>
                                            <div class="flex flex-nowrap mt-5 mb-5 md:mb-0">
                                                <div class="self-center flex -space-x-4">
                                                    <img class="w-12 h-12 border-2 border-white rounded-full dark:border-gray-800" :src="`https://via.placeholder.com/300x300/6c2bd9/ffffff.png?text=${initialsString(item.team.name)}`" alt="">
                                                    <img class="w-12 h-12 border-2 border-white rounded-full dark:border-gray-800" src="@/Assets/avatar/male.png" alt="User Avatar">
                                                </div>
                                                <div class="self-center ml-4">
                                                    <p class="text-base">{{ item.team.name }}</p>
                                                    <p class="text-sm text-gray-500">{{ item.employee.name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="absolute right-0 bottom-0 py-3 px-4 z-0">
                                            <p class="text-gray-500 text-sm">{{ showTimestamps(item.created_at) }}</p>
                                        </div>
                                    </div>
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
                                                <div v-if="$page.props.user.level != 'user' && optionModal.index != null" @click="goInput(monitorings.data[optionModal.index].id)" role="button" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                    <div class="flex h-12 w-12 rounded-lg bg-indigo-100 relative">
                                                        <file-text-icon class="mx-auto text-indigo-600 self-center" size="24"/>
                                                    </div>
                                                    <div class="self-center">
                                                        <p class="text-lg font-semi-bold text-gray-700">Formulir Object</p>
                                                        <small v-if="monitorings.data[optionModal.index] != undefined">{{ monitorings.data[optionModal.index].input.length }} Data</small>
                                                    </div>
                                                </div>
                                                <div @click="gotoEditMonitoring()" role="button" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
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
                                                    Hapus Data ?
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
                                                    Data monitoring dan data yang terkait seperti gambar akan terhapus secara permanen.
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
                            <div id="pagination-data" class="flex w-full mt-3 justify-end">
                                <m-pagination-data :paginationData="monitorings" :data="dataNeed" :preserveState="false"/>
                            </div>
                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Belum ada kegiatan monitoring"/>
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
import MPaginationData from '@/Components/MPaginationData'
import AppLayout from '@/Layouts/AppLayout.vue'
import moment from 'moment'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, PlusCircleIcon, FileIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['object', 'category', 'monitorings'],
    components: {
        FileIcon,
        MoreVerticalIcon,
        EyeIcon,
        MToast,
        AppLayout,
        FileTextIcon,
        TrashIcon,
        MNoData,
        EditIcon,
        ArrowLeftIcon,
        MPaginationData,
        ImageIcon,
        PlusCircleIcon,
        MUnderConstruction,
    },
    data() {
        return {
            dataNeed: { categoryId: this.category.id , objectId: this.object.id, title: '', sort: 'desc'},
            sorts: [
                { value: 'desc', label: 'Paling baru' },
                { value: 'asc', label: 'Paling lama' },
            ],
            optionModal: {
                show: false,
                index: null,
                item: null,
            },
            deleteModal: {
                show: false,
                index: null
            },
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
            form: this.$inertia.form({
                preview: null,
                name: '',
                icon: null,
            }),
        }
    },
    mounted() {
        console.log(this.category)
        this.toast.active = this.$page.props.flash.message != null || this.$page.props.flash.message != undefined ? true : false
        if(this.$page.props.flash.status == 'success') this.toast.color = 'green'
        else if(this.$page.props.flash.status == 'failed') this.toast.color = 'red'
        setTimeout(() => {
            this.toast.active = false
        }, 5000);
    },
    methods: {
        goInput(monitoring_id) {
            this.toggleOptionModal(false)
            this.$inertia.get(this.route('app.input.index'), {
                categoryId: this.category.id,
                objectId: this.object.id,
                monitoringId: monitoring_id
            })
        },
        goCategory() {
            this.$inertia.get(this.route('app.category.index'))
        },
        goObject() {
            this.$inertia.get(this.route('app.object.index'), {
                categoryId: this.category.id
            })
        },
        onSearch() {
            this.$inertia.get(this.route('app.monitoring.index'), {
                categoryId: this.dataNeed.categoryId,
                objectId: this.dataNeed.objectId,
                title: this.dataNeed.title,
                sort: this.dataNeed.sort,
            }, {
                preserveState: true
            })
        },
        initialsString(str) {
            let rgx = new RegExp(/(\p{L}{1})\p{L}+/, 'gu')
            let initials = [...str.matchAll(rgx)] || []
            initials = (
                (initials.shift()?.[1] || '') + (initials.pop()?.[1] || '')
            ).toUpperCase();
            return initials
        },
        onExportExcel() {
            window.location.href = this.route('app.monitoring.export-excel')+'?categoryId='+this.category.id+'&objectId='+this.object.id
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
        goCreate() {
            this.$inertia.get(this.route('app.monitoring.create', {
                categoryId: this.category.id,
                objectId: this.object.id
            }))
        },
        gotoEditMonitoring() {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.$inertia.get(this.route('app.monitoring.edit', {
                id: this.monitorings.data[this.optionModal.index].id,
            }), {
                categoryId: this.category.id,
                menu_index: 0,
                objectId: this.object.id
            })
        },
        showTimestamps(timestamp) {
            return moment(timestamp).calendar()
        },
        deleteData() {
            this.$inertia.delete(this.route('app.monitoring.destroy', {
                id: this.monitorings.data[this.optionModal.index].id
            }), {
               onSuccess: () => {
                   this.toggleDeleteModal(false)
               }
            })
        },
        clickFile() {
            document.getElementById('icon-category').click()
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
        changeFile(e) {
            let file = e.target.files[0]
            this.form.icon = file
            this.form.preview = URL.createObjectURL(file)
        },
    },
})
</script>
