<template>
<AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Tags
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

              <section class="container mx-auto p-6 content-center">
                
                <div class="w-full flex mb-4 p-2 font-mono">
                  <Link :href="route('admin.tags.index')" class="px-4 py-2 bg-green-600 hover:bg-green-800 rounded-lg text-white">Tag Index</Link>
                </div>

                <form @submit.prevent="storeTag" class="flex">
                  <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                      <div class="w-full space-y-2">
                        <div class="">
                          <label for="first-name" class="block text-sm font-medium text-gray-700">Tag
                              name</label>
                          <input v-model="form.tagName" type="text" autocomplete="given-name"
                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md w-full" />
                        </div>
                        <div>
                          <button type="submit" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded">
                            Create
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

              </section>



            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
  import AdminLayout from '../../Layouts/AdminLayout.vue'
  import { Link, useForm } from '@inertiajs/vue3';

  const form = useForm({
    tagName: '',
  })

  const storeTag = () => {

    form.post('/admin/tags')

  }

</script>

<style>

</style>