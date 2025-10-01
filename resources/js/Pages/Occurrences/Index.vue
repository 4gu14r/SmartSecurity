<template>
  <AppLayout>
    <Head title="Ocorrências" />
    
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-2xl font-bold text-gray-900">Ocorrências</h2>
                <p class="text-gray-600">Visualize e gerencie as ocorrências reportadas</p>
              </div>
              <Link :href="route('occurrences.create')" class="btn-primary">
                <PlusIcon class="w-5 h-5 mr-2" />
                Nova Ocorrência
              </Link>
            </div>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
          <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros</h3>
            <form @submit.prevent="applyFilters" class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input
                  v-model="form.search"
                  type="text"
                  placeholder="Título ou descrição..."
                  class="input-field"
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                <select v-model="form.type" class="input-field">
                  <option value="">Todos os tipos</option>
                  <option v-for="(label, value) in types" :key="value" :value="value">
                    {{ label }}
                  </option>
                </select>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select v-model="form.status" class="input-field">
                  <option value="">Todos os status</option>
                  <option v-for="(label, value) in statuses" :key="value" :value="value">
                    {{ label }}
                  </option>
                </select>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Localização</label>
                <input
                  v-model="form.location"
                  type="text"
                  placeholder="Digite a localização..."
                  class="input-field"
                />
              </div>
              
              <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="btn-primary">
                  <MagnifyingGlassIcon class="w-4 h-4 mr-2" />
                  Filtrar
                </button>
                <button type="button" @click="clearFilters" class="btn-secondary">
                  <XMarkIcon class="w-4 h-4 mr-2" />
                  Limpar
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Occurrences List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div v-if="occurrences.data.length === 0" class="text-center py-12">
              <DocumentTextIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
              <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma ocorrência encontrada</h3>
              <p class="text-gray-500 mb-4">Não há ocorrências que correspondam aos filtros aplicados.</p>
              <Link :href="route('occurrences.create')" class="btn-primary">
                Reportar primeira ocorrência
              </Link>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div
                v-for="occurrence in occurrences.data"
                :key="occurrence.id"
                class="card hover:shadow-md transition-shadow duration-200"
              >
                <div class="flex items-start justify-between mb-3">
                  <span
                    :class="getStatusClass(occurrence.status)"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  >
                    {{ statuses[occurrence.status] }}
                  </span>
                  <span class="text-sm text-gray-500">
                    {{ formatDate(occurrence.created_at) }}
                  </span>
                </div>

                <div class="flex items-start justify-between mb-2">
                  <span
                    :class="getTypeClass(occurrence.type)"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  >
                    {{ occurrence.type }}
                  </span>
                  <div class="flex items-center text-sm text-gray-500">
                    <EyeIcon class="w-4 h-4 mr-1" />
                    {{ occurrence.views_count }}
                  </div>
                </div>

                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                  {{ occurrence.title }}
                </h3>
                
                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                  {{ occurrence.description }}
                </p>
                
                <div class="flex items-center text-sm text-gray-500 mb-3">
                  <MapPinIcon class="w-4 h-4 mr-1" />
                  {{ occurrence.location }}
                </div>

                <div class="flex items-center justify-between">
                  <div class="flex items-center text-sm text-gray-500">
                    <UserIcon class="w-4 h-4 mr-1" />
                    {{ occurrence.user.first_name }} {{ occurrence.user.last_name }}
                  </div>
                  
                  <Link
                    :href="route('occurrences.show', occurrence.id)"
                    class="text-primary-600 hover:text-primary-700 text-sm font-medium"
                  >
                    Ver detalhes →
                  </Link>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div v-if="occurrences.data.length > 0" class="mt-6">
              <Pagination :links="occurrences.links" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import {
  PlusIcon,
  MagnifyingGlassIcon,
  XMarkIcon,
  DocumentTextIcon,
  EyeIcon,
  MapPinIcon,
  UserIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  occurrences: Object,
  filters: Object,
  types: Object,
  statuses: Object,
})

const form = reactive({
  search: props.filters.search || '',
  type: props.filters.type || '',
  status: props.filters.status || '',
  location: props.filters.location || '',
})

const applyFilters = () => {
  router.get(route('occurrences.index'), form, {
    preserveState: true,
    replace: true,
  })
}

const clearFilters = () => {
  form.search = ''
  form.type = ''
  form.status = ''
  form.location = ''
  applyFilters()
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getStatusClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    verified: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800',
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getTypeClass = (type) => {
  const classes = {
    'Assalto': 'bg-red-100 text-red-800',
    'Furto': 'bg-orange-100 text-orange-800',
    'Roubo': 'bg-red-100 text-red-800',
    'Vandalismo': 'bg-purple-100 text-purple-800',
    'Tráfico': 'bg-gray-100 text-gray-800',
    'Violência': 'bg-red-100 text-red-800',
    'Outros': 'bg-blue-100 text-blue-800',
  }
  return classes[type] || 'bg-gray-100 text-gray-800'
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
