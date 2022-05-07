<template>
    <app-layout title="Manage Tim">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="$page.props.flash.message"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Tim
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
                        <div class="mt-6 realtive">
                            <img src="@/Assets/features/team.png" class="inline-block h-16 md:h-20 w-auto" alt="User">
                            <span class="inline-block text-lg md:text-2xl text-gray-600 ml-6 font-semibold">
                                Manage Tim
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50 relative sm:rounded-xl p-7">
                        <button @click="toggleFormModal(true, 'create')" type="button" class="w-full mt-4 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                            <plus-circle-icon size="18" class="inline-block mr-4"/>
                            <span class="inline-block">
                                Tambah Tim
                            </span>
                        </button>
                        <button type="button" @click="toggleCogModal(true)" class="w-full text-purple-700 border border-purple-700 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            <more-vertical-icon size="18" class="inline-block mr-4"/>
                            <span class="inline-block">
                                Pengaturan tim
                            </span>
                        </button>
                        <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                <div class="relative bg-white rounded-lg shadow">
                                    <div class="flex justify-between items-start p-5 rounded-t border-b">
                                        <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                        <div>
                                            {{ formModal.mode == 'create' ? 'Tambah tim' : 'Edit tim' }}
                                        </div>
                                        </h3>
                                        <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                    <form @submit.prevent="store()" action="#">
                                        <div>
                                            <div class="p-6 h-96 overflow-y-auto">
                                                <div>
                                                    <label for="name-team">Nama tim</label>
                                                    <input maxlength="150" required name="name" id="name-team" v-model="form.name" type="text" placeholder="Masukkan nama team" class="mt-2 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="description-team">Deskripsi tim</label>
                                                    <ckeditor id="description-team" class="mt-3" :editor="editor" v-model="form.description"></ckeditor>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="goals-team">Tujuan tim</label>
                                                    <ckeditor id="goals-team" class="mt-3" :editor="editor" v-model="form.goals"></ckeditor>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="note-team">Catatan</label>
                                                    <ckeditor id="note-team" class="mt-3" :editor="editor" v-model="form.note"></ckeditor>
                                                </div>
                                            </div>
                                            <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    Selanjutnya
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
                                            Import data tim
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
                        <div id="cogs-modal" tabindex="-1" :class="{'hidden' : !cogModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                        <h3 class="text-xl font-medium text-gray-900 dark:text-white"> Pengaturan tim </h3>
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
                                        <div role="button" v-if="teams.data.length > 0" @click="onExportExcel()" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
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
                        <div v-if="teams.data.length > 0">
                            <div class="grid grid-cols-3 gap-x-4 my-3">
                                <div class="col-span-2">
                                    <input @keyup="onSearch()" placeholder="Cari berdasarkan nama tim" v-model="dataNeed.name" type="text" id="title-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                                <div class="col-span-1">
                                    <select @change="onSearch()" id="sort-select" v-model="dataNeed.sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option v-for="(item, index) in sorts" :key="`value-sort-${index}`" :value="item.value">{{ item.label }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3 mb-4" v-for="(item, index) in teams.data" :key="`team-${index}`">
                                <div role="button" class="transition-all ease-in-out relative flex gap-x-4 rounded-lg bg-white hover:shadow-lg">
                                    <div role="button" class="flex w-9/12 gap-x-4 p-4" @click="gotoShow(item)">
                                        <div class="self-center flex gap-x-4">
                                            <div>
                                                <img class="w-14 h-14 border-2 border-white rounded-full dark:border-gray-800" :src="`https://via.placeholder.com/300x300/6c2bd9/ffffff.png?text=${initialsString(item.name)}`" alt="">
                                            </div>
                                            <div>
                                                <p class="text-base md:text-lg font-semibold">{{ item.name }}</p>
                                                <small>{{ item.employee.length <= 0 ? 'Tidak ada' : item.employee.length }} pegawai</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute right-0 top-0 p-3">
                                        <button type="button" @click="toggleOptionModal(true, index, item)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm p-2">
                                            <more-vertical-icon size="20"/>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div id="delete-modal" tabindex="-1" :class="{'hidden' : !deleteModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                Hapus Tim ?
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
                                                Data tim akan tehapus secara permanen
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
                            <div id="employeeModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !employeeModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <div class="flex justify-between items-start p-5 rounded-t border-b">
                                            <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                            <div>
                                                Atur Pegawai
                                            </div>
                                            </h3>
                                            <button @click="toggleEmployeeModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <div>
                                            <div class="p-6 h-96 overflow-y-auto">
                                                <div>
                                                    <input @keyup="onSearchEmployee()" placeholder="Cari berdasarkan nama pegawai" v-model="input.name_employee" type="text" id="name-employee-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                </div>
                                                <div v-if="employees.length > 0">
                                                    <div v-for="(item, index) in employees" :key="index" @click="toggleCheckbox(index)" :class="{'mb-2': index + 1 != employees.length, 'mt-2': index == 0}" class="p-3 relative transition-all hover:shadow-lg bg-white rounded-lg mb-2">
                                                        <p class="text-lg font-semibold">{{ item.name }}</p>
                                                        <p class="text-base text-gray-500" v-if="item.position != null || item.profession != null">
                                                            <span>{{ item.position != null ? item.position : '' }}</span>
                                                            <span class="mx-2" v-if="item.position != null && item.profession != null">-</span>
                                                            <span>{{ item.profession != null ? item.profession : '' }}</span>
                                                        </p>
                                                        <p class="text-base text-gray-500" v-if="item.division != null || item.branch != null">
                                                            <span class="mr-2" v-if="item.division != null || item.branch != null">at</span>
                                                            <span>{{ item.division != null ? item.division : '' }}</span>
                                                            <span class="mx-2" v-if="item.division != null && item.branch != null">-</span>
                                                            <span>{{ item.branch != null ? item.branch : '' }}</span>
                                                        </p>
                                                        <div class="absolute inset-y-10 right-10 z-30" v-if="checkboxes.length > 0">
                                                            <div class="flex items-center mb-4">
                                                                <input :checked="checkboxes[index].checked" :id="`checkbox-employee-${index}`" type="checkbox" class="w-6 h-6 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="mt-4">
                                                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                                        <span class="font-medium">Tidak ada data</span> Pegawai tidak ditemukan.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                <button @click="toggleEmployeeModal(false, 'create')" type="button" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    Simpan
                                                </button>
                                                <button @click="toggleEmployeeModal(false, 'create')" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-purple-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                    Tutup
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
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white"> Pengaturan tim </h3>
                                            <button @click="toggleOptionModal(false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 max-h-96 overflow-y-auto space-y-4">
                                            <div role="button" @click="gotoShowByIndex()" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                <div class="flex h-12 w-12 rounded-lg bg-purple-100 relative">
                                                    <eye-icon class="mx-auto text-purple-600 self-center" size="24"/>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-semi-bold text-gray-700 pt-2">Lihat Data</p>
                                                </div>
                                            </div>
                                            <div role="button" @click="toggleEmployeeModal(true, optionModal.index)" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
                                                <div class="flex h-12 w-12 rounded-lg bg-indigo-100 relative">
                                                    <user-check-icon class="mx-auto text-indigo-600 self-center" size="24"/>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-semi-bold text-gray-700 pt-2">Atur Pegawai</p>
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
                                <m-pagination-data :paginationData="teams" :data="dataNeed" :preserveState="false"/>
                            </div>
                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Tim tidak ditemukan" link_route="app.team.index"/>
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
import { ArrowLeftIcon, DownloadIcon, PlusCircleIcon, FileIcon, UploadIcon, UserCheckIcon ,FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MPaginationData from '@/Components/MPaginationData'
import MNoData from '@/Components/MNoData.vue'
import CKEditor from '@ckeditor/ckeditor5-vue'
import MToast from '@/Components/MToast'
import InlineEditor from '@ckeditor/ckeditor5-build-inline'

export default defineComponent({
    props: ['employees', 'teams', 'token'],
    components: {
        AppLayout,
        MUnderConstruction,
        MToast,
        ArrowLeftIcon,
        UploadIcon,
        DownloadIcon,
        UserCheckIcon,
        MNoData,
        PlusCircleIcon,
        MPaginationData,
        FileTextIcon,
        FileIcon,
        TrashIcon,
        MoreVerticalIcon,
        EditIcon,
        EyeIcon,
        ckeditor: CKEditor.component,
    },

    data() {
        return {
            editor: InlineEditor,
            dataNeed: {
                name: '',
                sort: 'id-desc'
            },
            sorts: [
                { value: 'id-desc', label: 'Paling baru' },
                { value: 'id-asc', label: 'Paling lama' },
                { value: 'employee-desc', label: 'Pegawai paling banyak' },
                { value: 'employee-asc', label: 'Pegawai paling sedikit' },
            ],
            input: this.$inertia.form({
                name_employee: '',
            }),
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
            importModal: {
                show: false,
                document: null,
                reset: false,
            },
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
            cogModal: {
                show: false,
            },
            employeeModal: {
                show: false,
                index: null
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
            checkboxes: [],
            form: this.$inertia.form({
                preview: null,
                name: '',
                description: '',
                goals: '',
                note: '',
            }),
        }
    },
    mounted() {
        this.setCheckboxModel()
    },
    methods: {
        onImport() {
            let fm = new FormData()
            fm.append('document', this.importModal.document)
            fm.append('is_reset', this.importModal.reset == true ? 1 : 0)
            this.$inertia.post(this.route('app.team.import-excel'), fm, {
                onFinish: () => this.toggleImportModal(false),
                onSuccess: () => {
                    this.importModal.document = null
                    this.importModal.reset = false
                    this.onToast('green', 'Import data tim berhasil')
                }
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
            window.location.href = this.route('app.team.export-excel')
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
        initialsString(str) {
            let rgx = new RegExp(/(\p{L}{1})\p{L}+/, 'gu')
            let initials = [...str.matchAll(rgx)] || []
            initials = (
                (initials.shift()?.[1] || '') + (initials.pop()?.[1] || '')
            ).toUpperCase();
            return initials
        },
        onSearch() {
            this.$inertia.get(this.route('app.team.index'), {
                name: this.dataNeed.name,
                sort: this.dataNeed.sort,
            }, {
                preserveState: true
            })
        },
        onSearchEmployee() {
            this.input.transform((data) => ({
                ...data,
                name: this.dataNeed.name,
                sort: this.dataNeed.sort,
            })).get(this.route('app.team.index'), {
                preserveState: true,
                preserveScroll: true,
                onFinish: () => this.toggleEmployeeModal(true, this.optionModal.index)
            })
        },
        setCheckboxModel() {
            this.employees.forEach((item, index) => {
                let data = {
                    item: item,
                    checked: false,
                }
                this.checkboxes.push(data)
            })
        },
        toggleEmployeeModal(status, index) {
            this.setOverflow(status)
            if(status == true) {
                this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
                let team = this.teams.data[index]
                this.checkboxes = []
                this.employees.forEach((item, index) => {
                    let checked = false
                    if(team.employee.find(employee => employee.id == item.id) != null) checked = true
                    let data = {
                        item: item,
                        checked: checked,
                    }
                    this.checkboxes.push(data)
                })
            }
            this.employeeModal.show = status
            this.employeeModal.index = index
        },
        goHome() {
            this.$inertia.get(this.route('dashboard'))
        },
        toggleCheckbox(index) {
            this.checkboxes[index].checked = !this.checkboxes[index].checked
            document.getElementById(`checkbox-employee-${index}`).checked = !document.getElementById(`checkbox-employee-${index}`).checked
            if(this.checkboxes[index].checked) {
                this.$inertia.post(this.route('app.team.add.employee', {
                    id: this.teams.data[this.optionModal.index].id
                }), {
                    employeeId: this.employees[index].id
                }, {
                    preserveScroll: true,
                    onFinish: () => {
                        this.input.reset()
                        this.onSearchEmployee()
                    }
                })
            } else {
                this.$inertia.post(this.route('app.team.remove.employee', {
                    id: this.teams.data[this.optionModal.index].id
                }), {
                    employeeId: this.employees[index].id
                }, {
                    preserveState: true,
                    preserveScroll: true,
                    onFinish: () => {
                        this.input.reset()
                        this.onSearchEmployee()
                    }
                })
            }
        },
        gotoShowByIndex() {
            this.toggleOptionModal(false, this.optionModal.index)
            this.$inertia.get(this.route('app.team.show', {
                id: this.teams.data[this.optionModal.index].id
            }), {
                name: this.generateSlug(this.teams.data[this.optionModal.index].name)
            })
        },
        generateSlug(text) {
            return text.toString().toLowerCase()
            .replace(/^-+/, '')
            .replace(/-+$/, '')
            .replace(/\s+/g, '-')
            .replace(/\-\-+/g, '-')
            .replace(/[^\w\-]+/g, '');
        },
        gotoShow(team) {
            this.toggleOptionModal(false)
            this.$inertia.get(this.route('app.team.show', {
                id: team.id
            }), {
                name: this.generateSlug(team.name)
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
                })).post(this.route('app.team.store'),
                {
                    onFinish: () => this.toggleFormModal(false),
                    onSuccess: (response) => this.onToast('green', 'Data tim berhasil disimpan')
                })
            } else {
                this.form.transform(data => ({
                    ... data,
                    _method: 'PATCH'
                })).post(this.route('app.team.update', { id: this.teams.data[this.optionModal.index].id }),
                {
                    onFinish: () => this.toggleFormModal(false),
                    onSuccess: (response) => this.onToast('green', 'Data tim berhasil diedit')
                })
            }
        },
        setNullForm() {
            this.form.name = ''
            this.form.description = ''
            this.form.goals = ''
            this.form.note = ''
        },
        toggleFormModal(status, mode = 'edit', indexId) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null && indexId != undefined) {
                this.form.name = this.teams.data[this.optionModal.index].name != null ? this.teams.data[this.optionModal.index].name : ''
                this.form.description = this.teams.data[this.optionModal.index].description != null ? this.teams.data[this.optionModal.index].description : ''
                this.form.goals = this.teams.data[this.optionModal.index].goals != null ? this.teams.data[this.optionModal.index].goals : ''
                this.form.note = this.teams.data[this.optionModal.index].note != null ? this.teams.data[this.optionModal.index].note : ''
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
            if(this.optionModal.index != null) {
                this.$inertia.delete(this.route('app.team.destroy', { id: this.teams.data[this.optionModal.index].id  }),
                {
                    onFinish: () => this.toggleDeleteModal(false),
                    onSuccess: (response) => this.onToast('green', 'Data tim berhasil dihapus')
                })
            } else {
                this.$inertia.delete(this.route('app.team.delete-all'),
                {
                    onFinish: () => this.toggleDeleteModal(false),
                    onSuccess: (response) => this.onToast('green', 'Data tim berhasil dihapus')
                })
            }
        },
        toggleDeleteModal(status, index = null) {
            this.toggleCogModal(false)
            if(status == true) {
                this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            }
            this.deleteModal.show = status
            this.deleteModal.index = index
        },
    },
})
</script>

<style scoped>
.ck-editor__editable_inline {
    border: 2px solid gainsboro;
    border-radius: 12px !important;
}
</style>
