<template>
    <Head title="Welcome" />

    <FrontLayout :genres="genres">
        Content
    </FrontLayout>
    
</template>

<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    import FrontLayout from '../Layouts/FrontLayout.vue';

    const props = defineProps({
        'genres': Array
    })
</script>

<style>

</style>
