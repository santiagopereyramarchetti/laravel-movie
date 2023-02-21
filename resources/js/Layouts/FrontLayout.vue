<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import NavbarFront from '../Components/NavbarFront.vue';
import Footer from '../Components/Footer.vue';

const props = defineProps({
        title: String,
        genres: Array,
    });

</script>

<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen bg-gray-100">
            <!-- Nav -->
            <NavbarFront :genres="genres"></NavbarFront>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
        <Footer></Footer>
    </div>
</template>