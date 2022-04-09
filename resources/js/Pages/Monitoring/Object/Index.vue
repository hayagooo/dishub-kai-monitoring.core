<template>
    <app-layout title="Monitoring">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitoring
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7 border-b-2 border-gray-100">
                        <button @click="goBack()" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
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
                    <div class="p-7 relative">
                        <img src="@/Assets/defaults/category.png" class="h-12 w-auto inline-block" alt="Default Icon">
                        <p class="text-xl text-gray-500 inline-block ml-4">{{ category.name }}</p>
                        <!-- <div v-if="$page.props.user.level != 'user'" class="absolute right-0 top-0 p-7">
                            <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2 mt-1">
                                <more-vertical-icon size="20"/>
                            </button>
                        </div> -->
                    </div>
                    <div id="objects" class="bg-gray-100 relative sm:rounded-xl p-7">
                        <h2 class="text-xl text-gray-700 font-semibold">Objek Monitoring</h2>
                        <div v-if="$page.props.user.level != 'user'">

                        </div>
                        <div>
                            <div class="grid grid-cols-3 gap-6 mt-3">
                                <div v-if="$page.props.user.level != 'user'" class="col-span-3 md:col-span-1">
                                    <div @click="toggleFormModal(true, 'create')" role="button">
                                        <div class="flex w-full justify-center h-36 mb-2 text-lg border-dashed border-2 border-purple-600 rounded-lg transition-all ease-in-out hover:bg-gray-200">
                                            <span class="self-center">
                                                <plus-icon class="text-purple-600" size="2.5x"/>
                                            </span>
                                        </div>
                                        <p class="text-lg text-gray-700 font-semibold text-center">Objek Baru</p>
                                    </div>
                                    <div v-if="$page.props.user.level != 'user'" id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                            <div class="relative bg-white rounded-lg shadow">
                                                <div class="flex justify-between items-start p-5 rounded-t border-b">
                                                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                        {{ formModal.mode == 'create' ? 'Objek Baru' : 'Edit Objek' }}
                                                    </h3>
                                                    <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </button>
                                                </div>
                                                <form @submit.prevent="store()" action="#">
                                                    <div class="p-6">
                                                        <div class="text-center">
                                                            <img v-if="form.preview == null" src="@/Assets/defaults/object.png" class="h-20 w-auto inline-block" alt="Default Icon">
                                                            <img v-else :src="form.preview" class="h-24 w-auto inline-block" alt="Preview Icon">
                                                        </div>
                                                        <div>
                                                            <label for="name-object">Nama Objek</label>
                                                            <input required name="name" id="name-object" v-model="form.name" type="text" placeholder="Masukkan nama objek" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                        <div class="mt-6">
                                                            <div class="flex justify-between mb-3">
                                                                <div>
                                                                    <label for="icon-category">Icon Objek</label>
                                                                </div>
                                                                <div v-if="form.icon != null">
                                                                    <p role="button" @click="form.preview = null, form.icon = null" class="text-red-600">Hapus Icon</p>
                                                                </div>
                                                            </div>
                                                            <input @change="changeFile" name="icon" id="icon-category" type="file" class="hidden" accept=".jpg, .png, .jpeg">
                                                            <div @click="clickFile()" role="button" class="w-full text-center p-6 border-2 border-dashed border-purple-500 rounded-lg">
                                                                <div class="w-full">
                                                                    <image-icon size="3x" class="inline-block text-purple-600"/>
                                                                </div>
                                                                <p v-if="form.icon == null" class="mt-3 font-semibold text-gray-600">
                                                                    Click File or Drag and drop <br>
                                                                    <small>Rekomendasi ukuran : 48 x 48 pixel</small>
                                                                </p>
                                                                <p v-else>{{ form.icon.name }}</p>
                                                            </div>
                                                            <small>Abaikan untuk membuat icon default</small>
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
                                <div v-for="(item, index) in objects" :key="`object-${index}`">
                                    <div role="button" class="text-center transition-all ease-in-out relative p-4 rounded-lg bg-white hover:shadow-lg">
                                        <img src="@/Assets/defaults/object.png" class="h-28 w-auto inline-block" alt="Default Icon">
                                        <div v-if="$page.props.user.level != 'user'" class="absolute right-0 top-0 p-2">
                                            <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2 mt-1">
                                                <more-vertical-icon size="20"/>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="pt-2 text-center">
                                        <p class="text-lg font-semibold">{{ item.name }}</p>
                                    </div>
                                </div>

                                <div id="option-modal" tabindex="-1" :class="{'hidden' : !optionModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                    Pengaturan Objek
                                                </h3>
                                                <button @click="toggleOptionModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <div class="p-6 space-y-4">
                                                <div role="button" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
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

                                <div id="option-modal" tabindex="-1" :class="{'hidden' : !deleteModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
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
                                            <div class="p-6 space-y-4">
                                                <div class="flex justify-center">
                                                    <div class="flex h-14 w-14 rounded-lg bg-red-100 relative">
                                                        <trash-icon class="text-red-600 self-center mx-auto" size="30"/>
                                                    </div>
                                                </div>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 text-center text-dark">
                                                    Kategori dan isi dari kategori akan tehapus secara permanen
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
import { ArrowLeftIcon, PlusIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['objects', 'category'],
    components: {
        MoreVerticalIcon,
        EyeIcon,
        AppLayout,
        TrashIcon,
        MNoData,
        EditIcon,
        ArrowLeftIcon,
        ImageIcon,
        PlusIcon,
        MUnderConstruction,
    },
    data() {
        return {
            formModal : {
                show: false,
                mode: 'create',
                index: null,
            },
            optionModal: {
                show: false,
                index: null,
                item: null,
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
        }
    },
    methods: {
        goBack() {
            this.$inertia.get(this.route('app.category.index'))
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
        toggleFormModal(status, mode, indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                this.form.name = this.objects[indexId].name
                this.form.icon = this.objects[indexId].icon
            } else this.setNullForm()
            this.formModal.show = status
            if(!status) this.setNullForm()
            this.formModal.mode = mode
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
