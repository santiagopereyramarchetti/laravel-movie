<template>
  <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Movies
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

              
              <section class="container mx-auto p-6 font-mono">
                <div class="w-full flex mb-4 p-2 justify-end">
                  <form class="flex space-x-4 shadow bg-white rounded-md m-2 p-2">
                    <div class="p-1 flex items-center">
                        <label for="tmdb_id_m" class="block text-sm font-medium text-gray-700 mr-4">Movie Tmdb Id</label>
                        <div class="relative rounded-md shadow-sm">
                            <input v-model="movieTMDBId" id="tmdb_id_m" name="tmdb_id_m"
                                class="px-3 py-2 border border-gray-300 rounded" placeholder="Movie ID" />
                        </div>
                    </div>
                    <div class="p-1">
                      <button
                        type="button"
                        @click="generateMovie"
                        class="
                          inline-flex
                          items-center
                          justify-center
                          py-2
                          px-4
                          border border-transparent
                          text-base
                          leading-6
                          font-medium
                          rounded-md
                          text-white
                          bg-green-600
                          hover:bg-green-500
                          focus:outline-none
                          focus:border-indigo-700
                          focus:shadow-outline-indigo
                          active:bg-green-700
                          transition
                          duration-150
                          ease-in-out
                          disabled:opacity-50
                        "
                      >
                        <svg
                          v-if="showSpinner"
                          class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                        >
                          <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                          ></circle>
                          <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                          ></path>
                        </svg>
                        <span>Generate</span>
                      </button>
                      
                    </div>
                  </form>
                </div>

                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                  <div class="w-full shadow p-5 bg-white">
                    <div class="flex justify-between">
                      <div class="flex-1">
                          <div class="relative">
                              <div class="absolute flex items-center ml-2 h-full">
                                  <svg class="w-4 h-4 fill-current text-primary-gray-dark" viewBox="0 0 16 16" fill="none"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path
                                          d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                                      </path>
                                  </svg>
                              </div>

                              <input v-model="movieFilters.search" type="text" placeholder="Search by title"
                                  class="px-8 py-3 w-full md:w-2/6 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm" />
                          </div>
                      </div>
                      <div class="flex">
                          <select v-model="movieFilters.perPage"
                            @change="movieFilters.perPage = $event.target.value"
                              class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                              <option value="5">5 Per Page</option>
                              <option value="10">10 Per Page</option>
                              <option value="15">15 Per Page</option>
                          </select>
                      </div>
                    </div>
                  </div>

                  <div class="w-full overflow-x-auto">

                    <Table>
                      <template #tableHead>
                        <TableHead class="cursor-pointer" @click="sort('title')">
                          <div class="flex space-x-4 content-center">
                            <span>Title</span>
                            <svg v-if="movieFilters.column == 'title' && movieFilters.direction == 'asc'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                            </svg>
                            <svg v-if="movieFilters.column == 'title' && movieFilters.direction == 'desc'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                            </svg>
                          </div>
                        </TableHead>
                        <TableHead @click="sort('rating')">
                          <div class="flex space-x-4 content-center">
                            <span>Rating</span>
                            <svg v-if="movieFilters.column == 'rating' && movieFilters.direction == 'asc'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                            </svg>
                            <svg v-if="movieFilters.column == 'rating' && movieFilters.direction == 'desc'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                            </svg>
                          </div>
                        </TableHead>
                        <TableHead @click="sort('visits')">
                          <div class="flex space-x-4 content-center">
                            <span>Visits</span>
                            <svg v-if="movieFilters.column == 'visits' && movieFilters.direction == 'asc'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                            </svg>
                            <svg v-if="movieFilters.column == 'visits' && movieFilters.direction == 'desc'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                            </svg>
                          </div>
                        </TableHead>
                        <TableHead>Poster</TableHead>
                        <TableHead>Public</TableHead>
                        <TableHead>Actions</TableHead>
                      </template>
                      <TableRow v-for="movie in movies.data" :key="movie.id">
                        <TableData>{{ movie.title }}</TableData>
                        <TableData>{{ movie.rating }}</TableData>
                        <TableData>{{ movie.visits }}</TableData>
                        <TableData>
                          <img class="h-12 w-12 rounded" :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`"  >
                        </TableData>
                        <TableData>
                          <span v-if="movie.is_public" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Published
                            </span>
                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                UnPublished
                            </span>
                        </TableData>
                        <TableData>
                          <div class="flex justify-around space-x-2">
                            <ButtonLink class="bg-blue-400 hover:bg-blue-800" :link="route('admin.movies.attach', movie.id)">Attach</ButtonLink>
                            <ButtonLink :link="route('admin.movies.edit', movie.id)">Edit</ButtonLink>
                            <ButtonLink class="bg-red-500 hover:bg-red-700" :method="'delete'" :link="route('admin.movies.destroy', movie.id)">Delete</ButtonLink>
                          </div>
                        </TableData>
                      </TableRow>
                    </Table>

                    <div class="p-4 bg-white">
                      <Pagination :links="movies.links"></Pagination>
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
  import Pagination from '../../Components/Pagination.vue';
  import { Link, router } from '@inertiajs/vue3';
  import { ref, reactive, watch } from 'vue';
  import Table from '../../Components/Table.vue';
  import TableHead from '../../Components/TableHead.vue';
  import TableData from '../../Components/TableData.vue';
  import TableRow from '../../Components/TableRow.vue';
  import ButtonLink from '../../Components/ButtonLink.vue';
  import { throttle, pickBy } from 'lodash'

  const props = defineProps({
    'movies': Object,
    'filters': Object
  })

  const movieFilters = reactive({
    search: props.filters.search,
    perPage: props.filters.perPage,
    column: props.filters.column,
    direction: props.filters.direction
  })

  watch(movieFilters, throttle( () => {
      //Convierte en un objeto el objeto tipo Proxy obtenido del watch
      let query = pickBy(movieFilters)
      let queryRoute = route('admin.movies.index', Object.keys(query).length ? query : {
        remember: 'forget'
      })
      console.log(queryRoute)
      /*Verifica que query tenga al menos un objeto dentro de el, que corresponde con los filters a aplciar y con eso contruye
        la ruta a consultar posteriormente
      */

      router.get(queryRoute, {}, {
        preserveState: true,
        repalce: true,
      })
      //Ejecuta la consulta a la ruta creada mediante get

    }, 1000),{
      deep: true
    }
    //El metodo throttle permite ejecutar la función como máximo 1 vez cada X ms, en este caso cada 1000


  )

  const showSpinner = ref(false)
  const movieTMDBId = ref('')

  const generateMovie = () => {
    router.post('/admin/movies', {
      movieTMDBId: movieTMDBId.value
    },{
      onStart: () => {
        showSpinner.value =true
      },
      onFinish: () => {
        movieTMDBId.value = ''
        showSpinner.value = false
      },
    })
  }

  const sort = (column) => {
    movieFilters.column = column
    movieFilters.direction = movieFilters.direction == 'asc' ? 'desc' : 'asc'
  }

</script>

<style>

</style>