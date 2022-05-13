<template>
    <app-layout title='Manage team'>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Tim
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7 border-b-2 border-gray-100">
                        <button @click="goHome()" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            <arrow-left-icon size="18" class="inline-block mr-3"/>
                            <span class="inline-block">Kembali</span>
                        </button>
                        <div class="mt-6 realtive">
                            <img src="@/Assets/features/team.png" class="inline-block h-16 md:h-20 w-auto" alt="User">
                            <span class="inline-block text-lg md:text-2xl text-gray-600 ml-6 font-semibold">
                                Manage Tim
                            </span>
                        </div>
                    </div>
                    <div class="p-7">
                        <div class="flex w-full gap-x-4">
                            <div class="self-center flex gap-x-4">
                                <div>
                                    <img class="w-14 h-14 border-2 border-white rounded-full dark:border-gray-800" :src="`https://via.placeholder.com/300x300/6c2bd9/ffffff.png?text=${initialsString(team.name)}`" alt="">
                                </div>
                                <div class="break-all">
                                    <p class="text-base md:text-lg font-semibold">{{ truncating(team.name, 50, '...') }}</p>
                                    <small>{{ team.employee.length <= 0 ? 'Tidak ada' : team.employee.length }} pegawai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="menuShow.length > 0" class="text-sm w-full font-medium text-center text-gray-500 border-b border-gray-200">
                        <ul class="flex items-stretch flex-wrap -mb-px">
                            <li class="mr-2" v-for="(item, index) in menuShow" :key="`menu-${index}`">
                                <span class="inline-block p-4 rounded-t-lg border-b-2"
                                @click="clickMenu(item, index)"
                                role="button"
                                :class="{'text-purple-600 border-purple-600 active': index == menuIndex,
                                'border-transparent hover:text-gray-600 hover:border-gray-300': index != menuIndex}" a
                                ria-current="page">
                                    {{ item.label }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 relative break-all sm:rounded-xl p-7">
                        <div v-if="menuIndex == 0">
                            <div id="description-team-content" class="border-b-2 border-gray-200 pb-3">
                                <label for="description-content" class="mb-2 inline-block font-semibold">Deskripsi Tim</label>
                                <div id="description-content">
                                    <div v-if="team.description != null" v-html="team.description"></div>
                                    <div v-else>-</div>
                                </div>
                            </div>
                            <div id="goals-team-content" class="border-b-2 border-gray-200 pb-3 mt-3">
                                <label for="goals-content" class="mb-2 inline-block font-semibold">Tujuan Tim</label>
                                <div id="goals-content">
                                    <div v-if="team.goals != null" v-html="team.goals"></div>
                                    <div v-else>-</div>
                                </div>
                            </div>
                            <div id="note-team-content" class="mt-3">
                                <label for="note-content" class="mb-2 inline-block font-semibold">Catatan Tim</label>
                                <div id="note-content">
                                    <div v-if="team.note != null" v-html="team.note"></div>
                                    <div v-else>-</div>
                                </div>
                            </div>
                        </div>
                        <div v-if="menuIndex == 1">
                            <div>
                                <input @keyup="onSearchEmployee(false)" placeholder="Cari berdasarkan nama pegawai" v-model="input.name_employee" type="text" id="name-employee-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div v-if="team.employee.length > 0">
                                <div v-for="(item, index) in team.employee" :key="index" :class="{'mb-2': index + 1 != team.employee.length, 'mt-2': index == 0}" class="p-3 relative transition-all hover:shadow-lg bg-white rounded-lg mb-2">
                                    <p class="text-lg font-semibold">{{ truncating(item.name, 24, '...') }}</p>
                                    <p class="text-base text-gray-500" v-if="item.position != null || item.profession != null">
                                        <span>{{ item.position != null ? truncating(item.position, 16, '...') : '' }}</span>
                                        <span class="mx-2" v-if="item.position != null && item.profession != null">-</span>
                                        <span>{{ item.profession != null ? truncating(item.profession, 16, '...') : '' }}</span>
                                    </p>
                                    <p class="text-base text-gray-500" v-if="item.division != null || item.branch != null">
                                        <span class="mr-2" v-if="item.division != null || item.branch != null">at</span>
                                        <span>{{ item.division != null ? truncating(item.division, 16, '...') : '' }}</span>
                                        <span class="mx-2" v-if="item.division != null && item.branch != null">-</span>
                                        <span>{{ item.branch != null ? truncating(item.branch, 16, '...') : '' }}</span>
                                    </p>
                                    <div role="button" class="absolute inset-y-10 right-10 z-30" @click="removeEmployee(item.id)">
                                        <div class="flex items-center mb-4">
                                            <x-circle-icon size="20" class="text-gray-600"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="pt-4">
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    <span class="font-medium">Tidak ada data</span> Pegawai tidak ditemukan.
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
import MPaginationData from '@/Components/MPaginationData'
import AppLayout from '@/Layouts/AppLayout.vue'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, XCircleIcon, PlusCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'

export default defineComponent({
    props: ['employees', 'team', 'team_name'],
    components: {
        AppLayout,
        ArrowLeftIcon,
        PlusCircleIcon,
        FileTextIcon,
        TrashIcon,
        XCircleIcon,
        MoreVerticalIcon,
        MPaginationData,
        EditIcon,
        EyeIcon,
    },
    data() {
        return {
            menuIndex: 0,
            dataNeed: [],
            menuShow: [
                {name: 'general', label: 'Umum'},
                {name: 'employee', label: 'Pegawai'},
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
            input: this.$inertia.form({
                name_employee: '',
            }),
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
                employeeId: '',
            }),
        }
    },
    methods: {
        onSearchEmployee(inModal) {
            this.input.transform((data) => ({
                ...data,
                name: this.team_name,
            })).get(this.route('app.team.show', {
                id: this.team.id
            }), {
                preserveState: true,
                preserveScroll: true,
                onFinish: () => {
                    if(inModal) this.toggleEmployeeModal(true, this.optionModal.index)
                }
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
        removeEmployee(dataId) {
            this.$inertia.post(this.route('app.team.remove.employee', {
                id: this.team.id
            }), {
                employeeId: dataId
            })
        },
        goHome() {
            this.$inertia.get(this.route('app.team.index'))
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
            this.form.employeeId = ''
        },
        toggleFormModal(status, mode = 'edit', indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                this.form.name = this.employees[indexId].name
                this.form.employeeId = this.employees[indexId].employeeId
            } else this.setNullForm()
            this.formModal.show = status
            if(!status) this.setNullForm()
            this.formModal.mode = mode
        },
        clickMenu(item, index) {
            this.menuIndex = index
        },
        truncating(text, length, suffix) {
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
            }
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
