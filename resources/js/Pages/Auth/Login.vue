<template>
    <Head title="Masuk" />
    <m-toast :color="toast.color"
        :is_active="toast.active"
        :message="toast.message"/>
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
            <img class="mx-auto w-6/12 mx-auto h-auto" src="@/Assets/illustrations/login.png" alt="Login Illustrations">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Masuk</h2>
            </div>
            <form id="form-login" @submit.prevent="submit" class="mt-8 space-y-6" action="#" method="POST">
                <input type="hidden" name="remember" value="true">

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">
                                <mail-icon size="1.5x"/>
                            </span>
                        </div>
                        <input v-model="form.email" required type="email" name="email" id="email-input" class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="e.g. email@domain.com">
                    </div>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Kata sandi</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">
                                <lock-icon size="1.5x"/>
                            </span>
                        </div>
                        <input v-model="form.password" required :type="password" name="password" id="password-input" class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md">
                        <div class="absolute inset-y-0 right-6 flex items-center">
                            <span @click="password = 'text'" class="text-gray-500 sm:text-sm" v-if="password == 'password'">
                                <eye-off-icon role="button" size="1.5x"/>
                            </span>
                            <span @click="password = 'password'" class="text-purple-700 sm:text-sm" v-else>
                                <eye-icon role="button" size="1.5x"/>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" v-model="form.remember" name="remember-me" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Ingat Saya </label>
                    </div>
                </div>

                <div>
                    <button :disabled="is_disable" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-purple-500 group-hover:text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Masuk
                    </button>
                </div>
            </form>
            <button type="button" @click="goHome()" class="mt-4 group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-gray-900 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
            Kembali ke beranda
            </button>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import MToast from '@/Components/MToast'
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
            status: String,
            data_login: Object,
        },
        mounted() {
            this.checkDataLogin()
        },
        data() {
            return {
                is_disable: false,
                toast: {
                    color: 'purple',
                    active: false,
                    message: 'Ulangi login sekali lagi',
                },
                password: 'password',
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            checkDataLogin() {
                if((this.data_login.email != null && this.data_login.email != undefined) &&
                (this.data_login.password != null && this.data_login.password != undefined)) {
                    this.form.email = this.data_login.email
                    this.form.password = this.data_login.password
                    this.form.remember = this.data_login.remember
                    this.submit()
                }
            },
            onSubmit() {
                this.$inertia.get(route('under.construction'))
            },
            goHome() {
                this.$inertia.get(this.route('home'))
            },
            onToast(color, message) {
              this.toast.active = true
                this.toast.message = message
                this.toast.color = color
                setTimeout(() => {
                    this.toast.active = false
                }, 5000);
            },
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        _method: 'POST',
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('app.login', {
                        code: this.data_login.code
                    }), {
                        onStart: () => {
                            this.is_disable = true
                        },
                        onFinish: () => {
                            this.is_disable = false
                            this.onToast(this.$page.props.flash.status == 'failed' ? 'red' : 'green', this.$page.props.flash.message)
                        },
                        onError: (error) => {
                            window.location.reload()
                        }
                    })
            }
        }
    })
</script>
