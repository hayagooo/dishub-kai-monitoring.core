<template>
    <Head title="Verifikasi" />
    <m-toast :color="toast.color"
        :is_active="toast.active"
        :message="$page.props.flash.message"/>
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
        <img class="mx-auto w-6/12 mx-auto h-auto" src="@/Assets/illustrations/login.png" alt="Login Illustrations">
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Verifikasi</h2>
        <p>Masukkan kode verifikasi untuk melanjutkan.</p>
        </div>
        <form @submit.prevent="submit" class="mt-8 space-y-6" action="#" method="POST">
            <input type="hidden" name="remember" value="true">

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Kode Verifikasi</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">
                            <lock-icon size="1.5x"/>
                        </span>
                    </div>
                    <input v-model="form.code" required type="text" name="code" id="code-input" class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="XXXX-XXXX">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-purple-500 group-hover:text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                Verifikasi
                </button>
            </div>
        </form>
         <button type="button" @click="backLogout()" class="mt-4 group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-gray-900 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
        Kembali
        </button>
    </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import MToast from '@/Components/MToast'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { MailIcon, LockIcon, EyeOffIcon, EyeIcon } from '@zhuowenli/vue-feather-icons'

    export default defineComponent({
        components: {
            Head,
            MailIcon,
            LockIcon,
            MToast,
            EyeOffIcon,
            EyeIcon,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                password: 'password',
                toast: {
                    color: 'purple',
                    active: false,
                    message: '',
                },
                form: this.$inertia.form({
                    code: ''
                })
            }
        },

        mounted() {
            this.toast.active = this.$page.props.flash.message != null || this.$page.props.flash.message != undefined ? true : false
            if(this.$page.props.flash.status == 'success') this.toast.color = 'green'
            else if(this.$page.props.flash.status == 'failed') this.toast.color = 'red'
            setTimeout(() => {
                this.toast.active = false
            }, 5000);
        },

        methods: {
            onSubmit() {
                this.$inertia.get(route('under.construction'))
            },
            backLogout() {
                this.$inertia.post(this.route('logout'))
            },
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('app.verification'), {
                        onStart: () => {
                            this.is_disable = true
                        },
                        onFinish: () => {
                            this.form.reset('password')
                            if(this.$page.props.flash.status == 'failed') {
                                this.toast.color = 'red'
                            }
                            else if(this.$page.props.flash.status == 'success') this.toast.color = 'green'
                            else this.toast.color = 'purple'
                            this.toast.active = true
                            setTimeout(() => {
                                this.toast.active = false
                            }, 2000);
                            this.is_disable = false
                        },
                        onError: (error) => {
                            console.log(error)
                        }
                    })
            }
        }
    })
</script>
