<template>
  <AppLayout>
    <!-- Hero Section -->
    <section class="hero-gradient py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in">
            SmartSecurity
          </h1>
          <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto animate-slide-up">
            Sistema colaborativo de monitoramento de segurança pública para Ceilândia e região
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up">
            <Link :href="route('occurrences.create')" class="btn-primary bg-white text-purple-600 hover:bg-gray-100 px-8 py-3 text-lg">
              Reportar Ocorrência
            </Link>
            <Link :href="route('statistics')" class="btn-secondary bg-white/20 text-white hover:bg-white/30 border border-white/30 px-8 py-3 text-lg">
              Ver Estatísticas
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Estatísticas em Tempo Real</h2>
          <p class="text-lg text-gray-600">Acompanhe os dados de segurança da sua região</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="card text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <DocumentTextIcon class="w-8 h-8 text-blue-600" />
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ stats.total_occurrences || 0 }}</h3>
            <p class="text-gray-600">Ocorrências Registradas</p>
          </div>
          
          <div class="card text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <CheckCircleIcon class="w-8 h-8 text-green-600" />
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ stats.resolved_occurrences || 0 }}</h3>
            <p class="text-gray-600">Casos Resolvidos</p>
          </div>
          
          <div class="card text-center">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <UsersIcon class="w-8 h-8 text-purple-600" />
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ stats.active_users || 0 }}</h3>
            <p class="text-gray-600">Usuários Ativos</p>
          </div>
        </div>
      </div>
    </section>

    <!-- How it Works Section -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Como Funciona</h2>
          <p class="text-lg text-gray-600">Processo simples e eficiente para reportar e acompanhar ocorrências</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl font-bold text-white">1</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Reporte</h3>
            <p class="text-gray-600">Registre ocorrências de forma rápida e segura com localização precisa</p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl font-bold text-white">2</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Monitore</h3>
            <p class="text-gray-600">Acompanhe o status das ocorrências e receba atualizações em tempo real</p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl font-bold text-white">3</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Colabore</h3>
            <p class="text-gray-600">Contribua com informações e ajude a tornar sua comunidade mais segura</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Occurrences Section -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
          <h2 class="text-3xl font-bold text-gray-900">Ocorrências Recentes</h2>
          <Link :href="route('occurrences.index')" class="btn-primary">
            Ver Todas
          </Link>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="occurrence in recentOccurrences" :key="occurrence.id" class="card">
            <div class="flex items-start justify-between mb-3">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                {{ occurrence.type }}
              </span>
              <span class="text-sm text-gray-500">{{ formatDate(occurrence.created_at) }}</span>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">{{ occurrence.title }}</h3>
            <p class="text-gray-600 text-sm mb-3">{{ occurrence.description }}</p>
            <div class="flex items-center text-sm text-gray-500">
              <MapPinIcon class="w-4 h-4 mr-1" />
              {{ occurrence.location }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
  DocumentTextIcon,
  CheckCircleIcon,
  UsersIcon,
  MapPinIcon
} from '@heroicons/vue/24/outline'

defineProps({
  stats: {
    type: Object,
    default: () => ({
      total_occurrences: 0,
      resolved_occurrences: 0,
      active_users: 0
    })
  },
  recentOccurrences: {
    type: Array,
    default: () => []
  }
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}
</script>
