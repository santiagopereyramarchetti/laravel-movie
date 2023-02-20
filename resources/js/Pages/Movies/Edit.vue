<template>
    <AdminLayout title="Dashboard">
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie
              </h2>
          </template>
  
          <div class="py-12">
              <div class="max-w-7xl mx-auto">
  
                
                <section class="container mx-auto p-6 font-mono">
                  <div class="w-full flex mb-4 p-2">
                    <Link :href="route('admin.movies.index')" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Movie Index</Link>
                  </div>
  
                  <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white sm:max-w-md">
                    <div class="w-full overflow-x-auto">
                      
                        <form @submit.prevent="submitMovie">
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="title"
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="runtime" value="Runtime" />
                                <TextInput
                                    id="runtime"
                                    v-model="form.runtime"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="runtime"
                                />
                                <InputError class="mt-2" :message="form.errors.runtime" />
                            </div>

                            <div>
                                <InputLabel for="language" value="Language" />
                                <TextInput
                                    id="language"
                                    v-model="form.language"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocusruntime
                                    autocomplete="language"
                                />
                                <InputError class="mt-2" :message="form.errors.language" />
                            </div>

                            <div>
                                <InputLabel for="video_format" value="Video Format" />
                                <TextInput
                                    id="video_format"
                                    v-model="form.video_format"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="video_format"
                                />
                                <InputError class="mt-2" :message="form.errors.video_format" />
                            </div>

                            <div>
                                <InputLabel for="rating" value="Rating" />
                                <TextInput
                                    id="rating"
                                    v-model="form.rating"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="rating"
                                />
                                <InputError class="mt-2" :message="form.errors.rating" />
                            </div>

                            <div>rating
                                <InputLabel for="backdrop_path" value="Backdrop path" />
                                <TextInput
                                    id="backdrop_path"
                                    v-model="form.backdrop_path"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="backdrop_path"
                                />
                                <InputError class="mt-2" :message="form.errors.backdrop_path" />
                            </div>

                            <div>
                                <InputLabel for="overview" value="Overview" />
                                <TextInput
                                    id="overview"
                                    v-model="form.overview"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="overview"
                                />
                                <InputError class="mt-2" :message="form.errors.overview" />
                            </div>

                            <div>
                                <InputLabel for="is_public" value="Public" />
                                <div class="flex items-center">
                                    <Checkbox id="is_public" v-model:checked="form.is_public" name="is_public" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.is_public" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update
                                </PrimaryButton>
                            </div>
                        </form>

                    </div>
                  </div>
                </section>
  
  
  
              </div>
          </div>
    </AdminLayout>
  </template>
  
  <script setup>
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import { Link, useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';

    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import Checkbox from '@/Components/Checkbox.vue';
  
    const props = defineProps({
      'movie': Object,
    })

    const form = useForm({
        title: props.movie.title,
        poster_path: props.movie.poster_path,
        video_format: props.movie.video_format,
        runtime: props.movie.runtime,
        rating: props.movie.rating,
        backdrop_path: props.movie.backdrop_path,
        is_public: props.movie.is_public ? true : 'false',
        language: props.movie.lang,
        overview: props.movie.overview,
    })

    const submitMovie = () => {
        form.put('/admin/movies/' + props.movie.id)
    }
  
  </script>
  
  <style>
  
  </style>