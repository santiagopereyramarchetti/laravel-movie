<template>
    <Head :title="cast.name" />

    <FrontLayout :genres="genres">
        
        <main v-if="cast" class="my-2">
            <section class="bg-gradient-to-r from-indigo-600">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded" :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">{{ cast.name }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>Movies: {{ movies.length }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        
                    </div>
                    <div class="w-full">
                        <h1 class="flex text-gray-500 font-bold text-xl">{{cast.name}} Movies</h1>
                        <div v-if="movies" class="grid grid-cols-3 gap-2">
                            <Link v-for="lmovie in movies.data" :key="lmovie.id" :href="route('movies.show', lmovie.slug)">
                                <img class="w-full h-full rounded-lg" :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${lmovie.poster_path}`">
                            </Link>
                        </div>
                        <div class="m-2 p-2 bg-500">
                            <Pagination :links="movies.links"></Pagination>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </FrontLayout>

</template>

<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import MovieCard from '@/Components/MovieCard.vue'
    import Pagination from '../../../Components/Pagination.vue';

    const props = defineProps({
        'genres': Array,
        'cast': Object,
        'movies': Object,
    })
    
</script>

<style>

</style>
