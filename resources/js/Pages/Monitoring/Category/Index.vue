<template>
    <app-layout title="Monitoring">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="$page.props.flash.message"/>
        <m-error-toast
            :is_active="error.active"
            :message="error.message"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitoring
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7">
                        <button @click="goHome()" type="button" class="hidden md:inline-block py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
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
                    <div id="categories" class="bg-gray-50 relative sm:rounded-xl p-7">
                        <h2 class="text-xl text-gray-700 font-semibold">Kategori Monitoring</h2>
                        <div v-if="$page.props.user.level != 'user'">
                            <button @click="toggleFormModal(true, 'create')" type="button" class="w-full mt-4 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                <plus-circle-icon size="18" class="inline-block mr-4"/>
                                <span class="inline-block">
                                    Tambah Kategori
                                </span>
                            </button>
                            <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <div class="flex justify-between items-start p-5 rounded-t border-b">
                                            <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                {{ formModal.mode == 'create' ? 'Kategori Baru' : 'Edit Kategori' }}
                                            </h3>
                                            <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <form @submit.prevent="store()" action="#">
                                            <div class="p-6 max-h-96 overflow-y-auto">
                                                <div class="text-center">
                                                    <div v-if="formModal.mode == 'create'">
                                                        <div class="h-20 w-20 inline-block relative rounded-lg overflow-hidden">
                                                            <img v-if="form.preview == null" src="@/Assets/defaults/category.png" class="h-20 w-auto inline-block" alt="Default Icon">
                                                            <img v-else :src="form.preview" class="h-20 w-auto inline-block" alt="Default Icon">
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="h-20 w-20 inline-block relative rounded-lg overflow-hidden">
                                                            <div class="h-20 w-20 inline-block relative rounded-lg overflow-hidden">
                                                                <img v-if="form.icon == null" src="@/Assets/defaults/category.png" class="h-20 w-auto inline-block" alt="Default Icon">
                                                                <img v-else :src="form.preview" class="h-20 w-20 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="name-category">Nama Kategori</label>
                                                    <input maxlength="100" required name="name" id="name-category" v-model="form.name" type="text" placeholder="Masukkan nama kategori" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="mt-6">
                                                    <div class="flex justify-between mb-3">
                                                        <div>
                                                            <label for="icon-category">Icon Kategori</label>
                                                        </div>
                                                        <div v-if="form.icon != null">
                                                            <div class="text-right">
                                                                <button type="button" @click="onDeleteImage()" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 d-inline-block focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 text-right">
                                                                    Hapus icon
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input @change="changeFile" name="icon" id="icon-category" type="file" class="hidden" accept=".jpg, .png, .jpeg">
                                                    <div @click="clickFile()" role="button" class="w-full text-center p-6 border-2 border-dashed border-purple-500 rounded-lg">
                                                        <div class="w-full">
                                                            <image-icon size="3x" class="inline-block text-purple-600"/>
                                                        </div>
                                                        <p v-if="form.icon == null" class="mt-3 font-semibold text-gray-600">
                                                            Tambahkan Gambar<br>
                                                            <small>Rekomendasi ukuran : 48 x 48 pixel, Maksimal 2mb</small>
                                                        </p>
                                                        <p v-else>
                                                            {{ truncating(formModal.mode == 'create' ? form.icon.name : form.icon.name != null && form.icon.name != undefined ? form.icon.name : form.icon, 50, '...') }} <br>
                                                            <small>Rekomendasi ukuran : 48 x 48 pixel, Maksimal 2mb</small>
                                                        </p>
                                                    </div>
                                                    <small> {{ formModal.mode == 'create' ? 'Abaikan untuk membuat icon default' : 'Abaikan untuk tidak mengganti icon, Maksimal 2mb' }}</small>
                                                </div>
                                            </div>
                                            <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                <button :disabled="loading_button" type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <span v-if="!loading_button">
                                                        Simpan
                                                    </span>
                                                    <span v-else>
                                                        <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                        </svg>
                                                        Proses...
                                                    </span>
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
                        <div v-if="categories.length > 0">
                            <div class="mt-3 mb-4" v-for="(item, index) in categories" :key="`category-${index}`">
                                <div role="button" class="transition-all ease-in-out relative flex gap-x-4 rounded-lg bg-white hover:shadow-lg">
                                    <div role="button" @click="gotoObject(item.id)" class="flex w-9/12 gap-x-4 p-4">
                                        <div v-if="item.icon != null" class="h-12 w-12 inline-block relative rounded-lg overflow-hidden">
                                            <img :src="'/monitoring/icon/'+item.icon" class="h-full w-full object-cover object-center inline-block" alt="Preview Icon">
                                        </div>
                                        <div v-else>
                                            <img src="@/Assets/defaults/category.png" class="h-12 w-auto inline-block self-center" alt="Default Icon">
                                        </div>
                                        <div class="self-center">
                                            <p class="text-base md:text-lg font-semibold">{{ truncating(item.name, 25, '...') }}</p>
                                        </div>
                                    </div>
                                    <div v-if="$page.props.user.level != 'user'" class="absolute right-0 top-0 p-4">
                                        <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2 mt-1">
                                            <more-vertical-icon size="20"/>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="option-modal" tabindex="-1" :class="{'hidden' : !optionModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                Pengaturan Kategori
                                            </h3>
                                            <button @click="toggleOptionModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 max-h-96 overflow-y-auto space-y-4">
                                            <div role="button" @click="gotoObject(categories[optionModal.index].id)" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                <div class="flex h-12 w-12 rounded-lg bg-purple-100 relative">
                                                    <eye-icon class="mx-auto text-purple-600 self-center" size="24"/>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-semi-bold text-gray-700 pt-2">Lihat Data</p>
                                                </div>
                                            </div>
                                            <div v-if="$page.props.user.level != 'user' && optionModal.index != null" @click="goInput(categories[optionModal.index].id)" role="button" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                <div class="flex h-12 w-12 rounded-lg bg-indigo-100 relative">
                                                    <file-text-icon class="mx-auto text-indigo-600 self-center" size="24"/>
                                                </div>
                                                <div class="self-center">
                                                    <p class="text-lg font-semi-bold text-gray-700">Formulir Kategori</p>
                                                    <small v-if="categories[optionModal.index] != undefined">{{ categories[optionModal.index].input.length }} Data</small>
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
                                                Hapus Kategori ?
                                            </h3>
                                            <button @click="toggleDeleteModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 max-h-96 overflow-y-auto space-y-4">
                                            <div class="flex justify-center">
                                                <div class="flex h-14 w-14 rounded-lg bg-red-100 relative">
                                                    <trash-icon class="text-red-600 self-center mx-auto" size="30"/>
                                                </div>
                                            </div>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 text-center text-dark">
                                                Kategori dan monitoring data berdasarkan kategori ini akan tehapus secara permanen
                                            </h3>
                                            <div class="flex justify-between">
                                                <button @click="toggleDeleteModal(false)" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                                                <button :disabled="loading_button" @click="deleteData()" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    <span v-if="!loading_button">
                                                        Hapus
                                                    </span>
                                                    <span v-else>
                                                        <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                        </svg>
                                                        Proses...
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Tidak ada kategori" link_route="app.category.index"/>
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
import { ArrowLeftIcon, PlusCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MToast from '@/Components/MToast'
import MErrorToast from '@/Components/MErrorToast'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['categories'],
    components: {
        MoreVerticalIcon,
        FileTextIcon,
        EyeIcon,
        AppLayout,
        TrashIcon,
        MNoData,
        MErrorToast,
        EditIcon,
        ArrowLeftIcon,
        ImageIcon,
        PlusCircleIcon,
        MToast,
        MUnderConstruction,
    },
    data() {
        return {
            formModal : {
                show: false,
                mode: 'create',
                index: null,
            },
            loading_button: false,
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
            error: {
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
    methods: {
        truncating(text, length, suffix) {
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
            }
        },
        onDeleteImage() {
            if(this.formModal.mode == 'create') {
                this.form.preview = null
                this.form.icon = null
            } else {
                if(this.categories[this.optionModal.index].icon != null) {
                    this.$inertia.post(this.route('app.category.delete-image', {
                        id: this.categories[this.optionModal.index].id
                    }), {
                        preserveState: true,
                        preserveScroll: true,
                    })
                }
                this.form.preview = null
                this.form.icon = null
            }
        },
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        goInput(category_id) {
            this.toggleOptionModal(false)
            this.$inertia.get(this.route('app.input.index'), {
                categoryId: category_id
            })
        },
        onToast(response) {
            this.toast.active = response.props.flash.message != null || response.props.flash.message != undefined ? true : false
            if(response.props.flash.status == 'success') this.toast.color = 'green'
            else if(response.props.flash.status == 'failed') this.toast.color = 'red'
            setTimeout(() => {
                this.toast.active = false
            }, 5000);
        },
        onErrorToast(errors) {
            console.log(errors)
            this.error.message = errors
            this.error.active = true
            setTimeout(() => {
                this.error.active = false
            }, 5000);
        },
        store() {
            this.loading_button = true
            if(this.formModal.mode == 'create') {
                this.form.transform(data => ({
                    ... data,
                    _method: 'POST'
                })).post(this.route('app.category.store'),
                {
                    onFinish: (response) => {
                        this.loading_button = false
                    },
                    onSuccess: (response) => {
                        this.toggleFormModal(false)
                        this.onToast(response)
                        this.setNullForm()
                    },
                    onError: (errors) => { this.onErrorToast(errors) }
                })
            } else {
                this.form.transform(data => ({
                    ... data,
                    _method: 'PATCH'
                })).post(this.route('app.category.update', { id: this.categories[this.optionModal.index].id }),
                {
                    onFinish: (response) => {
                        this.loading_button = false
                    },
                    onSuccess: (response) => {
                        this.onToast(response)
                        this.toggleFormModal(false)
                        this.setNullForm()
                    },
                    onError: (errors) => { this.onErrorToast(errors) }
                })
            }
        },
        deleteData() {
            this.loading_button = true
            this.$inertia.delete(this.route('app.category.destroy', { id: this.categories[this.optionModal.index].id  }),
            {
                onFinish: (response) => {
                    this.loading_button = false
                },
                onSuccess: (response) => {
                    this.toggleDeleteModal(false)
                    this.onToast(response)
                    this.setNullForm()
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
            this.form.preview = null
            this.form.icon = null
        },
        gotoObject(category_id) {
            this.toggleOptionModal(false)
            this.$inertia.get(this.route('app.object.index'), {
                categoryId: category_id
            })
        },
        toggleFormModal(status, mode = 'create', indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null && mode == 'edit') {
                this.form.name = this.categories[indexId].name
                this.form.icon = this.categories[indexId].icon
                this.form.preview = '/monitoring/icon/'+this.categories[indexId].icon
            } else this.setNullForm()
            this.formModal.show = status
            this.formModal.mode = mode
        },
        toggleOptionModal(status, index = null, item = null) {
            this.setOverflow(status)
            this.optionModal.show = status
            this.optionModal.index = index
            this.optionModal.item = item
        },
        toggleDeleteModal(status, index = null) {
            if(status == true) {
                this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            }
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
