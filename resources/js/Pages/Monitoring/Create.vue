<template>
    <app-layout title="Monitoring">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="toast.message"/>
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
                            <img src="@/Assets/features/monitoring.png" class="inline-block h-16 md:h-20 w-auto" alt="Monitoring">
                            <span class="inline-block text-lg md:text-2xl text-gray-600 ml-6 font-semibold">
                                Monitoring Data
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2">
                         <div class="col-span-2 md:col-span-1 p-7 border-b-2 md:border-b-0 border-gray-100 flex flex-nowrap">
                            <img v-if="category.icon == null" src="@/Assets/defaults/category.png" class="h-12 w-auto inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+category.icon" class="h-12 w-auto inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ category.name }}</p>
                        </div>
                        <div class="col-span-2 md:col-span-1 p-7 flex flex-nowrap">
                            <img v-if="object.icon == null" src="@/Assets/defaults/object.png" class="h-12 w-auto inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+object.icon" class="h-12 w-auto inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ object.name }}</p>
                        </div>
                    </div>
                    <div class="text-sm w-full font-medium text-center text-gray-500 border-b border-gray-200">
                        <ul class="flex items-stretch flex-wrap -mb-px">
                            <li class="mr-2" v-for="(item, index) in menuForms" :key="`menu-${index}`">
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
                    <div id="objects" class="bg-gray-50 relative p-7">
                        <h2 class="text-xl text-gray-800 font-semibold">Monitoring Baru</h2>
                        <p class="text-base text-gray-600">Formulir berdasarkan kebutuhan umum.</p>
                        <form @submit.prevent="submitGeneral" action="#">
                            <div class="mt-6">
                                <label for="title-monitoring">Judul Monitoring</label>
                                <input required name="title" id="title-monitoring" v-model="form.general.title" type="text" placeholder="e.g. Monitoring Jembatan Bandung" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="mt-6">
                                <label for="team-monitoring">Tim Monitoring</label>
                                <select @change="getEmployee()" required name="team_id" id="team-monitoring" v-model="form.general.team_id" type="text" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                    <option :value="0">Pilih Tim Monitoring</option>
                                    <option v-for="(item, index) in teams" :key="`team-${index}`" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                            <div v-if="form.general.team_id != 0 && (employees && employees.length > 0)" class="mt-6">
                                <label for="employee-monitoring">Subjek Monitoring</label>
                                <select required name="employee_id" id="employee-monitoring" v-model="form.general.employee_id" type="text" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                    <option :value="0">Pilih Pegawai atau Subjek</option>
                                    <option v-for="(item, index) in employees" :key="`employee-${index}`" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <label for="description-monitoring">Deskripsi Monitoring</label>
                                <div class="border-2 border-gray-300 rounded mt-3 hidden md:block">
                                    <ckeditor id="editor" placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="form.general.description"></ckeditor>
                                </div>
                                <div class="rounded mt-3 block md:hidden">
                                    <textarea required name="title" id="title-monitoring" v-model="form.general.title" type="text" placeholder="e.g. Deskripsi Monitoring Jembatan Bandung" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Simpan & Lanjutkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import CKEditor from '@ckeditor/ckeditor5-vue'
import InlineEditor from '@ckeditor/ckeditor5-build-inline'
import AppLayout from '@/Layouts/AppLayout.vue'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, PlusCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MToast from '@/Components/MToast'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['object', 'category', 'teams', 'inputs'],
    components: {
        MoreVerticalIcon,
        FileTextIcon,
        EyeIcon,
        AppLayout,
        MToast,
        TrashIcon,
        MNoData,
        EditIcon,
        ArrowLeftIcon,
        ImageIcon,
        PlusCircleIcon,
        MUnderConstruction,
        ckeditor: CKEditor.component
    },
    data() {
        return {
            editor: InlineEditor,
            menuIndex: 0,
            menuForms: [
            {   name: 'general',
                label: 'Umum',
            }],
            employees: [],
            optionModal: {
                show: false,
                index: null,
                item: null,
            },
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
            deleteModal: {
                show: false,
                index: null
            },
            form: {
                general: this.$inertia.form({
                    title: '',
                    team_id: 0,
                    employee_id: 0,
                    description: '',
                })
            }
        }
    },
    mounted() {
        this.setMenu()
        this.toast.active = this.$page.props.flash.message != null || this.$page.props.flash.message != undefined ? true : false
        if(this.$page.props.flash.status == 'success') this.toast.color = 'green'
        else if(this.$page.props.flash.status == 'failed') this.toast.color = 'red'
        setTimeout(() => {
            this.toast.active = false
        }, 5000);
    },
    methods: {
        clickMenu(item, index) {
            if(index != 0) {
                this.onToast('red', 'Simpan data monitoring dulu')
            }
        },
        onToast(color, message) {
            this.toast.active = true
            this.toast.message = message
            this.toast.color = color
            setTimeout(() => {
                this.toast.active = false
            }, 5000);
        },
        setMenu() {
            if(this.inputs.category.length > 0) {
                let category = {
                    name: 'category',
                    label: 'Kategori'
                }
                this.menuForms.push(category)
            }
            if(this.inputs.object.length > 0) {
                let object = {
                    name: 'object',
                    label: 'Objek'
                }
                this.menuForms.push(object)
            }
            let image = {
                name: 'image',
                label: 'Gambar'
            }
            this.menuForms.push(image)
        },
        getEmployee() {
            this.form.general.employee_id = 0
            axios.get(this.route('api.employee.index', {
                team_id: this.form.general.team_id
            })).then((response) => {
                this.employees = response.data.payload
            })
        },
        submitGeneral() {
            this.form.general
                .transform(data => ({
                    ...data,
                    category_id: this.category.id,
                    object_id: this.object.id
                }))
                .post(this.route('app.monitoring.store'))
        },
        goBack() {
            this.$inertia.get(this.route('app.monitoring.index'), {
                categoryId: this.category.id,
                objectId: this.object.id
            })
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
        goCreate() {
            this.$inertia.get(this.route('app.monitoring.create', {
                categoryId: this.category.id,
                objectId: this.object.id
            }))
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
