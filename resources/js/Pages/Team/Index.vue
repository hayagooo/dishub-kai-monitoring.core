<template>
    <app-layout title="Manage Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Tim
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <!-- <div class="p-6"> -->
                        <!-- <m-under-construction/> -->
                    <!-- </div> -->
                    <div class="p-7">
                        <button @click="goHome()" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            <arrow-left-icon size="18" class="inline-block mr-3"/>
                            <span class="inline-block">Kembali</span>
                        </button>
                        <div class="mt-6 realtive">
                            <img src="@/Assets/features/team.png" class="inline-block h-16 md:h-20 w-auto" alt="User">
                            <span class="inline-block text-lg md:text-2xl text-gray-600 ml-6 font-semibold">
                                Management Team
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50 relative sm:rounded-xl p-7">
                        <button @click="toggleFormModal(true, 'create')" type="button" class="w-full mt-4 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                            <plus-circle-icon size="18" class="inline-block mr-4"/>
                            <span class="inline-block">
                                Tambah Team
                            </span>
                        </button>
                        <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <div class="flex justify-between items-start p-5 rounded-t border-b">
                                                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                    <div v-if="formModal.mode == 'create'">
                                                    Team Baru
                                                </div>
                                                <div v-else-if="formModal.mode == 'show'">
                                                    Detail Team
                                                </div>
                                                <div v-else>
                                                    Edit Team
                                                </div>
                                                </h3>
                                                <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <form @submit.prevent="store()" action="#">
                                                <div v-if="formModal.mode == 'show'">
                                                    <div class="p-6">
                                                        <div class="mt-2">
                                                            <label for="name-team">Nama Team</label>
                                                            <input required name="name" id="name-team" v-model="form.name" type="text" placeholder="Masukkan nama team" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" readonly>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="description-team">Description</label>
                                                            <textarea required name="description" id="description-team" v-model="form.description" placeholder="Masukkan description" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" readonly></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="goals-team">Goal</label>
                                                            <textarea required name="goals" id="goals-team" v-model="form.goals" placeholder="Masukkan Goal" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" readonly></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="note-team">Note</label>
                                                            <textarea required name="note" id="note-team" v-model="form.note" placeholder="Masukkan Note" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" readonly></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else-if="formModal.mode == 'create'">
                                                    <div class="p-6">
                                                        <div class="mt-2">
                                                            <label for="name-team">Nama Team</label>
                                                            <input required name="name" id="name-team" v-model="form.name" type="text" placeholder="Masukkan nama team" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="description-team">Description</label>
                                                            <textarea required name="description" id="description-team" v-model="form.description" placeholder="Masukkan description" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md"></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="goals-team">Goal</label>
                                                            <textarea required name="goals" id="goals-team" v-model="form.goals" placeholder="Masukkan Goal" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" ></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="note-team">Note</label>
                                                            <textarea required name="note" id="note-team" v-model="form.note" placeholder="Masukkan Note" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" ></textarea>
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
                                                </div>
                                                <div v-else>
                                                    <div class="p-6">
                                                        <div class="mt-2">
                                                            <label for="name-team">Nama Team</label>
                                                            <input required name="name" id="name-team" v-model="form.name" type="text" placeholder="Masukkan nama team" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="description-team">Description</label>
                                                            <textarea required name="description" id="description-team" v-model="form.description" placeholder="Masukkan description" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md"></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="goals-team">Goal</label>
                                                            <textarea required name="goals" id="goals-team" v-model="form.goals" placeholder="Masukkan Goal" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" ></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="note-team">Note</label>
                                                            <textarea required name="note" id="note-team" v-model="form.note" placeholder="Masukkan Note" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md" ></textarea>
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
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <div class="mt-3 mb-4" v-for="(item, index) in teams" :key="`team-${index}`">
                        <div role="button" class="transition-all ease-in-out relative flex gap-x-4 rounded-lg bg-white hover:shadow-lg">
                            <div role="button" class="flex w-9/12 gap-x-4 p-4" @click="gotoShow(item.id)">
                                <div class="self-center">
                                    <p class="text-base md:text-lg font-semibold">{{ item.name }}</p>
                                </div>
                            </div>
                            <div class="absolute right-0 top-0 p-4">
                                <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2">
                                    <more-vertical-icon size="20"/>
                                </button>
                            </div>
                            <div id="option-modal" tabindex="-1" :class="{'hidden' : !optionModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white"> Pengaturan Team </h3>
                                            <button @click="toggleOptionModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 space-y-4">
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

                            <div id="delete-modal" tabindex="-1" :class="{'hidden' : !deleteModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                Hapus Team ?
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
                                                Data Team akan tehapus secara permanen
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
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, PlusCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'


export default defineComponent({
    props: ['employees', 'teams'],
    components: {
        AppLayout,
        MUnderConstruction,
        ArrowLeftIcon,
        PlusCircleIcon,
        FileTextIcon,
        TrashIcon,
        MoreVerticalIcon,
        EditIcon,
        EyeIcon,
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
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
            form: this.$inertia.form({
                preview: null,
                name: '',
                description: '',
                goals: '',
                note: '',
            }),
        }
    },
    methods: {
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        gotoShow(team_id) {
            this.toggleOptionModal(false)
            this.$inertia.get(this.route('app.team.create'), {
                teamId: team_id
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
        setOverflow(status) {
            let body = document.querySelector('body').classList
            if(status == true)  body.add('overflow-hidden')
            else body.remove('overflow-hidden')
        },
        store() {
            if(this.formModal.mode == 'create') {
                this.form.post(this.route('app.team.store'),
                {
                    onFinish: () => this.toggleFormModal(false),
                    onSuccess: (response) => {
                        this.onToast(response)
                    }
                })
            } else {
                this.form.transform(data => ({
                    ... data,
                    _method: 'PATCH'
                })).post(this.route('app.team.update', { id: this.teams[this.optionModal.index].id }),
                {
                    onFinish: () => this.toggleFormModal(false),
                    onSuccess: (response) => {
                        this.onToast(response)
                    }
                })
            }
        },
        setNullForm() {
            this.form.name = ''
            this.form.description = ''
            this.form.goals = ''
            this.form.note = ''
        },
        toggleFormModal(status, mode = 'edit', indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                this.form.name = this.teams[indexId].name
                this.form.description = this.teams[indexId].description
                this.form.goals = this.teams[indexId].goals
                this.form.note = this.teams[indexId].note
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
        deleteData() {
            this.$inertia.delete(this.route('app.team.destroy', { id: this.teams[this.optionModal.index].id  }),
            {
                onFinish: () => this.toggleDeleteModal(false),
                onSuccess: (response) => {
                    this.onToast(response)
                }
            })
        },
        toggleDeleteModal(status, index = null) {
            if(status == true) {
                this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            }
            this.deleteModal.show = status
            this.deleteModal.index = index
        },
    },
})
</script>
