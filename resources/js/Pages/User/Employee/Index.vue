<template>
    <app-layout title="Manage Pegawai">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="$page.props.flash.message"/>
        <m-error-toast
            :is_active="error.active"
            :message="error.message"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Pegawai
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
                                Manage Pegawai
                            </span>
                        </div>
                    </div>
                    <div class="text-sm w-full font-medium text-center text-gray-500 border-b border-gray-200">
                        <ul class="flex items-stretch flex-wrap -mb-px">
                            <li class="mr-2">
                                <span class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" @click="goUser()" role="button"
                                aria-current="page">
                                    Pengguna
                                </span>
                                <span class="inline-block p-4 rounded-t-lg border-b-2 text-purple-600 border-purple-600 active" role="button" aria-current="page">
                                    Pegawai
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 relative sm:rounded-xl p-7">
                        <div v-if="$page.props.user.level != 'user'">
                            <button @click="toggleFormModal(true, 'create')" type="button" class="w-full focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                <plus-circle-icon size="18" class="inline-block mr-4"/>
                                <span class="inline-block">
                                    Tambah Pegawai
                                </span>
                            </button>
                            <button type="button" @click="toggleCogModal(true)" class="w-full text-purple-700 border border-purple-700 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                <more-vertical-icon size="18" class="inline-block mr-4"/>
                                <span class="inline-block">
                                    Pengaturan pegawai
                                </span>
                            </button>
                            <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <div class="flex justify-between items-start p-5 rounded-t border-b">
                                            <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                <div v-if="formModal.mode == 'create'">
                                                    Pegawai Baru
                                                </div>
                                                <div v-else-if="formModal.mode == 'show'">
                                                    Detail Pegawai
                                                </div>
                                                <div v-else>
                                                    Edit Pegawai
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
                                                        <label for="name-employee">Nama Pegawai</label>
                                                        <input maxlength="150" required :readonly="formModal.mode == 'show'" :class="{'bg-gray-100': formModal.mode == 'show'}" name="name" id="name-employee" v-model="form.name" type="text" placeholder="Masukkan nama employee" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="email-employee">Email</label>
                                                        <input maxlength="150" required :readonly="formModal.mode == 'show'" :class="{'bg-gray-100': formModal.mode == 'show'}" name="email" id="email-employee" v-model="form.email" type="email" placeholder="Masukkan email employee" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="phone_number-employee">No Telp</label>
                                                        <input maxlength="150" required :readonly="formModal.mode == 'show'" :class="{'bg-gray-100': formModal.mode == 'show'}" name="phone_number" id="phone_number-employee" v-model="form.phone_number" type="tel" placeholder="Masukkan nomor telepon" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="division-employee">Divisi</label>
                                                        <input maxlength="150" required :readonly="formModal.mode == 'show'" :class="{'bg-gray-100': formModal.mode == 'show'}" name="division" id="division-employee" v-model="form.division" type="text" placeholder="Masukkan nama divisi" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="branch-employee">Cabang</label>
                                                        <input maxlength="150" required :readonly="formModal.mode == 'show'" :class="{'bg-gray-100': formModal.mode == 'show'}" name="branch" id="branch-employee" v-model="form.branch" type="text" placeholder="Masukkan nama cabang" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="position-employee">Posisi</label>
                                                        <input maxlength="150" required :readonly="formModal.mode == 'show'" :class="{'bg-gray-100': formModal.mode == 'show'}" name="position" id="position-employee" v-model="form.position" type="text" placeholder="Masukkan posisi" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="proffesion-employee">Pekerjaan</label>
                                                        <input maxlength="150" required :readonly="formModal.mode == 'show'" :class="{'bg-gray-100': formModal.mode == 'show'}" name="profession" id="profession-employee" v-model="form.profession" type="text" placeholder="Masukkan nama pekerjaan" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
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
                            <div id="importModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !importModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <div class="flex justify-between items-start p-5 rounded-t border-b">
                                            <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                            <div>
                                                Import data pegawai
                                            </div>
                                            </h3>
                                            <button @click="toggleImportModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <form @submit.prevent="onImport()" action="#">
                                            <div>
                                                <div class="p-6 max-h-96 overflow-y-auto">
                                                    <div>
                                                        <label for="file-import-data">Dokumen import data</label>
                                                        <input required id="file-import-data" type="file" @change="onChangeImportFile($event)" accept=".xls, .xlsx" class="hidden">
                                                        <div @click="clickFileImport()" class="mt-2">
                                                            <div role="button" class="w-full text-center p-6 border-2 border-dashed border-purple-500 rounded-lg">
                                                                <div class="w-full">
                                                                    <file-icon size="3x" class="inline-block text-purple-600"/>
                                                                </div>
                                                                <p v-if="importModal.document == null" class="mt-3 font-semibold text-gray-600">Browse file excel</p>
                                                                <p v-else class="mt-3 font-semibold text-gray-600">{{ importModal.document.name }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800" role="alert">
                                                            <span class="font-semibold">Peringatan !</span> Pastikan dokumen sesuai dengan format hasil export data.
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center mb-4">
                                                            <input id="default-checkbox" v-model="importModal.reset" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Atur ulang semua data</label>
                                                        </div>
                                                        <div class="mt-2 p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800" role="alert">
                                                            <span class="font-semibold">Peringatan !</span> Apabila di centang, maka semua tim akan terhapus dan akan terisi kembali sesuai dengan isi file excel.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                    <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Simpan
                                                    </button>
                                                    <button @click="toggleImportModal(false)" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                        Batal
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-x-4 my-3">
                            <div class="col-span-2">
                                <input @keyup="onSearch()" placeholder="Cari berdasarkan nama pegawai" v-model="dataNeed.name" type="text" id="title-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div class="col-span-1">
                                <select @change="onSearch()" id="sort-select" v-model="dataNeed.sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option v-for="(item, index) in sorts" :key="`value-sort-${index}`" :value="item.value">{{ item.label }}</option>
                                </select>
                            </div>
                        </div>
                        <div id="cogs-modal" tabindex="-1" :class="{'hidden' : !cogModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                        <h3 class="text-xl font-medium text-gray-900 dark:text-white"> Pengaturan pegawai </h3>
                                        <button @click="toggleCogModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                    <div class="p-6 max-h-96 overflow-y-auto space-y-4">
                                        <div role="button" @click="onImportExcel()" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                            <div class="flex h-12 w-12 rounded-lg bg-indigo-100 relative">
                                                <upload-icon class="mx-auto text-indigo-600 self-center" size="24"/>
                                            </div>
                                            <div>
                                                <p class="text-lg font-semi-bold text-gray-700 pt-2">Import data</p>
                                            </div>
                                        </div>
                                        <div role="button" @click="onExportExcel()" v-if="employees.data.length > 0" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                            <div class="flex h-12 w-12 rounded-lg bg-purple-100 relative">
                                                <download-icon class="mx-auto text-purple-600 self-center" size="24"/>
                                            </div>
                                            <div>
                                                <p class="text-lg font-semi-bold text-gray-700 pt-2">Export data</p>
                                            </div>
                                        </div>
                                        <div role="button" @click="toggleDeleteModal(true, null)" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                            <div class="flex h-12 w-12 rounded-lg bg-red-100 relative">
                                                <trash-icon class="mx-auto text-red-600 self-center" size="24"/>
                                            </div>
                                            <div>
                                                <p class="text-lg font-semi-bold text-gray-700 pt-2">Hapus semua data</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-row-reverse items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                        <button @click="toggleCogModal(false)" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="employees.data.length > 0">
                            <div class="mt-3 mb-4" v-for="(item, index) in employees.data" :key="`user-${index}`">
                                <div role="button" class="transition-all break-all ease-in-out relative flex gap-x-4 rounded-lg bg-white hover:shadow-lg">
                                    <div role="button" class="flex w-9/12 gap-x-4 p-4">
                                        <div class="self-center mt-1">
                                            <p class="text-lg font-semibold">{{ item.name }}</p>
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
                                        </div>
                                        <div class="absolute right-0 top-0 p-4">
                                            <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2">
                                                <more-vertical-icon size="20"/>
                                            </button>
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

                            <div id="delete-modal" tabindex="-1" :class="{'hidden' : !deleteModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                Hapus Pegawai ?
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
                                                Data pegawai ini akan tehapus secara permanen
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
                                <m-pagination-data :paginationData="employees" :data="dataNeed" :preserveState="false"/>
                            </div>
                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Pegawai tidak ditemukan" link_route="app.employee.index"/>
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
import { ArrowLeftIcon, UploadIcon, DownloadIcon, PlusCircleIcon, FileIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MErrorToast from '@/Components/MErrorToast'
import MPaginationData from '@/Components/MPaginationData'
import MToast from '@/Components/MToast'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['employees'],
    components: {
        AppLayout,
        MToast,
        UploadIcon,
        FileIcon,
        DownloadIcon,
        MUnderConstruction,
        ArrowLeftIcon,
        MErrorToast,
        EditIcon,
        PlusCircleIcon,
        MPaginationData,
        MNoData,
        FileTextIcon,
        ImageIcon,
        TrashIcon,
        MoreVerticalIcon,
        EyeIcon,
    },
    data() {
        return {
            dataNeed: {
                name: '',
                sort: 'desc'
            },
            sorts: [
                { value: 'desc', label: 'Paling baru' },
                { value: 'asc', label: 'Paling lama' },
            ],
            formModal : {
                show: false,
                mode: 'create',
                index: null,
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
                name: null,
                email: null,
                phone_number: null,
                division: null,
                branch: null,
                position: null,
                profession: null,
            }),
            importModal: {
                show: false,
                document: null,
                reset: false,
            },
            cogModal: {
                show: false,
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
        }
    },
    methods: {
        onErrorToast(errors) {
            console.log(errors)
            this.error.message = errors
            this.error.active = true
            setTimeout(() => {
                this.error.active = false
            }, 5000);
        },
        onImport() {
            let fm = new FormData()
            fm.append('document', this.importModal.document)
            fm.append('is_reset', this.importModal.reset == true ? 1 : 0)
            this.$inertia.post(this.route('app.employee.import-excel'), fm, {
                onSuccess: () => {
                    this.toggleImportModal(false)
                    this.importModal.document = null
                    this.importModal.reset = false
                    this.onToast('green', 'Import data pegawai berhasil')
                }
            })
        },
        truncating(text, length, suffix) {
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
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
        clickFileImport() {
            document.getElementById('file-import-data').click()
        },
        onChangeImportFile(event) {
            let file = event.target.files[0]
            this.importModal.document = file
        },
        onImportExcel() {
            this.toggleCogModal(false)
            this.toggleImportModal(true)
        },
        onExportExcel() {
            window.location.href = this.route('app.employee.export-excel')
            this.toggleCogModal(false)
        },
        toggleCogModal(status) {
            this.setOverflow(status)
            this.cogModal.show = status
        },
        toggleImportModal(status) {
            this.setOverflow(status)
            this.importModal.show = status
        },
        onSearch() {
            this.$inertia.get(this.route('app.employee.index'), {
                name: this.dataNeed.name,
                sort: this.dataNeed.sort,
            }, {
                preserveState: true
            })
        },
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        goUser() {
            this.$inertia.get(this.route('app.user.index'))
        },
        gotoObject(employee_id) {
            this.toggleOptionModal(false)
            this.$inertia.get(this.route('app.object.index'), {
                employeeId: employee_id
            })
        },
        goInput(employee_id) {
            this.toggleOptionModal(false)
            this.$inertia.get(this.route('app.input.index'), {
                employeeId: employee_id
            })
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
                })).post(this.route('app.employee.store'),
                {
                    onSuccess: (response) => {
                        this.toggleFormModal(false),
                        this.onToast('green', 'Data pegawai berhasil disimpan')
                    },
                    onError: (errors) => this.onErrorToast(errors)
                })
            } else {
                this.form.transform(data => ({
                    ... data,
                    _method: 'PATCH'
                })).post(this.route('app.employee.update', { id: this.employees.data[this.optionModal.index].id }),
                {
                    onSuccess: (response) => {
                        this.onToast('green', 'Data pegawai berhasil diedit')
                        this.toggleFormModal(false)
                    },
                    onError: (errors) => this.onErrorToast(errors)
                })
            }
        },
        deleteData() {
            if(this.optionModal.index != null) {
                this.$inertia.delete(this.route('app.employee.destroy', { id: this.employees.data[this.optionModal.index].id  }),
                {
                    onSuccess: (response) => {
                        this.toggleDeleteModal(false),
                        this.onToast('green', 'Data pegawai berhasil dihapus')
                    }
                })
            } else {
                this.$inertia.delete(this.route('app.employee.delete-all'),
                {
                    onSuccess: (response) => {
                        this.toggleDeleteModal(false),
                        this.onToast('green', 'Data pegawai berhasil dihapus')
                    }
                })
            }
        },
        setNullForm() {
            this.form.name = ''
            this.form.email = ''
            this.form.phone_number = ''
            this.form.division = ''
            this.form.branch = ''
            this.form.position = ''
            this.form.profession = ''
        },
        toggleFormModal(status, mode = 'create', indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                this.form.name = this.employees.data[indexId].name != null ? this.employees.data[indexId].name : ''
                this.form.email = this.employees.data[indexId].email != null ? this.employees.data[indexId].email : ''
                this.form.phone_number = this.employees.data[indexId].phone_number != null ? this.employees.data[indexId].phone_number : ''
                this.form.division = this.employees.data[indexId].division != null ? this.employees.data[indexId].division : ''
                this.form.branch = this.employees.data[indexId].branch != null ? this.employees.data[indexId].branch : ''
                this.form.position = this.employees.data[indexId].position != null ? this.employees.data[indexId].position : ''
                this.form.profession = this.employees.data[indexId].profession != null ? this.employees.data[indexId].profession : ''
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
            this.toggleCogModal(false)
            if(status == true) {
                this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            }
            this.deleteModal.show = status
            this.deleteModal.index = index
        },
    }
})
</script>
