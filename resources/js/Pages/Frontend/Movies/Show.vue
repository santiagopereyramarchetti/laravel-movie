<template>
    <Head :title="movie.title" />

    <FrontLayout :genres="genres">
        
        <main v-if="movie" class="my-2">
            <section class="bg-gradient-to-r from-indigo-600">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded" :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">{{ movie.title }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>{{ movie.release_date }}</span>
                                    <span class="ml-2 space-x-1">
                                        <Link v-for="genre in movie.genre" :key="genre.id" class="font-bold hover:text-blue-500"
                                            :href="route('genres.show', genre.slug)">
                                            {{ genre.title }}, 
                                        </Link>
                                    </span>
                                    <span class="flex space-x-2">
                                        {{ movie.runtime }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex space-x-4">
                                    <button @click="openModal(trailer)" v-for="trailer in movie.trailers" :key="trailer.id" class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">{{ trailer.name }}</button>
                                </div>
                            </div>
                            <div class="p-8 text-white">
                                <p>{{ movie.overview }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1 class="flex text-gray-500 font-bold text-xl">Movie Casts</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            
                            <MovieCard v-for="cast in movie.casts" :key="cast.id">
                                <template #image>
                                    <Link :href="route('casts.show', cast.slug)">
                                        <img class="" :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`">
                                    </Link>
                                </template>
                                <Link :href="route('casts.show', cast.slug)">
                                    <span class="text-white">{{ cast.name }}</span>
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                    <div class="w-4/12">
                        <h1 class="flex text-gray-500 font-bold text-xl">Latest movies</h1>
                        <div v-if="latests" class="grid grid-cols-3 gap-2">
                            <Link v-for="lmovie in latests" :key="lmovie.id" :href="route('movies.show', lmovie.slug)">
                                <img class="w-full h-full rounded-lg" :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${lmovie.poster_path}`">
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
            <section v-if="movie.tags" class="max-w-6xl mx-auto bg-gradient-to-r from-indigo-600 mt-6 p-2">
                <span v-for="tag in movie.tags" :key="tag.id" class="font-bold text-white hover:text-indigo-200 cursor-pointer mr-2">
                    <Link :href="route('tags.show', tag.slug)">#{{ tag.tag_name }}</Link> 
                </span>
            </section>
        </main>
        
    </FrontLayout>
    
    <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                {{modalTrailer.title}}
              </DialogTitle>
              <div class="mt-2">
                <div class="aspect-w-16 aspect-h-9" v-html="modalTrailer.embed_html"></div>
              </div>

              <div class="mt-4">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="closeModal"
                >
                  Close
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>

</template>

<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import MovieCard from '@/Components/MovieCard.vue'
    import { ref } from 'vue';

    import {
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogPanel,
        DialogTitle,
    } from '@headlessui/vue'

    const props = defineProps({
        'genres': Array,
        'movie': Object,
        'latests': Object,
    })

    const isOpen = ref(false)
    const modalTrailer = ref({})

    const closeModal = () => {
        isOpen.value = false
    }
    const openModal = (trailer) => {
        isOpen.value = true
        modalTrailer.value = trailer
    }

</script>

<style>

</style>
