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

        <div class="fixed bottom-0 md:inset-y-0 right-0 p-8 w-full md:w-40 flex z-40 pb-20 md:pb-0">
            <div class="self-center inline-block w-full text-center md:w-auto bg-white shadow p-4 text-sm rounded-lg">
                <div class="relative inline-block">
                    <button @click="setFormInput('input')" @mouseover="toggleTooltip('plus-circle')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 mb-0 md:mb-3 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <plus-circle-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'plus-circle', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'plus-circle'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Input Baru
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>
                <div class="relative inline-block">
                    <button @click="setFormInput('image')" @mouseover="toggleTooltip('image')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 mb-0 md:mb-3 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <image-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'image', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'image'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Gambar Baru
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>
                <div class="relative inline-block">
                    <button @click="setFormInput('description')" @mouseover="toggleTooltip('description')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 mb-0 md:mb-3 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <type-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'description', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'description'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Deskripsi & Judul
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>
                <div class="relative inline-block">
                    <button @click="setFormInput('media-youtube')" @mouseover="toggleTooltip('media-youtube')" @mouseleave="toggleTooltip()" type="button" class="py-2.5 mx-1 md:mx-0 px-3 md:px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <youtube-icon size="20"/>
                    </button>
                    <div role="tooltip" :class="{'opacity-0 invisible absolute': tooltip.show != 'media-youtube', 'left-1/2 transform -translate-x-1/2 -top-16': tooltip.show == 'media-youtube'}"
                        class="inline-block absolute z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm transition-opacity duration-300 tooltip">
                        Media Youtube
                        <div class="tooltip-arrow scale-110 text-center inline-block w-full inset-x-0 -bottom-px mt-1" data-popper-arrow></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mb-40 md:mb-0">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                    <div class="p-7 border-b-2 border-gray-100">
                        <button @click="goBack()" type="button" class="py-2.5 mx-2 md:mx-0 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
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
                        <div v-if="datas.category != null && datas.category != undefined"
                        :class="{'col-span-2 md:col-span-1 border-b-2 md:border-b-0': datas.object != null && datas.object != undefined,
                        'col-span-2': datas.object == null || datas.monitoring == undefined}"
                        class="border-gray-100 flex flex-nowrap p-7">
                            <img v-if="datas.category.icon == null" src="@/Assets/defaults/category.png" class="h-12 w-auto inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+datas.category.icon" class="h-12 w-auto inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ datas.category.name }}</p>
                        </div>
                        <div v-if="datas.object != null && datas.object != undefined" class="col-span-2 md:col-span-1 p-7 flex flex-nowrap">
                            <img v-if="datas.object.icon == null" src="@/Assets/defaults/object.png" class="h-12 w-auto inline-block" alt="Default Icon">
                            <img v-else :src="'/monitoring/icon/'+datas.object.icon" class="h-12 w-auto inline-block" alt="Default Icon">
                            <p class="self-center text-base md:text-lg text-gray-700 inline-block ml-4">{{ datas.object.name }}</p>
                        </div>
                    </div>
                    <div id="objects" class="bg-gray-50 relative sm:rounded-xl p-7">
                        <div class="my-2">
                            <h2 class="text-xl text-gray-700 font-semibold">Data Formulir</h2>
                            <p class="text-base text-gray-600">Formulir berdasarkan kebutuhan {{ setModelByData() }}.</p>
                        </div>
                        <div v-if="form_inputs.length > 0">
                            <div class="grid grid-cols-4 md:grid-cols-3 gap-6 mt-3">
                                <div class="col-span-4 md:col-span-3" v-for="(item, index) in form_inputs" :key="`input-${index}`">
                                    <div v-if="item.mode == 'input'">
                                        <div @focus="focusIn(index)" @blur="focusOut(), focus_option = false" :class="{'border-t-4 border-b-0 border-purple-400 pb-3': focus == index, 'border-y-2 border-gray-100': focus != index}" tabindex="-1" class="rounded-lg bg-white">
                                            <div class="grid grid-cols-2 p-3 border-b-2 border-gray-100">
                                                <div class="self-center col-span-2 md:col-span-1 flex justify-self-start flex space-x-2 relative">
                                                    <button @click="setFocusOption(index, item)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                        <more-vertical-icon size="20" class="inline-block"/>
                                                    </button>
                                                    <div v-if="focus_option == index" class="shadow absolute top-10 left-0 bg-white rounded overflow-hidden text-sm">
                                                        <div role="button" @click="onDuplicate(index, item)"
                                                            class="bg-white hover:bg-gray-100 transition-all px-5 py-3">Duplikasi</div>
                                                        <div role="button" @click="setDescription(index, item)"
                                                            :class="{'bg-green-100 text-green-700': item.description != null}"
                                                            class="bg-white hover:bg-gray-100 transition-all px-5 py-3">Deskripsi</div>
                                                        <div role="button" @click="setPlaceholder(index, item)"
                                                            :class="{'bg-green-100 text-green-700': item.placeholder != null}"
                                                            class="bg-white hover:bg-gray-100 transition-all px-5 py-3">Sugesti</div>
                                                    </div>
                                                    <button @click="onDeleteInput(index, item)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                        <trash-icon size="20" class="inline-block"/>
                                                    </button>
                                                    <div class="self-center">
                                                        <label for="required-toggle" @input="setRequired(index)" @click="setRequired(index)" @change="setRequired(index)" class="flex relative items-center cursor-pointer">
                                                            <input type="checkbox" :id="`required-toggle-${index}`" :checked="item.is_required" class="sr-only">
                                                            <div :class="{'bg-purple-600': item.is_required, 'bg-gray-200': !item.is_required}"
                                                                class="w-11 h-6 bg-gray-200 rounded-full border toggle-bg"></div>
                                                            <span class="ml-3 text-sm font-medium text-gray-900">Wajib diisi</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="w-full relative col-span-2 md:col-span-1 self-end" @focus="focusIn(index)" @blur="focusOut()">
                                                    <div v-if="focus_dropdown == index" @focus="focusIn(index)" @blur="focusOut()" class="z-20 rounded shadow fixed h-1/2 md:h-1/3 w-3/4 md:w-1/2 m-auto inset-x-0 inset-y-0 overflow-auto">
                                                        <div v-for="(type, indexType) in form_types" :key="`type-${indexType}`"
                                                            @click.prevent="setTypeInputDropdown(index, type.type)"
                                                            @focus="focusIn(index)" @blur="focusOut()"
                                                            :class="{'bg-gray-100': type.type == item.type_input}"
                                                            class="bg-white w-full hover:bg-gray-100 transition-all px-4 py-3 text-gray-600"
                                                            role="button">
                                                                {{ type.name }}
                                                        </div>
                                                    </div>
                                                    <button @click="focus_dropdown == index ? focus_dropdown = null : focus_dropdown = index" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 w-full bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2">
                                                        {{ form_types.find(input => input.type == item.type_input).name }}
                                                        <chevron-up-icon size="20" :class="{'rotate-180': focus_dropdown != index, 'rotate-0': focus_dropdown == index}" class="inline-block ml-2"/>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="my-4 px-4">
                                                <div class="my-3" v-if="item.preview != null && item.image != null">
                                                    <img :src="item.preview" class="object-cover object-center w-full h-48 rounded-lg" :alt="item.preview">
                                                    <div class="grid grid-cols-2 mb-3">
                                                        <div class="text-gray-600">
                                                            <small>Rekomendasi ukuran : 1920 x 1080 pixel</small>
                                                        </div>
                                                        <div role="button" @click="removeImage(index, item)" class="text-red-600 text-right">
                                                            <p>Hapus gambar</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label :for="`input-label-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Label</label>
                                                    <div class="flex gap-x-4">
                                                        <input :id="`input-label-${index}`" @focus="focusIn(index)" @blur="focusOut()" placeholder="e.g Kondisi Penambat" type="text" v-model="item.label" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        <input class="hidden" :id="`input-image-${index}`" type="file" @change="changeFileInput($event, index)">
                                                        <button @click="clickFileInput(index)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="self-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                                            <image-icon size="16"/>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mt-3 flex text-gray-700 gap-x-4" v-if="item.type_input == 'text'">
                                                    <span>
                                                        <italic-icon size="20" class="inline-block"/>
                                                    </span>
                                                    <span class="self-center">Input tipe text</span>
                                                </div>
                                                <div class="mt-3 flex text-gray-700 gap-x-4" v-if="item.type_input == 'textarea'">
                                                    <span>
                                                        <align-left-icon size="20" class="inline-block"/>
                                                    </span>
                                                    <span class="self-center">Input tipe textarea</span>
                                                </div>
                                                <div class="mt-3 flex text-gray-700 gap-x-4" v-if="item.type_input == 'number'">
                                                    <span>
                                                        <divide-icon size="20" class="inline-block"/>
                                                    </span>
                                                    <span class="self-center">Input tipe angka</span>
                                                </div>
                                                <div class="mt-3 flex text-gray-700 gap-x-4" v-if="item.type_input == 'file'">
                                                    <span>
                                                        <upload-icon size="20" class="inline-block"/>
                                                    </span>
                                                    <span class="self-center">Input tipe file</span>
                                                </div>
                                                <div class="mt-3 flex text-gray-700 gap-x-4" v-if="item.type_input == 'date'">
                                                    <span>
                                                        <calendar-icon size="20" class="inline-block"/>
                                                    </span>
                                                    <span class="self-center">Input tipe kalender</span>
                                                </div>
                                                <div class="mt-3 flex text-gray-700 gap-x-4" v-if="item.type_input == 'time'">
                                                    <span>
                                                        <clock-icon size="20" class="inline-block"/>
                                                    </span>
                                                    <span class="self-center">Input tipe waktu (jam : menit)</span>
                                                </div>
                                                <div class="mt-3 p-3 border-2 rounded-lg" v-if="checkMultiInput(item.type_input)">
                                                    <div class="mt-3 flex text-gray-700 gap-x-4">
                                                        <span v-if="item.type_input == 'radio'">
                                                            <check-circle-icon size="20" class="inline-block"/>
                                                        </span>
                                                        <span v-if="item.type_input == 'checkbox'">
                                                            <check-square-icon size="20" class="inline-block"/>
                                                        </span>
                                                        <span v-if="item.type_input == 'dropdown'">
                                                            <list-icon size="20" class="inline-block"/>
                                                        </span>
                                                        <span class="self-center">Input Opsional : Tipe {{ item.type_input }}</span>
                                                    </div>
                                                    <div v-if="item.options.length > 0">
                                                        <div class="flex my-2" v-for="(option, indexOption) in item.options" :key="`option-${indexOption}`">
                                                            <input @focus="focusIn(index)" @blur="focusOut()" :placeholder="`Opsi ${indexOption + 1}`" type="text" v-model="option.value" :id="`input-${index}-option-${indexOption}`" class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                            <button @click="removeOption(index, indexOption, option)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                                <trash-icon size="20" class="inline-block"/>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <button @click="addOption(index)" class="w-full mt-3 text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                        <plus-circle-icon class="inline-block" size="20"/>
                                                        <span class="inline-block">Tambahkan Opsi</span>
                                                    </button>
                                                </div>
                                                <div class="mt-3" v-if="item.description != null">
                                                    <label :for="`input-description-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                                    <ckeditor :id="`input-description-${index}`" placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="item.description"></ckeditor>
                                                </div>
                                                <div class="mt-3" v-if="item.placeholder != null">
                                                    <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900">Sugesti ( Placeholder )</label>
                                                    <input @focus="focusIn(index)" @blur="focusOut()" placeholder="Masukkan sugesti input" type="text" v-model="item.placeholder" :id="`input-placeholder-${index}`" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="item.mode == 'image'">
                                        <div @focus="focusIn(index)" @blur="focusOut(), focus_option = false" :class="{'border-t-4 border-b-0 border-purple-400 pb-3': focus == index, 'border-y-2 border-gray-100': focus != index}" tabindex="-1" class="rounded-lg bg-white">
                                            <div class="grid grid-cols-2 p-3 border-b-2 border-gray-100">
                                                <div class="self-center flex justify-self-start flex space-x-2 relative">
                                                    <button @click="setFocusOption(index, item)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                        <more-vertical-icon size="20" class="inline-block"/>
                                                    </button>
                                                    <div v-if="focus_option" class="shadow absolute top-10 left-0 bg-white rounded overflow-hidden text-sm">
                                                        <div role="button" @click="setDescription(index, item)"
                                                        :class="{'bg-green-100 text-green-700': item.description != null}"
                                                        class="bg-white hover:bg-gray-100 transition-all px-5 py-3">
                                                            Deskripsi
                                                        </div>
                                                    </div>
                                                    <button @click="onDeleteInput(index, item)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                        <trash-icon size="20" class="inline-block"/>
                                                    </button>
                                                </div>
                                                <div class="self-center flex justify-self-end flex space-x-2 relative">
                                                    <p class="text-lg text-gray-700 font-semibold">Gambar</p>
                                                </div>
                                            </div>
                                            <div class="my-4 px-4">
                                                <div class="my-3" v-if="item.preview != null && item.image != null">
                                                    <img :src="item.preview" class="object-cover object-center w-full h-auto rounded-lg" :alt="item.preview">
                                                    <div class="grid grid-cols-1 mb-3">
                                                        <div role="button" @click="removeImage(index, item)" class="text-red-600 text-right">
                                                            <p>Hapus gambar</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <input class="hidden" :id="`input-image-${index}`" type="file" @change="changeFileInput($event, index)">
                                                    <div  v-if="item.preview == null && item.image == null" @click="clickFileInput(index)" role="button">
                                                        <div class="flex gap-x-4 w-full justify-center h-36 mb-2 text-lg border-dashed border-2 border-purple-600 rounded-lg transition-all ease-in-out hover:bg-gray-200">
                                                            <span class="self-center text-center">
                                                                <image-icon class="text-purple-600" size="2.5x"/>
                                                            </span>
                                                            <div class="self-center text-purple-600">
                                                                Tambahkan Gambar
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label :for="`input-label-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Subjek Gambar</label>
                                                    <div class="relative">
                                                        <input :id="`input-label-${index}`" @focus="focusIn(index)" @blur="focusOut()" placeholder="e.g Gambar Penambat" type="text" v-model="item.label" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    </div>
                                                </div>
                                                <div class="mt-3" v-if="item.description != null">
                                                    <label :for="`input-description-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                                    <ckeditor :id="`input-description-${index}`" placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="item.description"></ckeditor>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="item.mode == 'description'">
                                        <div @focus="focusIn(index)" @blur="focusOut(), focus_option = false" :class="{'border-t-4 border-b-0 border-purple-400 pb-3': focus == index, 'border-y-2 border-gray-100': focus != index}" tabindex="-1" class="rounded-lg bg-white">
                                            <div class="grid grid-cols-2 p-3 border-b-2 border-gray-100">
                                                <div class="self-center flex justify-self-start flex space-x-2 relative">
                                                    <button @click="onDeleteInput(index, item)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                        <trash-icon size="20" class="inline-block"/>
                                                    </button>
                                                </div>
                                                <div class="self-center flex justify-self-end flex space-x-2 relative">
                                                    <p class="text-lg text-gray-700 font-semibold">Judul & Deskripsi</p>
                                                </div>
                                            </div>
                                            <div class="my-4 px-4">
                                                <div>
                                                    <label :for="`input-label-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Subjek</label>
                                                    <div class="relative">
                                                        <input :id="`input-label-${index}`" @focus="focusIn(index)" @blur="focusOut()" placeholder="e.g Subjek Deskripsi" type="text" v-model="item.label" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <label :for="`input-description-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                                    <ckeditor :id="`input-description-${index}`" placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="item.description"></ckeditor>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="item.mode == 'media-youtube'">
                                        <div @focus="focusIn(index)" @blur="focusOut(), focus_option = false" :class="{'border-t-4 border-b-0 border-purple-400 pb-3': focus == index, 'border-y-2 border-gray-100': focus != index}" tabindex="-1" class="rounded-lg bg-white">
                                            <div class="grid grid-cols-2 p-3 border-b-2 border-gray-100">
                                                <div class="self-center flex justify-self-start flex space-x-2 relative">
                                                    <button @click="setFocusOption(index, item)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                        <more-vertical-icon size="20" class="inline-block"/>
                                                    </button>
                                                    <div v-if="focus_option" class="shadow absolute top-10 left-0 bg-white rounded overflow-hidden text-sm">
                                                        <div role="button" @click="setDescription(index, item)"
                                                        :class="{'bg-green-100 text-green-700': item.description != null}"
                                                        class="bg-white hover:bg-gray-100 transition-all px-5 py-3">
                                                            Deskripsi
                                                        </div>
                                                    </div>
                                                    <button @click="onDeleteInput(index, item)" @focus="focusIn(index)" @blur="focusOut()" type="button" class="text-gray-900 bg-white text-center focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-2">
                                                        <trash-icon size="20" class="inline-block"/>
                                                    </button>
                                                </div>
                                                <div class="self-center flex justify-self-end flex space-x-2 relative">
                                                    <p class="text-lg text-gray-700 font-semibold">Media Youtube</p>
                                                </div>
                                            </div>
                                            <div class="my-4 px-4">
                                                <div>
                                                    <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900">Link Youtube</label>
                                                    <div class="flex gap-x-4">
                                                        <button @focus="focusIn(index)" @blur="focusOut()" type="button" class="self-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                                            <youtube-icon class="text-red-600" size="16"/>
                                                        </button>
                                                        <input @focus="focusIn(index)" @blur="focusOut()" placeholder="e.g www.youtube.com/?..." type="text" v-model="item.link" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                        <input class="hidden" :id="`input-image-${index}`" type="file" @change="changeFileInput($event, index)">
                                                    </div>
                                                    <div class="relative mt-3">
                                                        <label :for="`input-label-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Subjek</label>
                                                        <input :id="`input-label-${index}`" @focus="focusIn(index)" @blur="focusOut()" placeholder="e.g Subjek" type="text" v-model="item.label" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-purple-500 block w-full p-2.5">
                                                    </div>
                                                </div>
                                                <div class="mt-3" v-if="item.description != null">
                                                    <label :for="`input-description-${index}`" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                                    <ckeditor :id="`input-description-${index}`" placeholder="e.g. Tujuan monitoring ini adalah untuk kepentingan bersama" :editor="editor" v-model="item.description"></ckeditor>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button v-if="show_back" @click="goBack()" type="button" class="fixed bottom-0 mb-6 left-6 z-50 py-2.5 mx-2 md:mx-0 px-8 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-purple-600 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                <arrow-left-icon size="18" class="inline-block mr-3"/>
                                <span class="inline-block">Kembali</span>
                            </button>
                            <button type="button" @click="onSubmitData()" class="fixed bottom-0 right-0 z-50 focus:outline-none mt-6 text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-16 py-2.5 mb-6 mr-6">
                                <span v-if="!loading_button">
                                    Simpan
                                </span>
                                <span v-else>
                                    <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                    </svg>
                                    Loading...
                                </span>
                            </button>
                        </div>
                        <div v-else class="text-center">
                            <m-no-data text="Belum ada data formulir"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<style scoped>
.ck-editor__editable_inline {
    border: 2px solid gainsboro;
    border-radius: 12px !important;
}
</style>

<script>
import { defineComponent } from 'vue'
import MToast from '@/Components/MToast'
import AppLayout from '@/Layouts/AppLayout.vue'
import axios from 'axios'
import CKEditor from '@ckeditor/ckeditor5-vue'
import InlineEditor from '@ckeditor/ckeditor5-build-inline'
import MUnderConstruction from '@/Components/MUnderConstruction'
import { ArrowLeftIcon, DivideIcon, ListIcon, ChevronUpIcon, CalendarIcon, ClockIcon, UploadIcon, CheckCircleIcon, CheckSquareIcon, PlusCircleIcon, FileIcon, AlignLeftIcon, YoutubeIcon, ItalicIcon, TypeIcon, FileTextIcon, ImageIcon, TrashIcon, MoreVerticalIcon, EditIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'
import MNoData from '@/Components/MNoData.vue'

export default defineComponent({
    props: ['inputs', 'datas', 'token'],
    components: {
        FileIcon,
        YoutubeIcon,
        MoreVerticalIcon,
        ItalicIcon,
        EyeIcon,
        ChevronUpIcon,
        AppLayout,
        MToast,
        ClockIcon,
        DivideIcon,
        CalendarIcon,
        TypeIcon,
        FileTextIcon,
        CheckSquareIcon,
        ListIcon,
        TrashIcon,
        MNoData,
        CheckCircleIcon,
        UploadIcon,
        EditIcon,
        AlignLeftIcon,
        ArrowLeftIcon,
        ImageIcon,
        PlusCircleIcon,
        MUnderConstruction,
        ckeditor: CKEditor.component,
    },
    data() {
        return {
            form_types: [{
                icon: ItalicIcon,
                name: 'Jawaban singkat',
                type: 'text'
            }, {
                icon: AlignLeftIcon,
                name: 'Paragraf',
                type: 'textarea',
            }, {
                icon: DivideIcon,
                name: 'Angka',
                type: 'number'
            }, {
                icon: CheckCircleIcon,
                name: 'Pilihan Ganda',
                type: 'radio',
            }, {
                icon: CheckSquareIcon,
                name: 'Kotak Centang',
                type: 'checkbox',
            }, {
                icon: ListIcon,
                name: 'Dropdown',
                type: 'dropdown',
            }, {
                icon: UploadIcon,
                name: 'Upload File',
                type: 'file'
            }, {
                icon: CalendarIcon,
                name: 'Tanggal',
                type: 'date',
            }, {
                icon: ClockIcon,
                name: 'Waktu',
                type: 'time'
            }],
            focus: null,
            focus_dropdown: null,
            focus_option: null,
            form_inputs: [],
            loading_button: false,
            show_back: false,
            editor: InlineEditor,
            optionModal: {
                show: false,
                index: null,
                item: null,
            },
            tooltip: {
                show: null,
            },
            deleteModal: {
                show: false,
                index: null
            },
            form: this.$inertia.form({
                preview: null,
                name: '',
                icon: null,
            }),
            toast: {
                color: 'purple',
                active: false,
                message: '',
            },
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll)
        this.setInputsAvailable()
    },
    methods: {
        removeImage(index, item) {
            if(item.id != null && item.id != undefined, item.id != '') {
                axios.delete(this.route('api.api.input-monitoring.delete-image', {
                    id: item.id
                }), {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then((response) => {
                    this.form_inputs[index].image = null
                    this.form_inputs[index].preview = null
                    this.onToast('green', 'Gambar berhasil dihapus')
                })
            } else {
                this.form_inputs[index].image = null
                this.form_inputs[index].preview = null
            }
        },
        handleScroll(e) {
            let posY = window.scrollY
            if(posY > 300) this.show_back = true
            else this.show_back = false
        },
        setFocusOption(index, item) {
            if(this.focus_option == index) {
                this.focus_option = null
            } else {
                this.focus_option = index
            }
        },
        setInputsAvailable() {
            if(this.inputs.length > 0) {
                this.inputs.forEach((value, index) => {
                    let mode, preview
                    let nonInput = ['image', 'description', 'media-youtube']
                    if(!nonInput.includes(value.type)) mode = 'input'
                    else mode = value.type
                    if(value.image != null) preview = '/monitoring/input/'+value.image
                    else preview = null
                    let data = {
                        id: value.id,
                        mode: mode,
                        value: '',
                        label: value.label,
                        is_required: value.is_required,
                        option: false,
                        type_input: value.type,
                        link: value.link,
                        description: value.description,
                        image: value.image,
                        preview: preview,
                        placeholder: value.placeholder,
                        options: value.option,
                    }
                    this.form_inputs.push(data)
                })
            }
        },
        onDuplicate(index, item) {
            let newItem = item
            this.form_inputs.push(JSON.parse(JSON.stringify(newItem)))
            this.focus_option = null
            this.onRedirectLabel()
        },
        onRedirectLabel(index) {
            setTimeout(() => {
                let target = this.form_inputs.length - 1
                window.location.href = `#input-label-${target}`
                document.getElementById('input-label-'+target).focus()
            }, 250);
        },
        onRedirectOption(index) {
            setTimeout(() => {
                let target = this.form_inputs[index].options.length - 1
                if(this.form_inputs[index].options.length > 0) {
                    window.location.href = `#input-${index}-option-${target}`
                    document.getElementById('input-'+index+'-option-'+target).focus()
                } else {
                    window.location.href = `#input-label-${index}`
                    document.getElementById('input-label-'+index).focus()
                }
            }, 250);
        },
        onSubmitData() {
            this.loading_button = true
            this.form_inputs.forEach((value, index) => {
                let fm = new FormData()
                console.log(this.form_inputs)
                let url
                fm.append('category_id', this.datas.category.id)
                if(this.datas.object != undefined && this.datas.object != null) fm.append('object_id', this.datas.object.id)
                if(this.datas.monitoring != undefined && this.datas.monitoring != null) fm.append('monitoring_id', this.datas.monitoring.id)
                fm.append('type', value.type_input)
                fm.append('link', value.link)
                fm.append('label', value.label)
                fm.append('placeholder', value.placeholder == null ? '' : value.placeholder)
                fm.append('description', value.description == null ? '' : value.description)
                fm.append('is_required', value.is_required ? 1 : 0)
                fm.append('image', value.image)
                fm.append('options', JSON.stringify(value.options))
                if(value.id != null && value.id != undefined && value.id != '') {
                    fm.append('_method', 'PATCH')
                    url = this.route('api.input-monitoring.update', {
                        id: value.id
                    })
                } else {
                    fm.delete('_method')
                    url = this.route('api.input-monitoring.store')
                }
                axios.post(url, fm, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'content-type': 'multipart/form-data',
                    }
                }).then((response) => {
                    if(index == this.form_inputs.length - 1) {
                        this.loading_button = false
                        this.onToast('green', 'Formulir Monitoring Berhasil Disimpan')
                    }
                })
            })
            setTimeout(() => {
                this.goInput('changed')
            }, 1000);
        },
        onToast(color, message) {
            this.toast.active = true
            this.toast.message = message
            this.toast.color = color
            setTimeout(() => {
                this.toast.active = false
            }, 5000);
        },
        goInput(feedback) {
            let data = {}
            if(this.datas.category != null && this.datas.category != undefined) data.categoryId = this.datas.category.id
            if(this.datas.object != null && this.datas.object != undefined) data.objectId = this.datas.object.id
            if(this.datas.monitoring != null && this.datas.monitoring != undefined) data.monitoringId = this.datas.monitoring.id
            this.$inertia.get(this.route('app.input.index'), data)
        },
        setDescription(index, item) {
            if(this.form_inputs[index].description == null) this.form_inputs[index].description = ''
            else this.form_inputs[index].description = null
            this.form_inputs[index].option = false
            this.focus_option = null
        },
        setPlaceholder(index, item) {
            if(this.form_inputs[index].placeholder == null) this.form_inputs[index].placeholder = ''
            else this.form_inputs[index].placeholder = null
            this.form_inputs[index].option = false
            this.focus_option = null
        },
        clickFileInput(index) {
            document.getElementById('input-image-'+index).click()
        },
        changeFileInput(e, index) {
            let file = e.target.files[0]
            this.form_inputs[index].image = file
            this.form_inputs[index].preview = URL.createObjectURL(file)
        },
        checkMultiInput(value) {
            let singleInput = ['text', 'textarea', 'number', 'file', 'date', 'time']
            let multiInput = ['dropdown', 'checkbox', 'radio']
            return multiInput.includes(value)
        },
        addOption(index) {
            let option = {
                id: '',
                value: '',
                is_checked: false,
            }
            this.form_inputs[index].options.push(option)
            this.onRedirectOption(index)
        },
        removeOption(index, index_option, item) {
            if(item.id != null && item.id != undefined, item.id != '') {
                axios.delete(this.route('api.option-input-monitoring.destroy', {
                    id: item.id
                }), {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then((response) => {
                    this.form_inputs[index].options.splice(index_option, 1)
                    this.onToast('green', 'Input monitoring berhasil dihapus')
                })
            } else this.form_inputs[index].options.splice(index_option, 1)
            this.onRedirectOption(index)
        },
        focusIn(index) {
            this.focus = index
        },
        focusOut() {
            // this.focus_dropdown = null
            this.focus = null
        },
        setTypeInputDropdown(index, type){
            let multiInput = ['dropdown', 'checkbox', 'radio']
            this.form_inputs[index].type_input = type
            if(multiInput.includes(type)) {
                this.addOption(index)
            }
            this.focus_dropdown = null
        },
        onDeleteInput(index, item) {
            if(item.id != null && item.id != undefined && item.id != '') {
                axios.delete(this.route('api.input-monitoring.destroy', {
                    id: item.id
                }), {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then((response) => {
                   this.form_inputs.splice(index, 1)
                })
            } else  this.form_inputs.splice(index, 1)
            this.onRedirectLabel()
        },
        setRequired(index) {
            console.log(this.form_inputs[index].is_required)
            this.form_inputs[index].is_required = !this.form_inputs[index].is_required
        },
        setFormInput(mode) {
            let type_input = ''
            if(mode == 'input') type_input = 'text'
            else type_input = mode

            let data = {
                id: '',
                mode: mode,
                value: '',
                label: '',
                is_required: true,
                option: false,
                type_input: type_input,
                link: '',
                description: null,
                image: null,
                preview: null,
                placeholder: null,
                options: [],
            }
            this.form_inputs.push(data)
            this.onRedirectLabel()
        },
        toggleTooltip(element = null) {
            this.tooltip.show = element
        },
        goBack() {
            if(this.datas.monitoring != null && this.datas.monitoring != undefined) {
                this.$inertia.get(this.route('app.monitoring.index'), {
                    categoryId: this.datas.category.id,
                    objectId: this.datas.object.id,
                })
            }
            else if(this.datas.object != null && this.datas.object != undefined) {
                this.$inertia.get(this.route('app.object.index'), {
                    categoryId: this.datas.category.id
                })
            }
            else {
                this.$inertia.get(this.route('app.category.index'))
            }
        },
        setModelByData() {
            var model_name = ''
            if(this.datas.monitoring != null && this.datas.monitoring != undefined) model_name = 'monitoring data'
            else if(this.datas.object != null && this.datas.object != undefined) model_name = 'objek'
            else model_name = 'kategori'
            return model_name
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
        deleteData() {
            this.$inertia.delete(this.route('app.object.destroy', {
                id: this.objects[this.optionModal.index].id
            }), {
               onSuccess: () => {
                   this.toggleDeleteModal(false)
               }
            })
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
    },
})
</script>
