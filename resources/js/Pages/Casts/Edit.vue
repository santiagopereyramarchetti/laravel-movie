<template>
    <AdminLayout title="Dashboard">
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cast
              </h2>
          </template>
  
          <div class="py-12">
              <div class="max-w-7xl mx-auto">
  
                
                <section class="container mx-auto p-6 font-mono">
                  <div class="w-full flex mb-4 p-2">
                    <Link :href="route('admin.casts.index')" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Cast Index</Link>
                  </div>
  
                  <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white sm:max-w-md">
                    <div class="w-full overflow-x-auto">
                      
                        <form @submit.prevent="submitCast">
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

                            <div class="mt-4">
                                <InputLabel for="poster_path" value="Poster" />
                                <TextInput
                                    id="poster_path"
                                    v-model="form.poster_path"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.poster_path" />
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
  
    const props = defineProps({
      'cast': Object,
    })

    const form = useForm({
        name: props.cast.name,
        poster_path: props.cast.poster_path
    })

    const submitCast = () => {
        form.put('/admin/casts/' + props.cast.id)
    }
  
  </script>
  
  <style>
  
  </style>