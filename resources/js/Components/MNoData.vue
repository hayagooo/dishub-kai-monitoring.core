<template>
    <img src="@/Assets/illustrations/not_found.png" class="mt-4 w-2/5 inline-block" alt="Not Found">
    <div class="mt-4 mb-8">
        <h4 class="text-2xl font-semibold text-gray-600">{{ text }}</h4>
    </div>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true,
        }
    }
}
</script>
