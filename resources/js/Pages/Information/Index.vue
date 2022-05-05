<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Informasi & Pemberitahuan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div id="information" class="col-span-2 lg:col-span-1 p-6">
                        <button @click="goHome()" type="button" class="py-2.5 px-5 mr-2 mb-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            <arrow-left-icon size="18" class="inline-block mr-3"/>
                            <span class="inline-block">Kembali</span>
                        </button>
                        <div class="grid grid-cols-2">
                            <div>
                                <h2 class="text-2xl text-gray-800 leading-tight font-semibold">Pemberitahuan</h2>
                            </div>
                            <div v-if="$page.props.user.level != 'user'" class="col-span-2 mt-4 md:mt-0 md:col-span-1 md:justify-self-end">
                                <button @click="toggleFormModal(true, 'create')" type="button" class="w-full focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                    <plus-circle-icon size="18" class="inline-block"/>
                                    <span class="inline-block ml-2">
                                        Pemberitahuan Baru
                                    </span>
                                </button>
                                <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <div class="flex justify-between items-start p-5 rounded-t border-b">
                                                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                    {{ formModal.mode == 'create' ? 'Pemberitahuan Baru' : 'Edit Pemberitahuan' }}
                                                </h3>
                                                <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <form @submit.prevent="submitData()" action="#">
                                                <div class="p-6 h-96 overflow-y-auto">
                                                    <div>
                                                        <input @change="changeFile" name="icon" id="image-info" type="file" class="hidden" accept=".jpg, .png, .jpeg">
                                                        <div v-if="form.information.image == null" @click="clickFile()">
                                                            <div role="button" class="w-full text-center p-6 border-2 border-dashed border-purple-500 rounded-lg">
                                                                <div class="w-full">
                                                                    <image-icon size="3x" class="inline-block text-purple-600"/>
                                                                </div>
                                                                <p v-if="form.information.image == null" class="mt-3 font-semibold text-gray-600">
                                                                    Click File or Drag and drop
                                                                </p>
                                                            </div>
                                                            <small> {{ formModal.mode == 'create' ? 'Abaikan untuk membuat gambar default' : 'Abaikan untuk tidak mengganti gambar' }} </small>
                                                        </div>
                                                        <div v-else>
                                                            <img role="button" @click="clickFile()" class="object-cover h-48 w-full object-center rounded-lg" :src="form.information.preview" :alt="form.information.image">
                                                            <div class="grid grid-cols-2 mt-2">
                                                                <div>
                                                                    <small> Klik gambar untuk mengganti gambar </small>
                                                                </div>
                                                                <div class="text-right text-red-500">
                                                                    <span @click="removeImageInfo()" role="button"><x-circle-icon class="inline-block" size="20"/> Hapus gambar</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-6">
                                                        <label for="title-info">Judul Pemberitahuan</label>
                                                        <input required name="name" id="title-info" v-model="form.information.title" type="text" placeholder="Masukkan judul informasi" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="my-6">
                                                        <label for="description-info">Deskripsi Pemberitahuan</label>
                                                        <ckeditor id="description-info" class="mt-3" placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="form.information.description"></ckeditor>
                                                    </div>
                                                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                                                        <li class="mr-2">
                                                            <span role="button" @click="setChooseDocument('document')" :class="{'inline-block py-3 px-4 text-white bg-purple-600 rounded-lg active': form.information.type == 'document',
                                                            'inline-block py-3 px-4 rounded-lg hover:text-gray-900 hover:bg-gray-100': form.information.type != 'document'}" aria-current="page">Dokumen</span>
                                                        </li>
                                                        <li class="mr-2">
                                                            <span role="button" @click="setChooseDocument('link')" :class="{'inline-block py-3 px-4 text-white bg-purple-600 rounded-lg active': form.information.type == 'link',
                                                            'inline-block py-3 px-4 rounded-lg hover:text-gray-900 hover:bg-gray-100': form.information.type != 'link'}">Tautan</span>
                                                        </li>
                                                    </ul>
                                                    <div class="mt-6">
                                                        <div v-if="form.information.type == 'document'">
                                                            <label for="link-info">Dokumen Pemberitahuan</label>
                                                            <div v-if="form.information.document != null" class="flex bg-white p-4 mt-3 rounded-lg shadow-lg gap-x-4 relative">
                                                                <div @click="onRemoveFile()" role="button" class="absolute right-0 top-0 m-6">
                                                                    <x-circle-icon class="text-gray-600" size="20"/>
                                                                </div>
                                                                <div>
                                                                    <img class="h-10 w-auto" :src="`/image/icon/${form.information.type_document}.png`" :alt="form.information.type_document">
                                                                </div>
                                                                <div class="justify-self-stretch self-center pr-6">
                                                                    {{ formModal.mode == 'create' ? form.information.document.name : form.information.document }}
                                                                </div>
                                                            </div>
                                                            <div v-else class="mt-3">
                                                                <input @change="onUploadFileInput($event)"
                                                                type="file" accept=".xlsx,.pdf,.doc,.docx,.xls,.csv,.ppt,.pptx"
                                                                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent">
                                                            </div>
                                                        </div>
                                                        <div v-if="form.information.type == 'link'">
                                                            <label for="link-info">Tautan Dokumen Pemberitahuan</label>
                                                            <input required name="name" id="link-info" v-model="form.information.link" type="text" placeholder="Masukkan tautan kategori" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                    <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Simpan
                                                    </button>
                                                    <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="content-information" class="mt-4">
                            <div v-if="informations.data.length > 0">
                                <div class="grid grid-cols-3 gap-x-4 my-3">
                                    <div class="col-span-2">
                                        <input @keyup="onSearch()" placeholder="Cari berdasarkan judul informasi" v-model="dataNeed.title" type="text" id="title-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    </div>
                                    <div class="col-span-1">
                                        <select @change="onSearch()" id="sort-select" v-model="dataNeed.sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option v-for="(item, index) in sorts" :key="`value-sort-${index}`" :value="item.value">{{ item.label }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div v-for="(item, index) in informations.data" :key="index" class="grid grid-cols-3 relative mb-3 flex-col items-center bg-white rounded-lg border shadow-md hover:bg-gray-100">
                                    <div v-if="$page.props.user.level != 'user'" class="absolute right-0 top-0 p-3">
                                        <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2 mt-1">
                                            <more-vertical-icon size="20"/>
                                        </button>
                                    </div>
                                    <div class="col-span-1 relative w-full h-full">
                                        <img v-if="item.image == null" class="object-cover absolute top-0 bottom-0 left-0 h-full w-full rounded-l-lg" src="/images/information1.png" alt="Pemberitahuan">
                                        <img v-else class="object-cover absolute top-0 bottom-0 left-0 h-full w-full rounded-l-lg" :src="`/information/image/${item.image}`" alt="Pemberitahuan">
                                    </div>
                                    <div class="col-span-2 justify-between p-4 leading-normal">
                                        <div class="h-28 md:h-20 pr-6">
                                            <h5 class="text-lg font-bold tracking-tight text-gray-900">{{ truncating(item.title, 80, '...') }}</h5>
                                            <small>{{ showTimestamps(item.created_at) }}</small>
                                        </div>
                                        <div class="text-right">
                                            <button @click="show(item)" class="inline-block ml-auto items-center py-2 px-3 text-sm font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300">
                                                <span class="inline-block mr-2">
                                                    Selengkapnya
                                                </span>
                                                <arrow-right-icon size="18" class="inline-block"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="option-modal" tabindex="-1" :class="{'hidden' : !optionModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                    Pengaturan Informasi
                                                </h3>
                                                <button @click="toggleOptionModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <div class="p-6 space-y-4">
                                                <div role="button" @click="show(informations.data[optionModal.index])" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                    <div class="flex h-12 w-12 rounded-lg bg-purple-100 relative">
                                                        <eye-icon class="mx-auto text-purple-600 self-center" size="24"/>
                                                    </div>
                                                    <div>
                                                        <p class="text-lg font-semi-bold text-gray-700 pt-2">Lihat Data</p>
                                                    </div>
                                                </div>
                                                <div role="button" @click="toggleFormModal(true, 'edit', optionModal.index)" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
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

                                <div id="delete-modal" tabindex="-1" :class="{'hidden' : !deleteModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                    Hapus Informasi ?
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
                                                    Informasi pemberitahuan ini akan tehapus secara permanen.
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

                                <div id="pagination-data" class="flex w-full mt-3 justify-end">
                                    <m-pagination-data :paginationData="informations" :data="dataNeed" :preserveState="false"/>
                                </div>
                            </div>
                            <div v-else class="text-center">
                                <m-no-data text="Tidak ada pemberitahuan"/>
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
import { PlusCircleIcon, ArrowRightIcon, ArrowLeftIcon, ImageIcon, XCircleIcon, MoreVerticalIcon, EyeIcon, EditIcon, TrashIcon } from '@zhuowenli/vue-feather-icons'
import MToast from '@/Components/MToast'
import AppLayout from '@/Layouts/AppLayout.vue'
import moment from 'moment'
import MPaginationData from '@/Components/MPaginationData'
import MNoData from '@/Components/MNoData.vue'
import CKEditor from '@ckeditor/ckeditor5-vue'
import InlineEditor from '@ckeditor/ckeditor5-build-inline'

export default defineComponent({
    props: ['informations'],
    data() {
        return {
            dataNeed: {
                title: '',
                sort: 'desc'
            },
            sorts: [
                { value: 'desc', label: 'Paling baru' },
                { value: 'asc', label: 'Paling lama' },
            ],
            editor: InlineEditor,
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
            formModal : {
                show: false,
                mode: 'create',
                index: null,
            },
            deleteModal: {
                show: false,
                index: null
            },
            optionModal: {
                show: false,
                index: null,
                item: null,
            },
            form: {
                information: this.$inertia.form({
                    title: '',
                    link: '',
                    type: 'document',
                    preview: null,
                    image: null,
                    type_document: null,
                    document: null,
                    description: '',
                })
            }
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
    components: {
        AppLayout,
        ArrowRightIcon,
        MPaginationData,
        ArrowLeftIcon,
        XCircleIcon,
        MoreVerticalIcon,
        EyeIcon,
        EditIcon,
        TrashIcon,
        ImageIcon,
        MToast,
        ckeditor: CKEditor.component,
        MNoData,
        PlusCircleIcon,
    },
    methods: {
        truncating(text, length, suffix) {
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
            }
        },
        generateSlug(text) {
            return text.toString().toLowerCase()
            .replace(/^-+/, '')
            .replace(/-+$/, '')
            .replace(/\s+/g, '-')
            .replace(/\-\-+/g, '-')
            .replace(/[^\w\-]+/g, '');
        },
        showTimestamps(timestamp) {
            return moment(timestamp).format('dddd, DD MMMM YYYY')
        },
        setChooseDocument(type) {
            this.form.information.type = type
            if(this.formModal.mode == 'create') {
                this.form.information.document = null
                this.form.information.link = ''
            }
        },
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        onSearch() {
            this.$inertia.get(this.route('app.information.index'), {
                title: this.dataNeed.title,
                sort: this.dataNeed.sort,
            }, {
                preserveState: true
            })
        },
        toggleOptionModal(status, index = null, item = null) {
            this.setOverflow(status)
            this.optionModal.show = status
            this.optionModal.index = index
            this.optionModal.item = item
        },
        onRemoveFile() {
            if(this.formModal.mode == 'create') {
                this.form.information.document = null
            }
        },
        removeImageInfo() {
            this.form.information.image = null
            this.form.information.preview = null
        },
        clickFile() {
            document.getElementById('image-info').click()
        },
        changeFile(e) {
            let file = e.target.files[0]
            this.form.information.image = file
            this.form.information.preview = URL.createObjectURL(file)
        },
        setNullForm() {
            this.form.information.title = ''
            this.form.information.link = ''
            this.form.information.image = null
            this.form.information.preview = null
            this.form.information.type_document = null
            this.form.information.document = null
            this.form.information.description = ''
        },
        show(information) {
            this.setOverflow(false)
            this.$inertia.get(this.route('app.information.show', {
                id: information.id
            }), {
                title: this.generateSlug(information.title)
            })
        },
        submitData() {
            let route_url
            if(this.formModal.mode == 'create') {
                route_url = this.route('app.information.store')
                this.form.information.post(route_url,  {
                    onFinish: () => this.toggleFormModal(false)
                })
            }
            else {
                route_url = this.route('app.information.update', {id : this.informations.data[this.optionModal.index].id})
                this.form.information.transform(
                    data => ({
                        ...data,
                        _method: 'PATCH'
                    })
                ).post(route_url, {
                onFinish: () => this.toggleFormModal(false)
            })
            }
        },
        deleteData() {
            this.$inertia.delete(this.route('app.information.destroy', {
                id: this.informations.data[this.optionModal.index].id
            }), {
                onFinish: () => this.toggleDeleteModal(false, null),
            })
        },
        onUploadFileInput(e) {
            let file = e.target.files[0]
            this.files_input = file
            let images_files = ['png', 'jpg', 'jpeg']
            let docs_files = ['doc', 'docx']
            let excels_files = ['xlsx', 'xls']
            let ppt_files = ['ppt', 'pptx']
            let result
            let filename = file.name
            let extension = filename.split('.').pop()
            if(images_files.includes(extension)) result = 'image'
            else if(docs_files.includes(extension)) result = 'document'
            else if(excels_files.includes(extension)) result = 'excel'
            else if(ppt_files.includes(extension)) result = 'ppt'
            else if(extension == 'pdf') result = 'pdf'
            else {
                alert('File format tidak didukung')
                return false
            }
            this.form.information.type_document = result
            this.form.information.document = file
        },
        setOverflow(status) {
            let body = document.querySelector('body').classList
            if(status == true)  body.add('overflow-hidden')
            else body.remove('overflow-hidden')
        },
        toggleFormModal(status, mode = 'create', indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                let document_info = this.informations.data[indexId].document
                if(document_info != null) {
                    let get_type = document_info.split('.').pop()
                    this.form.information.type_document = get_type
                    this.form.information.document = document_info
                }
                this.form.information.title = this.informations.data[indexId].title
                this.form.information.link = this.informations.data[indexId].link
                this.form.information.image = this.informations.data[indexId].image
                this.form.information.preview = `/information/image/${this.informations.data[indexId].image}`
                this.form.information.description = this.informations.data[indexId].description
            } else this.setNullForm()
            this.formModal.show = status
            if(!status) this.setNullForm()
            this.formModal.mode = mode
        },
        toggleDeleteModal(status, index = null) {
            if(status == true) this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.deleteModal.show = status
            this.deleteModal.index = index
        },
        gotoIndex(path) {
            this.$inertia.get(this.route(path), {preserveState: true})
        },
    }
})
</script>

<style scoped>
.ck-editor__editable_inline {
    border: 2px solid gainsboro;
    border-radius: 12px !important;
}
</style>
