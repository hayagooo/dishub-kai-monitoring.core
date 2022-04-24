<template>
    <app-layout title="User-Manage">
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
                                Management Pengguna
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
                    <div class="mt-3 mb-4" v-for="(item, index) in users" :key="`user-${index}`">
                        <div role="button" class="transition-all ease-in-out relative flex gap-x-4 rounded-lg bg-white hover:shadow-lg">
                            <div role="button" @click="gotoUser(item.id)" class="flex w-9/12 gap-x-4 p-4">
                                <div class="self-center">
                                    <p class="text-base md:text-lg font-semibold">{{ item.name }}</p>
                                    <span class="text-base sm:text-sm font">Level Pengguna :
                                        {{item.level}}
                                    </span>
                                </div>
                                <div role="button" @click="toggleFormModal(true, 'edit', index)" class="absolute right-0 top-0 p-4">
                                    <div class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2 mt-1">
                                        <edit-icon class="mx-auto text-green-600 self-center" size="24"/>
                                    </div>
                                </div>
                                <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <div class="flex justify-between items-start p-5 rounded-t border-b">
                                                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                    <!-- {{ formModal.mode == 'edit' }} -->
                                                    Edit Pengguna
                                                </h3>
                                                <button @click="toggleFormModal(false, 'edit', index)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <form @submit.prevent="update()" action="#">
                                                <div class="p-6">
                                                    <div class="mt-2">
                                                        <label for="name-category">Nama Pengguna</label>
                                                        <input required name="name" id="name-user" v-model="form.name" type="text" placeholder="Masukkan nama pengguna" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label for="name-category">Email</label>
                                                        <input required name="email" id="email-user" v-model="form.email" type="email" placeholder="Masukkan email" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-2">
                                                        <label for="name-category">Code</label>
                                                        <input required name="code" id="code-user" v-model="form.code" type="text" placeholder="Masukkan code" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <!-- <div class="mt-2">
                                                        <label for="name-category">Password</label>
                                                        <input required name="password" id="password-user" v-model="form.password" type="password" placeholder="Masukkan password" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div> -->
                                                </div>
                                                <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                    <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Simpan
                                                    </button>
                                                    <button @click="toggleFormModal(false, 'edit')" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
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
import { ArrowLeftIcon, PlusCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'


export default defineComponent({
    props: ['users'],
    components: {
        AppLayout,
        MUnderConstruction,
        ArrowLeftIcon,
        EditIcon,
    },
    data() {
        return {
            formModal : {
                show: false,
                mode: 'edit',
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
            }),
        }
    },
    methods: {
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        goEmployee() {
            this.$inertia.get(this.route('app.employee.index'))
        },
        onToast(response) {
            this.toast.active = response.props.flash.message != null || response.props.flash.message != undefined ? true : false
            if(response.props.flash.status == 'success') this.toast.color = 'green'
            else if(response.props.flash.status == 'failed') this.toast.color = 'red'
            setTimeout(() => {
                this.toast.active = false
            }, 5000);
        },
        setOverflow(status) {
            let body = document.querySelector('body').classList
            if(status == true)  body.add('overflow-hidden')
            else body.remove('overflow-hidden')
        },
        update() {
            this.form.transform(data => ({
                ... data,
                _method: 'PATCH'
            })).post(this.route('app.user.update', { id: this.users[this.formModal.index].id }),
            {
                onFinish: () => this.toggleFormModal(false),
                onSuccess: (response) => {
                    this.onToast(response)
                }
            })
        },
        setNullForm() {
            this.form.name = ''
            this.form.email = ''
            this.form.code = ''
            this.form.password = ''
            this.formModal.index = null
        },
        toggleFormModal(status, mode = 'edit', indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                this.form.name = this.users[indexId].name
                this.form.email = this.users[indexId].email
                this.form.code = this.users[indexId].code
                this.form.password = this.users[indexId].password
                this.formModal.index = indexId
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
    }
})
</script>
