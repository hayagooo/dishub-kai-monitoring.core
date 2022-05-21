<template>
    <app-layout title="Monitoring">
        <m-toast :color="toast.color"
            :is_active="toast.active"
            :message="toast.message"/>
        <m-error-toast
            :is_active="error.active"
            :message="error.message"/>
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
                            <img v-if="category.icon == null" src="@/Assets/defaults/category.png" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+category.icon" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ truncating(category.name, 20, '...') }}</p>
                        </div>
                        <div class="col-span-2 md:col-span-1 p-7 flex flex-nowrap">
                            <img v-if="object.icon == null" src="@/Assets/defaults/object.png" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+object.icon" class="h-12 w-12 rounded-lg object-cover object-center inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ truncating(object.name, 20, '...') }}</p>
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
                                    <select @change="getEmployee()" required name="team_id" id="team-monitoring" v-model="form.general.team_id" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                        <option :value="0">Pilih Tim Monitoring</option>
                                        <option v-for="(item, index) in teams" :key="`team-${index}`" :value="item.id">{{ item.name }}</option>
                                    </select>
                                </div>
                                <div v-if="form.general.team_id != 0 && (employees && employees.length > 0)" class="mt-6">
                                    <label for="employee-monitoring">Subjek Monitoring</label>
                                    <select required name="employee_id" id="employee-monitoring" v-model="form.general.employee_id" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
                                        <option :value="0">Pilih Pegawai atau Subjek</option>
                                        <option v-for="(item, index) in employees" :key="`employee-${index}`" :value="item.id">{{ item.name }}</option>
                                    </select>
                                </div>
                                <div v-if="form.general.team_id != 0 && (employees == null || employees.length <= 0)">
                                    <div class="p-4 mb-4 mt-2 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                        <span class="font-semibold">Monitoring tidak bisa dilanjutkan !</span> Tidak ada pegawai di dalam tim ini.
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label for="description-monitoring">Deskripsi Monitoring</label>
                                    <div class="rounded mt-3 hidden md:block">
                                        <ckeditor placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="form.general.description"></ckeditor>
                                    </div>
                                    <div class="rounded mt-3 block md:hidden">
                                        <textarea required name="title" v-model="form.general.description" type="text" placeholder="e.g. Deskripsi Monitoring Jembatan Bandung" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" :disabled="loading_button" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        <span v-if="!loading_button">
                                                Simpan & Lanjutkan
                                            </span>
                                            <span v-else>
                                                <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                </svg>
                                                Proses...
                                            </span>
                                    </button>
                                </div>
                            </form>

                            <div v-if="menuForms[menuIndex].name == 'category'">
                                <form @submit.prevent="onSubmitInput('category')" action="#">
                                    <div v-if="inputs.category != null && inputs.category != undefined">
                                        <div v-for="(item, index) in inputs.category" :key="`category-form-${index}`" class="my-3 break-all">
                                            <label class="font-semibold" :for="`field-data-${index}`">{{ item.label }}</label>
                                            <div v-if="inputType(item.type)">
                                                <div v-if="item.image != null">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg h-48 my-3" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                </div>
                                                <div v-if="item.type == 'text'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="text" v-model="values.category[index].string_value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'textarea'">
                                                    <ckeditor v-if="values.category[index]"
                                                    :required="item.is_required == 1 ? true : false" v-model="values.category[index].text_value"
                                                    :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder" :editor="editor"></ckeditor>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'number'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="number" v-model="values.category[index].number_value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'checkbox'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input @change="updateOption(option, index, indexOption)" :id="`option-${index}-value-${indexOption}`" type="checkbox" :name="`option-checkbox-${index}-value`" :checked="option.option_value.length > 0" :value="item.value" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2" :aria-labelledby="`option-${index}-${indexOption}-checkbox`" :aria-describedby="`option-${index}-${indexOption}-checkbox`">
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
                                                            <input v-if="values.category[index]" placeholder="Apabila ada" v-model="values.category[index].string_value" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'radio'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :checked="option.option_value.length > 0" @change="onChangeReset(option, index, indexOption, 'category')" :id="`option-${index}-value-${indexOption}`" type="radio" :name="`option-radio-${index}-value`" :value="item.value" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" :aria-labelledby="`option-${index}-${indexOption}`" :aria-describedby="`option-${index}-${indexOption}`">
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
                                                    <div class="flex flex-wrap gap-4">
                                                        <div class="justify-self-stretch place-self-auto shrink w-full" :class="{'w-7/12 md:w-9/12' : values.category[index].text_value != '', 'w-full': values.category[index].text_value == ''}">
                                                            <select @change="onChangeSelect(index, 'category')" v-model="values.category[index].text_value" :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                            type="text"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                                <option value="">{{ item.placeholder == null ? 'Pilih data '+item.label : item.placeholder }}</option>
                                                                <option :selected="option.option_value.length > 0" v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`" :value="option.id">{{ option.value }}</option>
                                                            </select>
                                                        </div>
                                                        <div v-if="values.category[index].text_value != ''" class="justify-self-end place-self-end">
                                                            <button type="button" @click="onDeleteOptionValue(item, index)" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Kosongkan</button>
                                                        </div>
                                                    </div>
                                                    <div v-if="item.option.length <= 0">
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'file'">
                                                    <div v-if="item.value_data.length > 0" class="bg-white p-4 rounded-lg shadow-lg gap-x-4 relative" :class="{'flex gap-x-4': item.value_data[0].type_file != 'image'}">
                                                        <div @click="onRemoveFile(item.value_data[0].id)" role="button" class="absolute right-0 top-0 m-6">
                                                            <x-circle-icon class="text-gray-600" size="20"/>
                                                        </div>
                                                        <div>
                                                            <img v-if="item.value_data[0].type_file == 'image'" class="w-10/12 h-48 object-cover object-center rounded-lg" :src="`/monitoring/value/${item.value_data[0].file_value}`" :alt="item.value_data[0].type_file">
                                                            <img v-else class="h-10 w-auto" :src="`/image/icon/${item.value_data[0].type_file}.png`" :alt="item.value_data[0].type_file">
                                                        </div>
                                                        <div class="justify-self-stretch self-center">
                                                            {{ item.value_data[0].file_value }}
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <input @change="onUploadFileInput($event, item, index, 'category')" :placeholder="item.placeholder == null ? 'Pilih data '+item.label : item.placeholder"
                                                        :required="item.is_required == 1 ? true : false"
                                                        type="file" accept=".png,.jpeg,.jpg,.xlsx,.pdf,.doc,.docx,.xls,.csv,.ppt,.pptx"
                                                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'date'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <calendar-icon size="20" class="text-gray-700 dark:text-gray-400"/>
                                                        </div>
                                                        <input v-model="values.category[index].date_value"
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan tanggal data '+item.label : item.placeholder" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'time'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <clock-icon size="20" class="text-gray-700 dark:text-gray-400"/>
                                                        </div>
                                                        <input v-model="values.category[index].time_value"
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
                                        <button type="submit" :disabled="loading_button" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            <span v-if="!loading_button">
                                                Simpan & Lanjutkan
                                            </span>
                                            <span v-else>
                                                <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                </svg>
                                                Proses...
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div v-if="menuForms[menuIndex].name == 'object'">
                                <form @submit.prevent="onSubmitInput('object')" action="#">
                                    <div v-if="inputs.object != null && inputs.object != undefined">
                                        <div v-for="(item, index) in inputs.object" :key="`object-form-${index}`" class="my-3 break-all">
                                            <label class="font-semibold" :for="`field-data-${index}`">{{ item.label }}</label>
                                            <div v-if="inputType(item.type)">
                                                <div v-if="item.image != null">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg h-48 my-3" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                </div>
                                                <div v-if="item.type == 'text'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="text" v-model="values.object[index].string_value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'textarea'">
                                                    <ckeditor v-if="values.object[index]"
                                                    :required="item.is_required == 1 ? true : false" v-model="values.object[index].text_value"
                                                    :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder" :editor="editor"></ckeditor>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'number'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="number" v-model="values.object[index].number_value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'checkbox'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input @change="updateOption(option, index, indexOption)" :id="`option-${index}-value-${indexOption}`" type="checkbox" :name="`option-checkbox-${index}-value`" :checked="option.option_value.length > 0" :value="item.value" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2" :aria-labelledby="`option-${index}-${indexOption}-checkbox`" :aria-describedby="`option-${index}-${indexOption}-checkbox`">
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
                                                            <input v-if="values.object[index]" placeholder="Apabila ada" v-model="values.object[index].string_value" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'radio'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :checked="option.option_value.length > 0" @change="onChangeReset(option, index, indexOption, 'object')" :id="`option-${index}-value-${indexOption}`" type="radio" :name="`option-radio-${index}-value`" :value="item.value" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" :aria-labelledby="`option-${index}-${indexOption}`" :aria-describedby="`option-${index}-${indexOption}`">
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
                                                    <div class="flex flex-wrap gap-4">
                                                        <div class="justify-self-stretch place-self-auto shrink w-full" :class="{'w-7/12 md:w-9/12' : values.object[index].text_value != '', 'w-full': values.object[index].text_value == ''}">
                                                            <select @change="onChangeSelect(index, 'object')" v-model="values.object[index].text_value" :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                            type="text"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                                <option value="">{{ item.placeholder == null ? 'Pilih data '+item.label : item.placeholder }}</option>
                                                                <option :selected="option.option_value.length > 0" v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`" :value="option.id">{{ option.value }}</option>
                                                            </select>
                                                        </div>
                                                        <div v-if="values.object[index].text_value != ''" class="justify-self-end place-self-end">
                                                            <button type="button" @click="onDeleteOptionValue(item, index)" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Kosongkan</button>
                                                        </div>
                                                    </div>
                                                    <div v-if="item.option.length <= 0">
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'file'">
                                                    <div v-if="item.value_data.length > 0" class="bg-white p-4 rounded-lg shadow-lg gap-x-4 relative" :class="{'flex gap-x-4': item.value_data[0].type_file != 'image'}">
                                                        <div @click="onRemoveFile(item.value_data[0].id)" role="button" class="absolute right-0 top-0 m-6">
                                                            <x-circle-icon class="text-gray-600" size="20"/>
                                                        </div>
                                                        <div>
                                                            <img v-if="item.value_data[0].type_file == 'image'" class="w-10/12 h-48 object-cover object-center rounded-lg" :src="`/monitoring/value/${item.value_data[0].file_value}`" :alt="item.value_data[0].type_file">
                                                            <img v-else class="h-10 w-auto" :src="`/image/icon/${item.value_data[0].type_file}.png`" :alt="item.value_data[0].type_file">
                                                        </div>
                                                        <div class="justify-self-stretch self-center">
                                                            {{ item.value_data[0].file_value }}
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <input @change="onUploadFileInput($event, item, index, 'object')" :placeholder="item.placeholder == null ? 'Pilih data '+item.label : item.placeholder"
                                                        :required="item.is_required == 1 ? true : false"
                                                        type="file" accept=".png,.jpeg,.jpg,.xlsx,.pdf,.doc,.docx,.xls,.csv,.ppt,.pptx"
                                                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'date'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <calendar-icon size="20" class="text-gray-700 dark:text-gray-400"/>
                                                        </div>
                                                        <input v-model="values.object[index].date_value"
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan tanggal data '+item.label : item.placeholder" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'time'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <clock-icon size="20" class="text-gray-700 dark:text-gray-400"/>
                                                        </div>
                                                        <input v-model="values.object[index].time_value"
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
                                        <button type="submit" :disabled="loading_button" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            <span v-if="!loading_button">
                                                Simpan & Lanjutkan
                                            </span>
                                            <span v-else>
                                                <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                </svg>
                                                Proses...
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>



                            <div v-if="menuForms[menuIndex].name == 'monitoring'">
                                <form @submit.prevent="onSubmitInput('monitoring')" action="#">
                                    <div v-if="inputs.monitoring != null && inputs.monitoring != undefined">
                                        <div v-for="(item, index) in inputs.monitoring" :key="`monitoring-form-${index}`" class="my-3 break-all">
                                            <label class="font-semibold" :for="`field-data-${index}`">{{ item.label }}</label>
                                            <div v-if="inputType(item.type)">
                                                <div v-if="item.image != null">
                                                    <img class="object-cover object-center w-full h-auto rounded-lg h-48 my-3" :src="'/monitoring/input/'+item.image" :alt="item.image">
                                                </div>
                                                <div v-if="item.type == 'text'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="text" v-model="values.monitoring[index].string_value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'textarea'">
                                                    <ckeditor v-if="values.monitoring[index]"
                                                    :required="item.is_required == 1 ? true : false" v-model="values.monitoring[index].text_value"
                                                    :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder" :editor="editor"></ckeditor>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'number'">
                                                    <input :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                    :required="item.is_required == 1 ? true : false"
                                                    type="number" v-model="values.monitoring[index].number_value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'checkbox'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input @change="updateOption(option, index, indexOption)" :id="`option-${index}-value-${indexOption}`" type="checkbox" :name="`option-checkbox-${index}-value`" :checked="option.option_value.length > 0" :value="item.value" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2" :aria-labelledby="`option-${index}-${indexOption}-checkbox`" :aria-describedby="`option-${index}-${indexOption}-checkbox`">
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
                                                            <input v-if="values.monitoring[index]" placeholder="Apabila ada" v-model="values.monitoring[index].string_value" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'radio'">
                                                    <div v-if="item.option.length > 0">
                                                        <div v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`">
                                                            <div class="flex items-center mb-4">
                                                                <input :checked="option.option_value.length > 0" @change="onChangeReset(option, index, indexOption, 'monitoring')" :id="`option-${index}-value-${indexOption}`" type="radio" :name="`option-radio-${index}-value`" :value="item.value" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" :aria-labelledby="`option-${index}-${indexOption}`" :aria-describedby="`option-${index}-${indexOption}`">
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
                                                    <div class="flex flex-wrap gap-4">
                                                        <div class="justify-self-stretch place-self-auto shrink w-full" :class="{'w-7/12 md:w-9/12' : values.monitoring[index].text_value != '', 'w-full': values.monitoring[index].text_value == ''}">
                                                            <select @change="onChangeSelect(index, 'monitoring')" v-model="values.monitoring[index].text_value" :placeholder="item.placeholder == null ? 'Masukkan data '+item.label : item.placeholder"
                                                            type="text"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                                <option value="">{{ item.placeholder == null ? 'Pilih data '+item.label : item.placeholder }}</option>
                                                                <option :selected="option.option_value.length > 0" v-for="(option, indexOption) in item.option" :key="`option-${indexOption}`" :value="option.id">{{ option.value }}</option>
                                                            </select>
                                                        </div>
                                                        <div v-if="values.monitoring[index].text_value != ''" class="justify-self-end place-self-end">
                                                            <button type="button" @click="onDeleteOptionValue(item, index)" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Kosongkan</button>
                                                        </div>
                                                    </div>
                                                    <div v-if="item.option.length <= 0">
                                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg mt-2" role="alert">
                                                            <span class="font-medium">Perlu Diperthatikan! :</span> Opsi kosong, beritahu admin untuk mengisi opsi.
                                                        </div>
                                                    </div>
                                                    <small v-if="item.description != null" v-html="item.description"></small>
                                                </div>

                                                <div v-if="item.type == 'file'">
                                                    <div v-if="item.value_data.length > 0" class="bg-white p-4 rounded-lg shadow-lg gap-x-4 relative" :class="{'flex gap-x-4': item.value_data[0].type_file != 'image'}">
                                                        <div @click="onRemoveFile(item.value_data[0].id)" role="button" class="absolute right-0 top-0 m-6">
                                                            <x-circle-icon class="text-gray-600" size="20"/>
                                                        </div>
                                                        <div>
                                                            <img v-if="item.value_data[0].type_file == 'image'" class="w-10/12 h-48 object-cover object-center rounded-lg" :src="`/monitoring/value/${item.value_data[0].file_value}`" :alt="item.value_data[0].type_file">
                                                            <img v-else class="h-10 w-auto" :src="`/image/icon/${item.value_data[0].type_file}.png`" :alt="item.value_data[0].type_file">
                                                        </div>
                                                        <div class="justify-self-stretch self-center">
                                                            {{ item.value_data[0].file_value }}
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <input @change="onUploadFileInput($event, item, index, 'monitoring')" :placeholder="item.placeholder == null ? 'Pilih data '+item.label : item.placeholder"
                                                        :required="item.is_required == 1 ? true : false"
                                                        type="file" accept=".png,.jpeg,.jpg,.xlsx,.pdf,.doc,.docx,.xls,.csv,.ppt,.pptx"
                                                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'date'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <calendar-icon size="20" class="text-gray-700 dark:text-gray-400"/>
                                                        </div>
                                                        <input v-model="values.monitoring[index].date_value"
                                                        :required="item.is_required == 1 ? true : false"
                                                        :placeholder="item.placeholder == null ? 'Tentukan tanggal data '+item.label : item.placeholder" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                                        <small v-if="item.description != null" v-html="item.description"></small>
                                                    </div>
                                                </div>

                                                <div v-if="item.type == 'time'">
                                                    <div class="relative">
                                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                            <clock-icon size="20" class="text-gray-700 dark:text-gray-400"/>
                                                        </div>
                                                        <input v-model="values.monitoring[index].time_value"
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
                                        <button type="submit" :disabled="loading_button" class="text-white w-full bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            <span v-if="!loading_button">
                                                Simpan & Lanjutkan
                                            </span>
                                            <span v-else>
                                                <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                </svg>
                                                Proses...
                                            </span>
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
                                    <div v-if="images.length > 0" class="w-full grid grid-cols-2 gap-x-4 break-all">
                                        <div v-for="(image, index) in images" :key="`image-${index}`" class="my-3">
                                            <div @click="toggleOptionModal(true, index, image)" v-if="image != null && image != undefined">
                                                <div class="rounded-lg overflow-hidden bg-purple-600 w-full h-32">
                                                    <img v-if="image.name != undefined" :src="'/monitoring/data/'+image.name" class="transition-all rounded-lg object-cover object-center w-full h-32 hover:opacity-75 hover:scale-105" :alt="image.name">
                                                </div>
                                                <p class="text-base">{{ image.label != undefined ? truncating(image.label, 24, '...') : '-' }}</p>
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
                                            <div class="p-6 max-h-96 overflow-y-auto space-y-4">
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
                                                <div class="p-6 max-h-96 overflow-y-auto">
                                                    <div>
                                                        <label for="name-image">Nama Gambar</label>
                                                        <input maxlength="100" required name="name" id="name-image" v-model="formImage.label" type="text" placeholder="Masukkan label gambar" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md">
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
                                                                Tambahkan Gambar <br>
                                                                <small>Maksimal 2mb</small>
                                                            </p>
                                                        </div>
                                                        <div v-else>
                                                            <img :src="formImage.preview" class="w-full h-40 object-cover rounded-lg object-center inline-block" alt="Default Icon">
                                                            <p class="mt-3 font-semibold text-gray-600">
                                                                <small>Maksimal 2mb</small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-6">
                                                        <label for="name-image">Deskripsi Gambar</label>
                                                        <textarea name="description" id="description-image" v-model="formImage.description" type="text" placeholder="Masukkan deskripsi" class="mt-3 focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md"></textarea>
                                                    </div>
                                                </div>
                                                <div class="flex gap-x-4 items-center flex-row-reverse p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                    <button :disabled="loading_button" type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        <span v-if="!loading_button">
                                                            Simpan
                                                        </span>
                                                        <span v-else>
                                                            <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                            </svg>
                                                            Proses...
                                                        </span>
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
                                            <div class="max-h-96 overflow-y-auto" v-if="optionModal.index != null">
                                                <img :src="'/monitoring/data/'+images[optionModal.index].name" class="w-full h-auto rounded-lg" alt="Preview Image">
                                            </div>
                                            <div class="flex flex-row-reverse items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                                <button @click="modalImage = false" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
                                                    Hapus Gambar ?
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
                                                    Gambar akan terhapus secara permanen
                                                </h3>
                                                <div class="flex justify-between">
                                                    <button @click="toggleDeleteModal(false)" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                                                    <button :disabled="loading_button" @click="deleteData()" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        <span v-if="!loading_button">
                                                            Hapus
                                                        </span>
                                                        <span v-else>
                                                            <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                            </svg>
                                                            Proses...
                                                        </span>
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
import MErrorToast from '@/Components/MErrorToast'
import InlineEditor from '@ckeditor/ckeditor5-build-inline'
import AppLayout from '@/Layouts/AppLayout.vue'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, CalendarIcon, ClockIcon, PlusCircleIcon, XCircleIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon,  } from '@zhuowenli/vue-feather-icons'
import MToast from '@/Components/MToast'
import MNoData from '@/Components/MNoData.vue'
import YouTube from 'vue3-youtube'
import moment from 'moment'

export default defineComponent({
    props: ['object', 'category', 'teams', 'inputs', 'monitoring', 'list_employee', 'menu_index', 'images', 'token'],
    components: {
        MoreVerticalIcon,
        FileTextIcon,
        MErrorToast,
        EyeIcon,
        AppLayout,
        YouTube,
        CalendarIcon,
        ClockIcon,
        MToast,
        TrashIcon,
        XCircleIcon,
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
            files_input: null,
            loading_button: false,
            values: {
                category: [],
                object: [],
                monitoring: [],
            },
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
            error: {
                active: false,
                message: '',
            },
            menuForms: [
            {   name: 'general',
                label: 'Umum',
            }],
            employees: [],
            errors: [],
            exceptions: [],
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
        this.toast.message = this.$page.props.flash.message
        if(this.$page.props.flash.status == 'success') this.toast.color = 'green'
        else if(this.$page.props.flash.status == 'failed') this.toast.color = 'red'
        setTimeout(() => {
            this.toast.active = false
        }, 5000);
    },
    methods: {
        truncating(text, length, suffix) {
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
            }
        },
        onErrorToast(errors) {
            console.log(errors)
            this.error.message = errors
            this.error.active = true
            setTimeout(() => {
                this.error.active = false
            }, 5000);
        },
        storeImage() {
            if(this.formImage.image == null) {
                this.onToast('red', 'Gambar tidak boleh kosong')
                return false
            }
            this.loading_button = true
            if(this.formModal.mode == 'create') {
                this.formImage.transform(data => ({
                    ... data,
                    monitoringId: this.monitoring.id
                })).post(this.route('app.image.store'), {
                    onFinish: () => {
                        this.loading_button = false
                        this.formImage.label = ''
                        this.formImage.preview = null
                        this.formImage.image = null
                        this.formImage.description = ''
                        this.toggleFormModal(false, 'create')
                    },
                    onSuccess: () => {
                        this.onToast('green', 'Gambar berhasil disimpan')
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
                        this.loading_button = false
                        this.formImage.label = ''
                        this.formImage.preview = null
                        this.formImage.image = null
                        this.formImage.description = ''
                        this.toggleFormModal(false, 'create')
                    },
                    onSuccess: () => {
                        this.onToast('green', 'Gambar berhasil diedit')
                    }
                })
            }
        },
        onChangeSelect(index, type) {
            let mOptions
            if(type == 'category') mOptions = this.inputs.category[index].option
            else if(type == 'object') mOptions = this.inputs.object[index].option
            else this.inputs.monitoring[index].option
            if(mOptions.length > 0) {
                mOptions.forEach((item) => {
                    let fm = new FormData()
                    fm.append('input_id', item.monitoring_input_id)
                    fm.append('value', item.value)
                    fm.append('is_checked', 0)
                    fm.append('_method', 'PATCH')
                    axios.post(this.route('api.option-input-monitoring.update', {
                        id: item.id
                    }), fm, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                })
            }
            let dataId
            if(type == 'category') dataId = this.values.category[index].text_value
            else if(type == 'object') dataId = this.values.object[index].text_value
            else dataId = this.values.monitoring[index].text_value
            // if(dataId != null && dataId != '' && dataId != undefined) {
            let option = mOptions.find(item => item.id == dataId)
            this.updateOption(option, index, null)
            // }
        },
        onCheckValue(str) {
            if(str == null || str == '' || str == undefined || str == 'null') return '-'
            else return str
        },
        onSubmitInput(type) {
            let mValue = null
            this.loading_button = true
            if(type == 'category') mValue = this.values.category
            else if(type == 'object') mValue = this.values.object
            else if(type == 'monitoring') mValue = this.values.monitoring
            mValue.forEach((item, index) => {
                let fm = new FormData()
                fm.append('input_id', item.monitoring_input_id)
                fm.append('type', type)
                fm.append('monitoring_id', this.monitoring.id)
                fm.append('string_value', this.onCheckValue(item.string_value))
                fm.append('text_value', this.onCheckValue(item.text_value))
                if(item.number_value == '' || item.number_value == null) fm.append('number_value', 0)
                else fm.append('number_value', item.number_value)
                if(item.date_value == '') fm.append('date_value', moment().format('YYYY-MM-DD'))
                else fm.append('date_value', item.date_value)
                if(item.time_value == '') fm.append('time_value', moment().format('HH:mm'))
                else fm.append('time_value', item.time_value)
                axios.post(this.route('api.value.store'), fm, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then((response) => {
                    if(index == mValue.length - 1) {
                        this.menuIndex++
                        this.onToast('green', 'Berhasil disimpan')
                        this.loading_button = false
                    }
                }).catch((errors) => {
                    console.log(errors.response)
                    if(errors.response.data.errors.string_value != undefined && errors.response.data.errors.string_value != null && errors.response.data.errors.string_value.length > 0) {
                        this.errors.push(...errors.response.data.errors.string_value)
                    }
                    if(errors.response.data.errors.file_value != undefined && errors.response.data.errors.file_value != null && errors.response.data.errors.file_value.length > 0) {
                        this.errors.push(...errors.response.data.errors.file_value)
                    }
                    if(errors.response.data.errors.text_value != undefined && errors.response.data.errors.text_value != null && errors.response.data.errors.text_value.length > 0) {
                        this.errors.push(...errors.response.data.errors.text_value)
                    }
                    if(errors.response.data.errors.number_value != undefined && errors.response.data.errors.number_value != null && errors.response.data.errors.number_value.length > 0) {
                        this.errors.push(...errors.response.data.errors.number_value)
                    }
                    if(errors.response.data.errors.date_value != undefined && errors.response.data.errors.date_value != null && errors.response.data.errors.date_value.length > 0) {
                        this.errors.push(...errors.response.data.errors.date_value)
                    }
                    if(errors.response.data.errors.time_value != undefined && errors.response.data.errors.time_value != null && errors.response.data.errors.time_value.length > 0) {
                        this.errors.push(...errors.response.data.errors.time_value)
                    }
                    this.exceptions = [...new Set(this.errors)]
                    if(this.exceptions.length > 0) {
                        this.onErrorToast(this.exceptions)
                    }
                    if(index == mValue.length - 1) {
                        this.onToast('red', 'Terjadi kesalahan: Ulangi')
                        this.loading_button = false
                    }
                })
            })
        },
        onUploadFileInput(e, item, index, type) {
            let file = e.target.files[0]
            this.files_input = file
            let images_files = ['png', 'jpg', 'jpeg']
            let docs_files = ['doc', 'docx']
            let excels_files = ['xlsx', 'xls']
            let ppt_files = ['ppt', 'pptx']
            let result
            let filename = file.name
            let extension = filename.split('.').pop()
            if(images_files.includes(extension)) {
                result = 'image'
            } else if(docs_files.includes(extension)) {
                result = 'document'
            } else if(excels_files.includes(extension)) {
                result = 'excel'
            } else if(ppt_files.includes(extension)) {
                result = 'ppt'
            } else if(extension == 'pdf') {
                result = 'pdf'
            } else {
                alert('File format tidak didukung')
                return false
            }
            let fm = new FormData()
            fm.append('input_id', item.id)
            fm.append('monitoring_id', this.monitoring.id)
            fm.append('file', this.files_input)
            fm.append('type_file', result)
            fm.append('type', this.menuForms[this.menuIndex].name)
            this.$inertia.post(this.route('app.value.store'), fm, { preserveState: true, preserveScroll: true,
                onSuccess: () => {
                    this.files_input = null
                }
            })
        },
        onChangeReset(option, index, index_option, type) {
            let mOptions
            if(type == 'category') mOptions = this.inputs.category[index].option
            else if(type == 'object') mOptions = this.inputs.object[index].option
            else this.inputs.monitoring[index].option
            if(mOptions.length > 0) {
                mOptions.forEach((item) => {
                    let fm = new FormData()
                    fm.append('input_id', item.monitoring_input_id)
                    fm.append('value', item.value)
                    fm.append('monitoring_id', this.monitoring.id)
                    fm.append('is_checked', 0)
                    fm.append('_method', 'PATCH')
                    axios.post(this.route('api.option-input-monitoring.update', {
                        id: item.id
                    }), fm, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                })
            }
            this.updateOption(option, index, index_option)
        },
        onRemoveFile(id) {
            this.$inertia.delete(this.route('app.value.destroy', {
                id: id
            }), { preserveState: true, preserveScroll: true,
                onFinish: () => {
                    this.files_input = null
                }
            })
        },
        deleteData() {
            this.loading_button = true
            this.$inertia.delete(this.route('app.image.destroy', { id: this.images[this.optionModal.index].id  }),
            {
                onFinish: () => {
                    this.loading_button = false
                    this.formImage.label = ''
                    this.formImage.preview = ''
                    this.formImage.image = ''
                    this.formImage.description = ''
                    this.optionModal.index = null
                    this.toggleDeleteModal(false)
                },
                onSuccess: (response) => {
                    this.onToast('green', 'Gambar berhasil dihapus')
                }
            })
        },
        updateOption(option, index, index_option) {
            let value
            if(option.option_value.length > 0) value = 0
            else value = 1
            let fm = new FormData()
            fm.append('_method', 'PATCH')
            fm.append('input_id', option.monitoring_input_id)
            fm.append('monitoring_id', this.monitoring.id)
            fm.append('value', option.value)
            fm.append('option_id', option.id)
            fm.append('is_checked', value)
            axios.post(this.route('api.option-input-monitoring.update', {
                id: option.id
            }), fm, {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            }).then((response) => {
                this.$inertia.get(this.route('app.monitoring.edit', {
                    id: this.monitoring.id
                }), {
                    categoryId: this.category.id,
                    objectId: this.object.id,
                }, {
                    preserveState: true,
                    preserveScroll: true
                })
            })
        },
        onDeleteOptionValue(item, index) {
            let menuName = this.menuForms[this.menuIndex].name
            let optionId
            if(menuName == 'category') optionId = this.values.category[index].text_value
            else if(menuName == 'object') optionId = this.values.object[index].text_value
            else optionId = this.values.monitoring[index].text_value
            this.$inertia.post(this.route('app.input-option.destroy', {
                id: item.id
            }), {
                _method: 'DELETE',
                monitoringId: this.monitoring.id,
                optionId: optionId,
            }, {
                preserveScroll: true,
                onFinish: () => {
                    this.values.category[index].text_value = ''
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
            if(this.inputs.category.length > 0) {
                this.inputs.category.forEach((item, index) => {
                    let value_dropdown = ''
                    if(item.type == 'dropdown') {
                        item.option.forEach((option, indexOption) => {
                            let value_checked = option.option_value.find(item => item.monitoring_input_option_id == option.id)
                            if(value_checked != undefined && value_checked != null) {
                                value_dropdown = value_checked.monitoring_input_option_id
                            }
                        })
                    }
                    let lengthData = this.inputs.category[index].value_data.length > 0
                    let dataValue =  this.inputs.category[index].value_data
                    let data = {
                        monitoring_input_id: item.id,
                        type: 'category',
                        monitoring_id: this.monitoring.id,
                        string_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].string_value : '',
                        date_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].date_value : '',
                        file_value: '',
                        time_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].time_value : '',
                        number_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].number_value : '',
                        text_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].text_value : value_dropdown,
                    }
                    this.values.category.push(data)
                })
            }
            if(this.inputs.object.length > 0) {
                this.inputs.object.forEach((item, index) => {
                    let value_dropdown = ''
                    if(item.type == 'dropdown') {
                        item.option.forEach((option, indexOption) => {
                            let value_checked = option.option_value.find(item => item.monitoring_input_option_id == option.id)
                            if(value_checked != undefined && value_checked != null) {
                                value_dropdown = value_checked.monitoring_input_option_id
                            }
                        })
                    }
                    let lengthData = this.inputs.object[index].value_data.length > 0
                    let dataValue =  this.inputs.object[index].value_data
                    let data = {
                        monitoring_input_id: item.id,
                        type: 'object',
                        monitoring_id: this.monitoring.id,
                        string_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].string_value : '',
                        date_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].date_value : '',
                        file_value: '',
                        time_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].time_value : '',
                        number_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].number_value : '',
                        text_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].text_value : value_dropdown,
                    }
                    this.values.object.push(data)
                })
            }
            if(this.inputs.monitoring.length > 0) {
                this.inputs.monitoring.forEach((item, index) => {
                    let value_dropdown = ''
                    if(item.type == 'dropdown') {
                        item.option.forEach((option, indexOption) => {
                            let value_checked = option.option_value.find(item => item.monitoring_input_option_id == option.id)
                            if(value_checked != undefined && value_checked != null) {
                                value_dropdown = value_checked.monitoring_input_option_id
                            }
                        })
                    }
                    let lengthData = this.inputs.monitoring[index].value_data.length > 0
                    let dataValue =  this.inputs.monitoring[index].value_data
                    let data = {
                        monitoring_input_id: item.id,
                        type: 'monitoring',
                        monitoring_id: this.monitoring.id,
                        string_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].string_value : '',
                        date_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].date_value : '',
                        file_value: '',
                        time_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].time_value : '',
                        number_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].number_value : '',
                        text_value: dataValue[0] != null && lengthData && dataValue[0] != undefined ? dataValue[0].text_value : value_dropdown,
                    }
                    this.values.monitoring.push(data)
                })
            }
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
            if(this.form.general.employee_id == 0) {
                this.onToast('red', 'Subjek monitoring / pegawai tidak boleh kosong')
                return false
            }
            this.loading_button = true
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
                        this.onToast('green', 'Berhasil disimpan')
                        this.menuIndex = 1
                        this.loading_button = false
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
