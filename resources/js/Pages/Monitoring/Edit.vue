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
                    <div class="bg-gray-50 relative p-7">
                        <h2 class="text-xl text-gray-800 font-semibold">Formulir Monitoring</h2>
                        <div v-if="menuForms[menuIndex] != undefined && menuForms[menuIndex] != null">
                            <p class="text-base text-gray-600" v-if="menuForms[menuIndex].name != 'image'">
                                Formulir berdasarkan kebutuhan
                                <span>
                                    {{ lowerCased(menuForms[menuIndex].label) }}.
                                </span>
                            </p>
                            <p class="text-base text-gray-600" v-else>
                                Tambahkan file gambar penunjang monitoring.
                            </p>
                        </div>
                        <div class="relative w-1/2 py-1 rounded-lg bg-purple-600 mt-2 mb-4"></div>

                        <div v-if="menuForms[menuIndex] != null && menuForms[menuIndex] != undefined">
                            <form v-if="menuForms[menuIndex].name == 'general'" @submit.prevent="submitGeneral" action="#">
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
                                        <ckeditor placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="form.general.description"></ckeditor>
                                    </div>
                                    <div class="rounded mt-3 block md:hidden">
                                        <textarea required name="title" v-model="form.general.description" type="text" placeholder="e.g. Deskripsi Monitoring Jembatan Bandung" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Simpan & Lanjutkan
                                    </button>
                                </div>
                            </form>

                            <div v-if="menuForms[menuIndex].name == 'category'">
                                <form @submit.prevent="onSubmitInput" action="#">
                                    <div v-if="inputs.category != null && inputs.category != undefined">
                                        <div v-for="(item, index) in inputs.category" :key="`category-form-${index}`" class="my-3">
                                            <label class="font-semibold" :for="`field-data-${index}`">{{ item.label }}</label>
                                            <div v-if="inputType(item.type)">
                                                <div v-if="item.image != null">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg h-48 my-3" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                </div>
                                                <div v-if="item.type == 'text'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'textarea'">
                                                    <ckeditor
                                                    :required="item.is_required == 1 ? true : false"
                                                    :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder" :editor="editor"></ckeditor>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'number'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="number"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'checkbox'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :id="`option-${index}-value-${indexOption}`" type="checkbox" :name="`option-checkbox-${index}-value`" :value="item.value" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2" :aria-labelledby="`option-${index}-${indexOption}-checkbox`" :aria-describedby="`option-${index}-${indexOption}-checkbox`">
                                                                <label :for="`option-${index}-value-${indexOption}`" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                {{ option.value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-x-2 w-full">
                                                        <div class="self-center"><span>Yang lain :</span></div>
                                                        <div class="justify-self-stretch">
                                                            <input placeholder="Apabila ada" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'radio'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :id="`option-${index}-value-${indexOption}`" type="radio" :name="`option-radio-${index}-value`" :value="item.value" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" :aria-labelledby="`option-${index}-${indexOption}`" :aria-describedby="`option-${index}-${indexOption}`">
                                                                <label :for="`option-${index}-value-${indexOption}`" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                {{ option.value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'dropdown'">
                                                    <select :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                        <option value="">{{ item.placeholder == null ? 'Pilih data '+item.label : item.placeholder }}</option>
                                                        <option v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`" :value="option.value">{{ option.value }}</option>
                                                    </select>
                                                    <div v-if="item.option.length <= 0">
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'file'">
                                                    <input :placeholder="item.placeholder == null ? 'Pilih data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="file"
                                                    class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'date'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                                        </div>
                                                        <input
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan tanggal data '+item.label : item.placeholder" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'time'">
                                                    <div class="relative">
                                                        <input
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan waktu data '+item.label : item.placeholder" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div v-if="item.type == 'description'">
                                                    <div v-html="item.description"></div>
                                                </div>
                                                <div v-if="item.type == 'image'">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>
                                                <div v-if="item.type == 'media-youtube'">
                                                    <YouTube
                                                        width="100%"
                                                        :src="item.link"
                                                        @ready="onReadyYoutube(index)"
                                                        :ref="`youtube-${index}`" />
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Simpan & Lanjutkan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div v-if="menuForms[menuIndex].name == 'object'">
                                <form @submit.prevent="onSubmitInput" action="#">
                                    <div v-if="inputs.object != null && inputs.object != undefined">
                                        <div v-for="(item, index) in inputs.object" :key="`object-form-${index}`" class="my-3">
                                            <label class="font-semibold" :for="`field-data-${index}`">{{ item.label }}</label>
                                            <div v-if="inputType(item.type)">
                                                <div v-if="item.image != null">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg h-48 my-3" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                </div>
                                                <div v-if="item.type == 'text'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'textarea'">
                                                    <ckeditor
                                                    :required="item.is_required == 1 ? true : false"
                                                    :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder" :editor="editor"></ckeditor>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'number'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="number"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'checkbox'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :id="`option-${index}-value-${indexOption}`" type="checkbox" :name="`option-checkbox-${index}-value`" :value="item.value" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2" :aria-labelledby="`option-${index}-${indexOption}-checkbox`" :aria-describedby="`option-${index}-${indexOption}-checkbox`">
                                                                <label :for="`option-${index}-value-${indexOption}`" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                {{ option.value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-x-2 w-full">
                                                        <div class="self-center"><span>Yang lain :</span></div>
                                                        <div class="justify-self-stretch">
                                                            <input placeholder="Apabila ada" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'radio'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :id="`option-${index}-value-${indexOption}`" type="radio" :name="`option-radio-${index}-value`" :value="item.value" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" :aria-labelledby="`option-${index}-${indexOption}`" :aria-describedby="`option-${index}-${indexOption}`">
                                                                <label :for="`option-${index}-value-${indexOption}`" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                {{ option.value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'dropdown'">
                                                    <select :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                        <option value="">{{ item.placeholder == null ? 'Pilih data '+item.label : item.placeholder }}</option>
                                                        <option v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`" :value="option.value">{{ option.value }}</option>
                                                    </select>
                                                    <div v-if="item.option.length <= 0">
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'file'">
                                                    <input :placeholder="item.placeholder == null ? 'Pilih data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="file"
                                                    class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'date'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                                        </div>
                                                        <input
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan tanggal data '+item.label : item.placeholder" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'time'">
                                                    <div class="relative">
                                                        <input
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan waktu data '+item.label : item.placeholder" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div v-if="item.type == 'description'">
                                                    <div v-html="item.description"></div>
                                                </div>
                                                <div v-if="item.type == 'image'">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>
                                                <div v-if="item.type == 'media-youtube'">
                                                    <YouTube
                                                        width="100%"
                                                        :src="item.link"
                                                        @ready="onReadyYoutube(index)"
                                                        :ref="`youtube-${index}`" />
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Simpan & Lanjutkan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div v-if="menuForms[menuIndex].name == 'monitoring'">
                                <form @submit.prevent="onSubmitInput" action="#">
                                    <div v-if="inputs.monitoring != null && inputs.monitoring != undefined">
                                        <div v-for="(item, index) in inputs.monitoring" :key="`category-form-${index}`" class="my-3">
                                            <label class="font-semibold" :for="`field-data-${index}`">{{ item.label }}</label>
                                            <div v-if="inputType(item.type)">
                                                <div v-if="item.image != null">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg h-48 my-3" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                </div>
                                                <div v-if="item.type == 'text'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'textarea'">
                                                    <ckeditor
                                                    :required="item.is_required == 1 ? true : false"
                                                    :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder" :editor="editor"></ckeditor>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'number'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="number"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'checkbox'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :id="`option-${index}-value-${indexOption}`" type="checkbox" :name="`option-checkbox-${index}-value`" :value="item.value" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2" :aria-labelledby="`option-${index}-${indexOption}-checkbox`" :aria-describedby="`option-${index}-${indexOption}-checkbox`">
                                                                <label :for="`option-${index}-value-${indexOption}`" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                {{ option.value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-x-2 w-full">
                                                        <div class="self-center"><span>Yang lain :</span></div>
                                                        <div class="justify-self-stretch">
                                                            <input placeholder="Apabila ada" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'radio'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :id="`option-${index}-value-${indexOption}`" type="radio" :name="`option-radio-${index}-value`" :value="item.value" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" :aria-labelledby="`option-${index}-${indexOption}`" :aria-describedby="`option-${index}-${indexOption}`">
                                                                <label :for="`option-${index}-value-${indexOption}`" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                {{ option.value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'dropdown'">
                                                    <select :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                        <option value="">{{ item.placeholder == null ? 'Pilih data '+item.label : item.placeholder }}</option>
                                                        <option v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`" :value="option.value">{{ option.value }}</option>
                                                    </select>
                                                    <div v-if="item.option.length <= 0">
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'file'">
                                                    <input :placeholder="item.placeholder == null ? 'Pilih data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="file"
                                                    class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'date'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                                        </div>
                                                        <input
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan tanggal data '+item.label : item.placeholder" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'time'">
                                                    <div class="relative">
                                                        <input
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan waktu data '+item.label : item.placeholder" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div v-if="item.type == 'description'">
                                                    <div v-html="item.description"></div>
                                                </div>
                                                <div v-if="item.type == 'image'">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>
                                                <div v-if="item.type == 'media-youtube'">
                                                    <YouTube
                                                        width="100%"
                                                        :src="item.link"
                                                        @ready="onReadyYoutube(index)"
                                                        :ref="`youtube-${index}`" />
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Simpan & Lanjutkan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div v-if="menuForms[menuIndex].name == 'image'">
                                <button @click="toggleFormModal(true, 'create')" type="button" class="w-full mt-4 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                    <plus-circle-icon size="18" class="inline-block mr-4"/>
                                    <span class="inline-block">
                                        Tambah Gambar
                                    </span>
                                </button>
                                <div>
                                    <div v-if="images.length > 0" class="w-full grid grid-cols-2 gap-x-4">
                                        <div v-for="(image, index) in images" :key="`image-${index}`" class="my-3">
                                            <div @click="toggleOptionModal(true, index, image)" v-if="image != null && image != undefined">
                                                <div class="rounded-lg overflow-hidden bg-purple-600 w-full h-32">
                                                    <img v-if="image.name != undefined" :src="'/monitoring/data/'+image.name" class="transition-all rounded-lg object-cover object-center w-full h-32 hover:opacity-75 hover:scale-105" :alt="image.name">
                                                </div>
                                                <p class="text-base">{{ image.label != undefined ? image.label : '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="text-center col-span-2">
                                        <m-no-data text="Belum ada gambar"/>
                                    </div>
                                    <button @click="goBack()" class="col-span-2 text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Selesaikan Monitoring
                                    </button>
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
                                            <div class="p-6 space-y-4">
                                                <div role="button" @click="modalImage = true" class="flex gap-x-4 w-full hover:bg-gray-50 p-2 rounded-lg">
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

                                <div id="formModal" tabindex="-1" aria-hidden="true" :class="{'hidden' : !formModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <div class="flex justify-between items-start p-5 rounded-t border-b">
                                                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                    {{ formModal.mode == 'create' ? 'Gambar Baru' : 'Edit Gambar' }}
                                                </h3>
                                                <button @click="toggleFormModal(false, 'create')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <form @submit.prevent="storeImage()" action="#">
                                                <div class="p-6">
                                                    <div>
                                                        <label for="name-image">Nama Gambar</label>
                                                        <input required name="name" id="name-image" v-model="formImage.label" type="text" placeholder="Masukkan label gambar" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mt-6">
                                                        <div class="flex justify-between mb-3">
                                                            <div>
                                                                <label for="icon-category">File gambar</label>
                                                            </div>
                                                            <div v-if="formImage.image != null">
                                                                <p role="button" @click="clickFile()" class="text-green-600">Ganti Gambar</p>
                                                            </div>
                                                        </div>
                                                        <input @change="changeFile($event)" name="icon" id="image-file" type="file" class="hidden" accept=".jpg, .png, .jpeg">
                                                        <div v-if="formImage.image == null" @click="clickFile()" role="button" class="w-full text-center p-6 border-2 border-dashed border-purple-500 rounded-lg">
                                                            <div class="w-full">
                                                                <image-icon size="3x" class="inline-block text-purple-600"/>
                                                            </div>
                                                            <p class="mt-3 font-semibold text-gray-600">
                                                                Click or Drag and drop <br>
                                                            </p>
                                                        </div>
                                                        <div v-else>
                                                            <img :src="formImage.preview" class="w-full h-40 object-cover rounded-lg object-center inline-block" alt="Default Icon">
                                                        </div>
                                                    </div>
                                                    <div class="mt-6">
                                                        <label for="name-image">Deskripsi Gambar</label>
                                                        <textarea required name="description" id="description-image" v-model="formImage.description" type="text" placeholder="Masukkan deskripsi" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md"></textarea>
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

                                <div id="modalImage" tabindex="-1" aria-hidden="true" :class="{'hidden' : !modalImage}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <div class="flex justify-between items-start p-5 rounded-t border-b">
                                                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                                                    Preview Gambar
                                                </h3>
                                                <button @click="modalImage = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                            <div v-if="optionModal.index != null">
                                                <img :src="'/monitoring/data/'+images[optionModal.index].name" class="w-full h-auto rounded-lg" alt="Preview Image">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="delete-modal" tabindex="-1" :class="{'hidden' : !deleteModal.show}" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 bg-black/30 backdrop-blur h-screen md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto self-center">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                    Hapus Gambar ?
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
                                                    Gambar akan terhapus secara permanen
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
import axios from 'axios'
import CKEditor from '@ckeditor/ckeditor5-vue'
import InlineEditor from '@ckeditor/ckeditor5-build-inline'
import AppLayout from '@/Layouts/AppLayout.vue'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, PlusCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MToast from '@/Components/MToast'
import MNoData from '@/Components/MNoData.vue'
import YouTube from 'vue3-youtube'

export default defineComponent({
    props: ['object', 'category', 'teams', 'inputs', 'monitoring', 'list_employee', 'menu_index', 'images'],
    components: {
        MoreVerticalIcon,
        FileTextIcon,
        EyeIcon,
        AppLayout,
        YouTube,
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
            modalImage: false,
            values: [],
            formImage: this.$inertia.form({
                label: '',
                image: null,
                preview: null,
                description: '',
            }),
            formModal : {
                show: false,
                mode: 'create',
                index: null,
            },
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
                }),
            }
        }
    },
    mounted() {
        this.setMenu()
        this.setInput()
        this.setModelValues()
        if(this.menu_index != null && this.menu_index != undefined) {
            this.menuIndex = this.menu_index
        }
        this.toast.active = this.$page.props.flash.message != null || this.$page.props.flash.message != undefined ? true : false
        if(this.$page.props.flash.status == 'success') this.toast.color = 'green'
        else if(this.$page.props.flash.status == 'failed') this.toast.color = 'red'
        setTimeout(() => {
            this.toast.active = false
        }, 5000);
    },
    methods: {
        storeImage() {
            if(this.formModal.mode == 'create') {
                this.formImage.transform(data => ({
                    ... data,
                    monitoringId: this.monitoring.id
                })).post(this.route('app.image.store'), {
                    onFinish: () => {
                        this.formImage.label = ''
                        this.formImage.preview = null
                        this.formImage.image = null
                        this.formImage.description = ''
                        this.toggleFormModal(false, 'create')
                    }
                })
            } else {
                this.formImage.transform(data => ({
                    ... data,
                    monitoringId: this.monitoring.id,
                    _method: 'PATCH',
                })).post(this.route('app.image.update', {
                    id: this.images[this.optionModal.index].id
                }), {
                    onFinish: () => {
                        this.formImage.label = ''
                        this.formImage.preview = null
                        this.formImage.image = null
                        this.formImage.description = ''
                        this.toggleFormModal(false, 'create')
                    }
                })
            }
        },
        deleteData() {
            this.$inertia.delete(this.route('app.image.destroy', { id: this.images[this.optionModal.index].id  }),
            {
                onFinish: () => {
                    this.formImage.label = ''
                    this.formImage.preview = ''
                    this.formImage.image = ''
                    this.formImage.description = ''
                    this.optionModal.index = null
                    this.toggleDeleteModal(false)
                },
                onSuccess: (response) => {
                    // this.onToast(response)
                }
            })
        },
        toggleFormModal(status, mode, indexId = null) {
            this.toggleOptionModal(false, this.optionModal.index, this.optionModal.item)
            this.setOverflow(status)
            if(indexId != null) {
                this.formImage.label = this.images[indexId].label
                this.formImage.preview = '/monitoring/data/'+this.images[indexId].name
                this.formImage.image = this.images[indexId].name
                this.formImage.description = this.images[indexId].description
            } else this.setNullForm()
            this.formModal.show = status
            if(!status) this.setNullForm()
            this.formModal.mode = mode
        },
        clickFile() {
            document.getElementById('image-file').click()
        },
        onUpload(e) {
            let file = e.target.files[0]
            this.form.general.image = file
            this.$inertia.post(this.route('app.image-monitoring.store'), {
                onFinish: () => {
                    this.toggleFormModal(false, 'create')
                }
            })
        },
        setModelValues() {

        },
        onReadyYoutube(index) {
            this.$refs['youtube-'+index].playVideo()
        },
        lowerCased(str) {
            return str.toLowerCase()
        },
        setInput() {
            this.employees = this.list_employee
            this.form.general.title = this.monitoring.title
            this.form.general.team_id = this.monitoring.team_id
            this.form.general.employee_id = this.monitoring.employee_id
            setTimeout(() => {
                this.form.general.description = this.monitoring.description
            }, 100);
        },
        clickMenu(item, index) {
            this.menuIndex = index
        },
        onToast(color, message) {
            this.toast.active = true
            this.toast.message = message
            this.toast.color = color
            setTimeout(() => {
                this.toast.active = false
            }, 5000);
        },
        inputType(type) {
            let nonInputTypes = ['image', 'description', 'media-youtube'];
            if(!nonInputTypes.includes(type)) return true
            else return false
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
            if(this.inputs.monitoring.length > 0) {
                let monitoring = {
                    name: 'monitoring',
                    label: 'Monitoring data'
                }
                this.menuForms.push(monitoring)
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
                    _method: 'PATCH',
                    category_id: this.category.id,
                    object_id: this.object.id
                }))
                .post(this.route('app.monitoring.update', {
                    id: this.monitoring.id
                }), {
                    onFinish:() => {
                        this.menuIndex = 1
                    }
                })
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
            this.formImage.image = file
            this.formImage.preview = URL.createObjectURL(file)
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
