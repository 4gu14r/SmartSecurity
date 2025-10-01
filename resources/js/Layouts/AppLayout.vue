<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
              <Link :href="route('home')" class="flex items-center">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                  <ShieldCheckIcon class="w-5 h-5 text-white" />
                </div>
                <span class="ml-2 text-xl font-bold text-gray-900">SmartSecurity</span>
              </Link>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <NavLink :href="route('home')" :active="route().current('home')">
                Início
              </NavLink>
              <NavLink :href="route('occurrences.index')" :active="route().current('occurrences.*')">
                Ocorrências
              </NavLink>
              <NavLink :href="route('statistics')" :active="route().current('statistics')">
                Estatísticas
              </NavLink>
              <NavLink :href="route('about')" :active="route().current('about')">
                Sobre
              </NavLink>
            </div>
          </div>

          <!-- Right side -->
          <div class="hidden sm:flex sm:items-center sm:ml-6">
            <div v-if="$page.props.auth.user" class="flex items-center space-x-4">
              <!-- User Dropdown -->
              <Dropdown align="right" width="48">
                <template #trigger>
                  <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                    <div class="flex items-center">
                      <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <UserIcon class="w-5 h-5 text-gray-600" />
                      </div>
                      <span class="ml-2">{{ $page.props.auth.user.name }}</span>
                      <ChevronDownIcon class="ml-1 w-4 h-4" />
                    </div>
                  </button>
                </template>

                <template #content>
                  <DropdownLink :href="route('dashboard')">
                    Dashboard
                  </DropdownLink>
                  <DropdownLink :href="route('profile.edit')">
                    Perfil
                  </DropdownLink>
                  <DropdownLink :href="route('logout')" method="post" as="button">
                    Sair
                  </DropdownLink>
                </template>
              </Dropdown>
            </div>

            <div v-else class="flex items-center space-x-4">
              <Link :href="route('login')" class="text-gray-500 hover:text-gray-700">
                Entrar
              </Link>
              <Link :href="route('register')" class="btn-primary">
                Cadastrar
              </Link>
            </div>
          </div>

          <!-- Mobile menu button -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
              <Bars3Icon v-show="!showingNavigationDropdown" class="h-6 w-6" />
              <XMarkIcon v-show="showingNavigationDropdown" class="h-6 w-6" />
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
            Início
          </ResponsiveNavLink>
          <ResponsiveNavLink :href="route('occurrences.index')" :active="route().current('occurrences.*')">
            Ocorrências
          </ResponsiveNavLink>
          <ResponsiveNavLink :href="route('statistics')" :active="route().current('statistics')">
            Estatísticas
          </ResponsiveNavLink>
          <ResponsiveNavLink :href="route('about')" :active="route().current('about')">
            Sobre
          </ResponsiveNavLink>
        </div>

        <!-- Mobile User Menu -->
        <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
          <div class="px-4">
            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
          </div>

          <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('dashboard')">
              Dashboard
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('profile.edit')">
              Perfil
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
              Sair
            </ResponsiveNavLink>
          </div>
        </div>

        <div v-else class="pt-4 pb-1 border-t border-gray-200">
          <div class="space-y-1">
            <ResponsiveNavLink :href="route('login')">
              Entrar
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('register')">
              Cadastrar
            </ResponsiveNavLink>
          </div>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div v-if="$page.props.flash.success" class="bg-green-50 border-l-4 border-green-400 p-4">
      <div class="flex">
        <CheckCircleIcon class="h-5 w-5 text-green-400" />
        <div class="ml-3">
          <p class="text-sm text-green-700">{{ $page.props.flash.success }}</p>
        </div>
      </div>
    </div>

    <div v-if="$page.props.flash.error" class="bg-red-50 border-l-4 border-red-400 p-4">
      <div class="flex">
        <ExclamationTriangleIcon class="h-5 w-5 text-red-400" />
        <div class="ml-3">
          <p class="text-sm text-red-700">{{ $page.props.flash.error }}</p>
        </div>
      </div>
    </div>

    <!-- Page Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
      <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div class="col-span-1 md:col-span-2">
            <div class="flex items-center">
              <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                <ShieldCheckIcon class="w-5 h-5 text-white" />
              </div>
              <span class="ml-2 text-xl font-bold text-gray-900">SmartSecurity</span>
            </div>
            <p class="mt-4 text-gray-600">
              Sistema colaborativo de monitoramento de segurança pública para Ceilândia e região.
            </p>
          </div>
          
          <div>
            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Links</h3>
            <ul class="mt-4 space-y-4">
              <li><Link :href="route('about')" class="text-gray-600 hover:text-gray-900">Sobre</Link></li>
              <li><Link :href="route('contact')" class="text-gray-600 hover:text-gray-900">Contato</Link></li>
              <li><Link :href="route('privacy')" class="text-gray-600 hover:text-gray-900">Privacidade</Link></li>
              <li><Link :href="route('terms')" class="text-gray-600 hover:text-gray-900">Termos</Link></li>
            </ul>
          </div>
          
          <div>
            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Suporte</h3>
            <ul class="mt-4 space-y-4">
              <li><a href="mailto:contato@smartsecurity.com" class="text-gray-600 hover:text-gray-900">contato@smartsecurity.com</a></li>
              <li><a href="tel:+5561999999999" class="text-gray-600 hover:text-gray-900">(61) 99999-9999</a></li>
            </ul>
          </div>
        </div>
        
        <div class="mt-8 border-t border-gray-200 pt-8">
          <p class="text-center text-gray-500">
            &copy; {{ new Date().getFullYear() }} SmartSecurity. Todos os direitos reservados.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import {
  ShieldCheckIcon,
  UserIcon,
  ChevronDownIcon,
  Bars3Icon,
  XMarkIcon,
  CheckCircleIcon,
  ExclamationTriangleIcon
} from '@heroicons/vue/24/outline'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

const showingNavigationDropdown = ref(false)
</script>
