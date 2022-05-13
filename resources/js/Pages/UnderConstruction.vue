<template>
    <div class="container mx-auto">
        <div class="grid grid-cols-3 gap-4 p-8">
            <div class="text-center col-span-3">
                <img class="lg:w-72 md:w-2/5 inline-block sm:w-3/4" src="/image/maintenance.png" alt="Maintenance">
            </div>
            <div class="col-span-3 my-4 text-center">
                <p class="text-gray-600 text-xl mb-2 font-semibold">Oops...</p>
                <p class="text-2xl font-semibold">Aplikasi ini masih dalam
                    <span class="text-indigo-500">Pengembangan</span>
                    oleh
                    <span class="text-indigo-500 font-bold">Tim Developer</span> (^_^;)
                </p>
                <button @click="onHome()" class="mt-4 py-4 px-12 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Kembali</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        onHome() {
            this.$inertia.get(route('home'))
        }
    }
}
</script>
