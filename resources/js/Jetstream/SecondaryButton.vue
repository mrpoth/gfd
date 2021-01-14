<template>
    <button :type="type" class="inline-flex items-center px-4 py-2  border border-gray-300 rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest shadow-sm hover:text-white-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-white-800 active:bg-gray-50 transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>
