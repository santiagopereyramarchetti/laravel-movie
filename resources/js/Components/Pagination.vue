<template>
    <div class="flex">
        <template v-for="(link, index) in links" :key="index">
            <div v-if="link.url == null" v-html="link.label"  class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"></div>
            <Link v-if="link.url != null" :href="link.url" v-html="link.label" :class="{'bg-indigo-200' : link.active}" class="mb-1 mr-1 px-4 py-3 text-sm leading-4 border rounded focus:text-indigo-500 focus:border-indigo-500 hover:bg-gray-100" preserve-scroll></Link>
        </template>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    const props = defineProps({
        links: Array
    })
</script>

<style>

</style>