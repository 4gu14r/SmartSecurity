<template>
  <AppLayout>
    <Head title="Nova Ocorrência" />
    
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center">
              <Link :href="route('occurrences.index')" class="text-gray-500 hover:text-gray-700 mr-4">
                <ArrowLeftIcon class="w-5 h-5" />
              </Link>
              <div>
                <h2 class="text-2xl font-bold text-gray-900">Nova Ocorrência</h2>
                <p class="text-gray-600">Reporte uma nova ocorrência de segurança</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Form -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <form @submit.prevent="submit" class="p-6 space-y-6">
            <!-- Type and Title -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                  Tipo de Ocorrência *
                </label>
                <select
                  id="type"
                  v-model="form.type"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.type }"
                  required
                >
                  <option value="">Selecione o tipo</option>
                  <option v-for="(label, value) in types" :key="value" :value="value">
                    {{ label }}
                  </option>
                </select>
                <div v-if="form.errors.type" class="mt-1 text-sm text-red-600">
                  {{ form.errors.type }}
                </div>
              </div>

              <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                  Título *
                </label>
                <input
                  id="title"
                  v-model="form.title"
                  type="text"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.title }"
                  placeholder="Título da ocorrência"
                  required
                />
                <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                  {{ form.errors.title }}
                </div>
              </div>
            </div>

            <!-- Description -->
            <div>
              <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Descrição *
              </label>
              <textarea
                id="description"
                v-model="form.description"
                rows="4"
                class="input-field"
                :class="{ 'border-red-500': form.errors.description }"
                placeholder="Descreva detalhadamente o que aconteceu..."
                required
              ></textarea>
              <div v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                {{ form.errors.description }}
              </div>
            </div>

            <!-- Location and Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                  Localização *
                </label>
                <input
                  id="location"
                  v-model="form.location"
                  type="text"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.location }"
                  placeholder="Ex: QNM 36, Ceilândia Norte"
                  required
                />
                <div v-if="form.errors.location" class="mt-1 text-sm text-red-600">
                  {{ form.errors.location }}
                </div>
              </div>

              <div>
                <label for="occurred_at" class="block text-sm font-medium text-gray-700 mb-2">
                  Data e Hora da Ocorrência *
                </label>
                <input
                  id="occurred_at"
                  v-model="form.occurred_at"
                  type="datetime-local"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.occurred_at }"
                  required
                />
                <div v-if="form.errors.occurred_at" class="mt-1 text-sm text-red-600">
                  {{ form.errors.occurred_at }}
                </div>
              </div>
            </div>

            <!-- Coordinates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                  Latitude (opcional)
                </label>
                <input
                  id="latitude"
                  v-model="form.latitude"
                  type="number"
                  step="any"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.latitude }"
                  placeholder="Ex: -15.7942"
                />
                <div v-if="form.errors.latitude" class="mt-1 text-sm text-red-600">
                  {{ form.errors.latitude }}
                </div>
              </div>

              <div>
                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                  Longitude (opcional)
                </label>
                <input
                  id="longitude"
                  v-model="form.longitude"
                  type="number"
                  step="any"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.longitude }"
                  placeholder="Ex: -47.8822"
                />
                <div v-if="form.errors.longitude" class="mt-1 text-sm text-red-600">
                  {{ form.errors.longitude }}
                </div>
              </div>
            </div>

            <!-- Location Helper -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <div class="flex">
                <InformationCircleIcon class="h-5 w-5 text-blue-400 mt-0.5" />
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-blue-800">
                    Dica de Localização
                  </h3>
                  <div class="mt-2 text-sm text-blue-700">
                    <p>
                      Para obter coordenadas precisas, você pode usar o Google Maps:
                      clique com o botão direito no local e selecione "O que há aqui?".
                      As coordenadas aparecerão na parte inferior da tela.
                    </p>
                    <button
                      type="button"
                      @click="getCurrentLocation"
                      class="mt-2 text-blue-600 hover:text-blue-800 font-medium"
                      :disabled="gettingLocation"
                    >
                      {{ gettingLocation ? 'Obtendo localização...' : 'Usar minha localização atual' }}
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Images -->
            <div>
              <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                Imagens (opcional)
              </label>
              <input
                id="images"
                type="file"
                multiple
                accept="image/*"
                @change="handleImageUpload"
                class="input-field"
                :class="{ 'border-red-500': form.errors.images }"
              />
              <p class="mt-1 text-sm text-gray-500">
                Você pode selecionar múltiplas imagens. Formatos aceitos: JPG, PNG, GIF (máx. 2MB cada)
              </p>
              <div v-if="form.errors.images" class="mt-1 text-sm text-red-600">
                {{ form.errors.images }}
              </div>
              
              <!-- Image Preview -->
              <div v-if="imagePreview.length > 0" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div v-for="(image, index) in imagePreview" :key="index" class="relative">
                  <img :src="image" alt="Preview" class="w-full h-24 object-cover rounded-lg" />
                  <button
                    type="button"
                    @click="removeImage(index)"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                  >
                    ×
                  </button>
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
              <Link :href="route('occurrences.index')" class="btn-secondary">
                Cancelar
              </Link>
              <button
                type="submit"
                :disabled="form.processing"
                class="btn-primary"
              >
                <span v-if="form.processing">Salvando...</span>
                <span v-else>Criar Ocorrência</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
  ArrowLeftIcon,
  InformationCircleIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  types: Object,
})

const form = useForm({
  type: '',
  title: '',
  description: '',
  location: '',
  occurred_at: '',
  latitude: '',
  longitude: '',
  images: null,
})

const imagePreview = ref([])
const gettingLocation = ref(false)

const submit = () => {
  form.post(route('occurrences.store'))
}

const handleImageUpload = (event) => {
  const files = Array.from(event.target.files)
  form.images = files
  
  // Create preview URLs
  imagePreview.value = []
  files.forEach(file => {
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value.push(e.target.result)
    }
    reader.readAsDataURL(file)
  })
}

const removeImage = (index) => {
  const files = Array.from(form.images || [])
  files.splice(index, 1)
  form.images = files.length > 0 ? files : null
  imagePreview.value.splice(index, 1)
}

const getCurrentLocation = () => {
  if (!navigator.geolocation) {
    alert('Geolocalização não é suportada pelo seu navegador')
    return
  }

  gettingLocation.value = true
  
  navigator.geolocation.getCurrentPosition(
    (position) => {
      form.latitude = position.coords.latitude.toFixed(6)
      form.longitude = position.coords.longitude.toFixed(6)
      gettingLocation.value = false
    },
    (error) => {
      console.error('Erro ao obter localização:', error)
      alert('Não foi possível obter sua localização. Verifique as permissões do navegador.')
      gettingLocation.value = false
    }
  )
}

// Set default date to now
const now = new Date()
now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
form.occurred_at = now.toISOString().slice(0, 16)
</script>
