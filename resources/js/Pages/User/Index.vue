<template>
    <app-layout title="Manage Pengguna">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="$page.props.flash.message"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Pengguna
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <!-- <div class="p-6">
                        <m-under-construction/>

                    </div> -->

                    <div class="p-7">
                        <button @click="goHome()" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            <arrow-left-icon size="18" class="inline-block mr-3"/>
                            <span class="inline-block">Kembali</span>
                        </button>
                        <div class="mt-6 realtive">
                            <img src="@/Assets/features/user.png" class="inline-block h-16 md:h-20 w-auto" alt="User">
                            <span class="inline-block text-lg md:text-2xl text-gray-600 ml-6 font-semibold">
                                Manage Pengguna
                            </span>
                        </div>
                    </div>
                    <div class="text-sm w-full font-medium text-center text-gray-500 border-b border-gray-200">
                        <ul class="flex items-stretch flex-wrap -mb-px">
                            <li class="mr-2">
                                <span class="inline-block p-4 rounded-t-lg border-b-2 text-purple-600 border-purple-600 active"
                                role="button"
                                aria-current="page">
                                    Pengguna
                                </span>
                                <span class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300"
                                @click="goEmployee()"
                                role="button">
                                    Pegawai
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 relative sm:rounded-xl p-7">
                        <button @click="toggleFormModal(true, 'create')" type="button" class="w-full focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                            <plus-circle-icon size="18" class="inline-block mr-4"/>
                            <span class="inline-block">
                                Tambah Pengguna
                            </span>
                        </button>
                        <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                <div class="relative bg-white rounded-lg shadow">
                                    <div class="flex justify-between items-start p-5 rounded-t border-b">
                                        <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                            <div v-if="formModal.mode == 'create'">
                                            Pengguna Baru
                                        </div>
                                        <div v-else-if="formModal.mode == 'show'">
                                            Detail Pengguna
                                        </div>
                                        <div v-else>
                                            Edit Pengguna
                                        </div>
                                        </h3>
                                        <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                    <form @submit.prevent="store()" action="#">
                                        <div>
                                            <div class="p-6 max-h-96 overflow-y-auto space-y-4">
                                                <div>
                                                    <label for="name-user">Nama Pengguna</label>
                                                    <input maxlength="100" required :readonly="formModal.mode == 'show'" name="name-field" id="name-user" v-model="form.name" type="text" placeholder="Masukkan nama pengguna" :class="{'bg-gray-100': formModal.mode == 'show'}" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="email-user">Email</label>
                                                    <input maxlength="100" required :readonly="formModal.mode == 'show'" name="email-field" id="email-user" v-model="form.email" type="email" placeholder="Masukkan email" :class="{'bg-gray-100': formModal.mode == 'show'}" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="code-user">Code</label>
                                                    <input maxlength="100" required :readonly="formModal.mode == 'show'" name="code-field" id="code-user" v-model="form.code" type="text" placeholder="Masukkan code" :class="{'bg-gray-100': formModal.mode == 'show'}" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="password-user">Password</label>
                                                    <input maxlength="100" :required="formModal.mode == 'create'" :readonly="formModal.mode == 'show'" name="password-field" id="password-user" v-model="form.password" type="password" placeholder="Masukkan password" :class="{'bg-gray-100': formModal.mode == 'show'}" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    <small id="hint-password" v-if="formModal.mode == 'edit'">Abaikan untuk tidak mengganti password</small>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="level-select-in-modal">Level</label>
                                                    <select required :readonly="formModal.mode == 'show'" id="level-select-in-modal" v-model="form.level" :class="{'bg-gray-100': formModal.mode == 'show'}" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                        <option value="">Pilih level</option>
                                                        <option v-for="(item, index) in levels" :key="`value-level-${index}`" :value="item.value">{{ item.label }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div v-if="formModal.mode != 'show'" class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    Simpan
                                                </button>
                                                <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-x-4 my-3">
                            <div class="col-span-2">
                                <input @keyup="onSearch()" placeholder="Cari berdasarkan nama pengguna" v-model="dataNeed.name" type="text" id="title-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div class="col-span-1">
                                <select @change="onSearch()" id="level-select" v-model="dataNeed.level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Pilih level</option>
                                    <option v-for="(item, index) in levels" :key="`value-sort-${index}`" :value="item.value">{{ item.label }}</option>
                                </select>
                            </div>
                            <div class="col-span-1">
                                <select @change="onSearch()" id="sort-select" v-model="dataNeed.sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option v-for="(item, index) in sorts" :key="`value-sort-${index}`" :value="item.value">{{ item.label }}</option>
                                </select>
                            </div>
                        </div>
                        <div v-if="users.data.length > 0">
                            <div class="mt-3 mb-4" v-for="(item, index) in users.data" :key="`user-${index}`">
                                <div role="button" class="transition-all ease-in-out relative flex gap-x-4 rounded-lg bg-white hover:shadow-lg">
                                    <div role="button" class="flex w-9/12 gap-x-4 p-4">
                                        <div class="self-center">
                                            <p class="text-base md:text-lg font-semibold">{{ item.name }}</p>
                                            <span class="text-base sm:text-sm font">Level Pengguna :
                                                {{ item.level == 'user' ? 'Pengguna' : item.level == 'admin' ? 'Admin' : 'Koordinator' }}
                                            </span>
                                        </div>
                                        <div class="absolute right-0 top-0 p-4">
                                            <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2">
                                                <more-vertical-icon size="20"/>
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
                                                Hapus Pengguna ?
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
                                                Data pengguna akan tehapus secara permanen
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
                            <div id="option-modal" tabindex="-1" :class="{'hidden' : !optionModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white"> Pengaturan Pegawai </h3>
                                            <button @click="toggleOptionModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 max-h-96 overflow-y-auto space-y-4">
                                            <div role="button" @click="toggleFormModal(true, 'show', optionModal.index)" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
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
                            <div id="pagination-data" class="flex w-full mt-3 justify-end">
                                <m-pagination-data :paginationData="users" :data="dataNeed" :preserveState="false"/>
                            </div>
                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Pengguna tidak ditemukan" link_route="app.user.index"/>
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
import MToast from '@/Components/MToast'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, PlusCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MNoData from '@/Components/MNoData.vue'
import MPaginationData from '@/Components/MPaginationData'

export default defineComponent({
    props: ['users'],
    components: {
        AppLayout,
        MToast,
        MUnderConstruction,
        ArrowLeftIcon,
        EditIcon,
        MNoData,
        MPaginationData,
        PlusCircleIcon,
        FileTextIcon,
        TrashIcon,
        MoreVerticalIcon,
        EyeIcon,
    },
    data() {
        return {
            dataNeed: {
                name: '',
                level: '',
                sort: 'desc',
            },
            sorts: [
                {value: 'desc', label: 'Paling baru'},
                {value: 'asc', label: 'Paling lama'},
            ],
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
            levels: [
                {value: 'user', label: 'Pegawai'},
                {value: 'admin', label: 'Admin'},
                {value: 'coordinator', label: 'Koordinator'}
            ],
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
            form: this.$inertia.form({
                name: null,
                email: null,
                code: null,
                password: null,
                level: 'user',
            }),
            deleteModal: {
                show: false,
                index: null
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
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        onSearch() {
            this.$inertia.get(this.route('app.user.index'), {
                name: this.dataNeed.name,
                level: this.dataNeed.level,
                sort: this.dataNeed.sort,
            }, {
                preserveState: true
            })
        },
        onToast(color, message) {
            this.toast.active = true
            this.toast.message = message
            this.toast.color = color
            setTimeout(() => {
                this.toast.active = false
            }, 5000);
        },
        goEmployee() {
            this.$inertia.get(this.route('app.employee.index'))
        },
        setOverflow(status) {
            let body = document.querySelector('body').classList
            if(status == true)  body.add('overflow-hidden')
            else body.remove('overflow-hidden')
        },
        store() {
            if(this.formModal.mode == 'create') {
                this.form.transform(data => ({
                    ... data,
                    _method: 'POST'
                })).post(this.route('app.user.store'),
                {
                    onFinish: () => this.toggleFormModal(false),
                    onSuccess: () => this.onToast('green', 'Pengguna berhasil dihapus')
                })
            } else {
                this.form.transform(data => ({
                    ... data,
                    _method: 'PATCH'
                })).post(this.route('app.user.update', { id: this.users.data[this.optionModal.index].id }),
                {
                    onFinish: () => this.toggleFormModal(false),
                    onSuccess: () => this.onToast('green', 'Pengguna berhasil dihapus')
                })
            }
        },
        setNullForm() {
            this.form.name = ''
            this.form.email = ''
            this.form.code = ''
            this.form.password = ''
            this.form.level = ''
        },
        toggleFormModal(status, mode = 'edit', indexId = null) {
            this.formModal.show = status
            this.formModal.mode = mode
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                this.form.name = this.users.data[indexId].name != null ? this.users.data[indexId].name : ''
                this.form.email = this.users.data[indexId].email != null ? this.users.data[indexId].email : ''
                this.form.code = this.users.data[indexId].code != null ? this.users.data[indexId].code : ''
                this.form.level = this.users.data[indexId].level != null ? this.users.data[indexId].level : 'user'
            } else this.setNullForm()
            if(!status) this.setNullForm()
        },
        toggleOptionModal(status, index = null, item = null) {
            this.setOverflow(status)
            this.optionModal.show = status
            this.optionModal.index = index
            this.optionModal.item = item
        },
        deleteData() {
            this.$inertia.delete(this.route('app.user.destroy', { id: this.users.data[this.optionModal.index].id  }),
            {
                onFinish: () => this.toggleDeleteModal(false),
                onSuccess: () => this.onToast('green', 'Pengguna berhasil dihapus')
            })
        },
        toggleDeleteModal(status, index = null) {
            if(status == true) {
                this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            }
            this.deleteModal.show = status
            this.deleteModal.index = index
        },
    }
})
</script>
