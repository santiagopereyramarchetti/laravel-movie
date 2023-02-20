<template>
    <AdminLayout title="Dashboard">
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Attach
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
                      
                        <div class="flex space-x-2">
                            <div v-for="trailer in trailers" :key="trailer.id">
                                <Link class="px-3 py-1 bg-red-500 hover:bg-red-800 text-white rounded-lg" as="button" type="button" method="delete" :href="route('admin.trailer-urls.destroy', trailer.id)">{{ trailer.name }}</Link>
                            </div>
                        </div>

                        <form @submit.prevent="submitTrailer">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <InputLabel for="embed_html" value="Embed HTML" />
                                <textarea
                                    id="embed_html"
                                    v-model="form.embed_html"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="embed_html"
                                >
                                </textarea>
                                <InputError class="mt-2" :message="form.errors.embed_html" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Add Trailer
                                </PrimaryButton>
                            </div>
                        </form>

                    </div>
                  </div>

                  <div class="w-full mb-8 p-6 rounded-lg shadow-lg bg-white sm:max-w-md">
                    
                    
                    <div class="w-full">
                        <form @submit.prevent="addCast" action="">
                            <VueMultiselect
                                v-model="castForm.casts"
                                :options="props.casts"
                                :multiple="true" 
                                :close-on-select="false"
                                :clear-on-select="false"
                                :preserve-search="true" 
                                placeholder="Add cast" 
                                label="name"
                                track-by="name"
                                >
                            </VueMultiselect>
                            <div class="mt-4 flex justify-end">
                                <PrimaryButton>Add Casts</PrimaryButton>
                            </div>
                        </form>
                    </div>

                  </div>

                  <div class="w-full mb-8 p-6 rounded-lg shadow-lg bg-white sm:max-w-md">
                    <div class="w-full">
                      
                         <div class="w-full">
                            <form @submit.prevent="addTag" action="">
                                <VueMultiselect
                                    v-model="tagForm.tags"
                                    :options="props.tags"
                                    :multiple="true" 
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="true" 
                                    placeholder="Add tag" 
                                    label="tag_name"
                                    track-by="tag_name"
                                    >
                                </VueMultiselect>
                                <div class="mt-4 flex justify-end">
                                    <PrimaryButton>Add Tags</PrimaryButton>
                                </div>
                            </form>
                        </div>

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

    import VueMultiselect from 'vue-multiselect'
  
    const props = defineProps({
      'movie': Object,
      'trailers': Array,
      'casts': Array,
      'tags': Array,
      'movieCasts': Array,
      'movieTags': Array,
    })

    const form = useForm({
        name: '',
        embed_html: '',
    })

    const submitTrailer = () => {
        form.post('/admin/movies/' + props.movie.id + '/add-trailer', {
            onSuccess: () => {
                form.reset()
            },  
        })
    }

    const castForm = useForm({
        casts: props.movieCasts,
    })

    const addCast = () => {
        castForm.post('/admin/movies/' + props.movie.id + '/add-casts', {
            preserveState: false, 
        })
    }

    const tagForm = useForm({
        tags: props.movieTags,
    })

    const addTag = () => {
        tagForm.post('/admin/movies/' + props.movie.id + '/add-tags', {
            preserveState: false, 
        })
    }
  
  </script>
  
  <style src="vue-multiselect/dist/vue-multiselect.css">

  </style>