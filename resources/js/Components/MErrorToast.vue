<template>
    <div class="transition duration-300 ease-in-out" :class="{'inline-block': is_active, 'invisible': !is_active}">
        <div class="fixed z-50 top-8 right-8">
            <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"
                    :class="`bg-${color}-100 text-${color}-500`">
                    <span>
                        <x-icon size="20"/>
                    </span>
                </div>
                <div class="ml-3 mr-3 text-sm font-normal">
                    <ul>
                        <li v-for="(item, index) in message" :key="index">{{ item }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { CheckIcon, XIcon, InfoIcon } from '@zhuowenli/vue-feather-icons'
export default {
    components: {
        CheckIcon,
        XIcon,
        InfoIcon,
    },
    props: {
        color: {
            type: String,
            default: 'red'
        },
        is_active: {
            required: true,
            type: Boolean
        },
        message: {
        },
    },
    data() {
        return {
            active: false,
        }
    },
    mounted() {
        this.active = this.is_active
    },
    methods: {
        onCloseToast() {
            this.active = !this.active
        }
    }
}
</script>
