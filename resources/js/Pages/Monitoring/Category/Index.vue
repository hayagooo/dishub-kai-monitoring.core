<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitoring
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7">
                        <button @click="goHome()" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
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
                    <div id="categories" class="bg-gray-100 relative sm:rounded-xl p-7">
                        <h2 class="text-xl text-gray-700 font-semibold">Kategori Monitoring</h2>
                        <div v-if="$page.props.user.level != 'user'">
                            <button data-modal-toggle="defaultModal" type="button" class="w-full mt-4 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                <plus-circle-icon size="18" class="inline-block mr-4"/>
                                <span class="inline-block">
                                    Tambah Kategori
                                </span>
                            </button>
                            <!-- Main modal -->
                            <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow">
                                        <!-- Modal header -->
                                        <div class="flex justify-between items-start p-5 rounded-t border-b">
                                            <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                Kategori Baru
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="defaultModal">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <form @submit.prevent="store()" action="#">
                                            <!-- Modal body -->
                                            <div class="p-6">
                                                <div class="text-center">
                                                    <img v-if="form.preview == null" src="@/Assets/defaults/category.png" class="h-20 w-auto inline-block" alt="Default Icon">
                                                    <img v-else :src="form.preview" class="h-24 w-auto inline-block" alt="Preview Icon">
                                                </div>
                                                <div>
                                                    <label for="name-category">Nama Kategori</label>
                                                    <input required name="name" id="name-category" v-model="form.name" type="text" placeholder="Masukkan nama kategori" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="mt-6">
                                                    <div class="flex justify-between mb-3">
                                                        <div>
                                                            <label for="icon-category">Icon Kategori</label>
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
                                            <!-- Modal footer -->
                                            <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    Simpan
                                                </button>
                                                <button data-modal-toggle="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="categories.length > 0">
                            <div v-for="(item, index) in categories" :key="`category-${index}`">
                                {{ item.name }}
                            </div>
                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Tidak ada kategori"/>
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
import { ArrowLeftIcon, PlusCircleIcon, ImageIcon } from '@zhuowenli/vue-feather-icons'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['categories'],
    components: {
        AppLayout,
        MNoData,
        ArrowLeftIcon,
        ImageIcon,
        PlusCircleIcon,
        MUnderConstruction,
    },
    data() {
        return {
            form: this.$inertia.form({
                preview: null,
                name: '',
                icon: null,
            }),
        }
    },
    methods: {
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        store() {
            this.form.post(this.route('app.category.store'))
        },
        clickFile() {
            document.getElementById('icon-category').click()
        },
        changeFile(e) {
            let file = e.target.files[0]
            this.form.icon = file
            this.form.preview = URL.createObjectURL(file)
        },
    },
})
</script>
