<script setup lang="ts">
import { ref, reactive, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import Swal from 'sweetalert2';
import MainLayout from '@/Layouts/MainLayout.vue'; // Asegúrate que la ruta sea correcta
import { useColorMode } from '@vueuse/core';

const mode = useColorMode({
    disableTransition: false,
    initialValue: 'light'
});
const isDark = computed(() => mode.value === 'dark');

const loading = ref(false);
const searchResult = ref<any>(null);
const form = reactive({ dni: '' });

const handleSearch = async () => {
    if (form.dni.length < 8) return;
    loading.value = true;
    searchResult.value = null;

    try {
        const response = await axios.post(route('internalStudent.findStudentForDni'), form);

        if (response.data.status === 'success') {
            searchResult.value = response.data.data;

            // setTimeout para esperar renderizado y scroll
            setTimeout(() => {
                const element = document.getElementById('secondary-card');
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 50);

        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No encontrado',
                text: response.data.message,
                background: isDark.value ? '#1f2937' : '#ffffff',
                color: isDark.value ? '#ffffff' : '#1e293b',
                confirmButtonColor: '#3b82f6'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error de conexión',
            background: isDark.value ? '#1f2937' : '#ffffff',
            color: isDark.value ? '#ffffff' : '#1e293b'
        });
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <MainLayout>
        <Head title="Consulta Resultados Simulacro" />

        <section class="w-full min-h-[85vh] flex flex-col items-center justify-center p-4 py-12">

            <div id="main-card"
                class="w-full max-w-3xl rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-black/50 relative ring-1 ring-gray-900/5 dark:ring-white/10 backdrop-blur-xl transition-all duration-500
                       bg-white/70 border border-white/60
                       dark:bg-gray-900/60 dark:border-white/10">

                <div class="relative w-full h-48 sm:h-56 overflow-hidden group">
                    <img src="/assets/img/encabezado_aula_v.png" alt="Portada AULA 20"
                        class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" />

                    <div class="absolute bottom-0 left-0 right-0 h-12 bg-linear-to-t from-black/5 to-transparent"></div>
                </div>

                <div class="px-6 sm:px-8 pb-8 pt-4 relative justify-center flex flex-col z-20 transition-colors duration-500">

                    <div class="text-center mb-4">
                        <span class="inline-block py-1 px-3 rounded-full bg-aula20-50 text-aula20-600 dark:bg-aula20-900/50 dark:text-aula20-300 text-xs font-bold uppercase tracking-wider mb-3 border border-aula20-100 dark:border-aula20-700/50 transition-colors duration-500">
                            Aula 20
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-800 dark:text-white leading-tight tracking-tight transition-colors duration-500">
                            Resultados Simulacro
                        </h1>
                    </div>

                    <form @submit.prevent="handleSearch" class="relative max-w-sm mx-auto w-full">
                        <div class="relative flex items-center group">
                            <div
                                class="absolute -inset-1 bg-linear-to-r from-aula20-400 to-cyan-300 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500">
                            </div>

                            <input v-model="form.dni" type="text" inputmode="numeric" maxlength="8"
                                placeholder="Ingresa tu DNI aquí..."
                                class="relative w-full h-16 pl-6 pr-16 rounded-2xl text-sm sm:text-lg font-mono tracking-widest outline-none shadow-sm transition-all duration-300
                                       bg-white border border-gray-200 text-gray-800 placeholder-gray-400
                                       focus:bg-white focus:border-aula20-500 focus:ring-4 focus:ring-aula20-500/10
                                       dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-500
                                       dark:focus:bg-gray-800 dark:focus:border-aula20-400 dark:focus:ring-aula20-400/20"
                                required />

                            <button type="submit" :disabled="loading || form.dni.length < 8"
                                class="absolute right-2 top-2 bottom-2 aspect-square bg-aula20-600 hover:bg-aula20-700 text-white rounded-xl shadow-md transition-all hover:scale-105 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed z-10">
                                <svg v-if="loading" class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div v-if="searchResult" id="secondary-card"
                     class="border-t transition-colors duration-500
                            border-gray-100 bg-gray-50/30
                            dark:border-white/5 dark:bg-black/20">

                    <div class="p-6 md:p-10 flex flex-col md:flex-row gap-6 items-center justify-between bg-linear-to-r from-aula20-50 dark:from-aula20-900/30 to-transparent transition-colors duration-500">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-16 w-16 rounded-2xl bg-linear-to-br from-aula20-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-aula20-500/20 shrink-0 text-white">
                                <span class="text-3xl">🎓</span>
                            </div>
                            <div class="text-center md:text-left">
                                <h2 class="text-2xl font-bold capitalize transition-colors duration-500
                                           text-gray-800 dark:text-white">
                                    {{ searchResult.fullname.toLowerCase() }}
                                </h2>
                                <p class="font-mono text-sm tracking-wider transition-colors duration-500
                                          text-gray-500 dark:text-gray-400">
                                    DNI: {{ searchResult.dni }}
                                </p>
                            </div>
                        </div>

                        <div class="relative group cursor-default">
                            <div
                                class="absolute -inset-2 bg-linear-to-r from-green-400 to-emerald-300 rounded-full blur opacity-25 group-hover:opacity-40 transition duration-500">
                            </div>
                            <div class="relative rounded-2xl px-6 py-3 text-center min-w-35 shadow-sm transition-colors duration-500
                                       bg-white border border-gray-100
                                       dark:bg-gray-800 dark:border-white/10">
                                <span
                                    class="block text-xs font-bold uppercase tracking-widest
                                           text-emerald-600 dark:text-emerald-400">
                                    Puntaje
                                </span>
                                <span class="block text-4xl font-black tracking-tighter transition-colors duration-500
                                             text-gray-800 dark:text-white">
                                    {{ searchResult.nota }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x transition-colors duration-500
                                divide-gray-100 bg-white border-y border-gray-100
                                dark:divide-white/5 dark:bg-white/5 dark:border-white/5">
                        <div class="p-6 flex justify-between items-center transition hover:bg-gray-50 dark:hover:bg-white/5">
                            <span class="text-sm font-medium uppercase transition-colors duration-500
                                         text-gray-400">Sede</span>
                            <span class="font-bold transition-colors duration-500
                                         text-gray-700 dark:text-gray-200">
                                {{ searchResult.sede }}
                            </span>
                        </div>
                        <div class="p-6 flex justify-between items-center transition hover:bg-gray-50 dark:hover:bg-white/5">
                            <span class="text-sm font-medium uppercase transition-colors duration-500
                                         text-gray-400">Carrera</span>
                            <span class="font-bold text-right transition-colors duration-500
                                         text-gray-700 dark:text-gray-200">
                                {{ searchResult.carrera }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="mt-16 text-center text-xs font-medium transition-colors duration-500
                           text-gray-400 dark:text-white/20">
                &copy; 2025 Aula 20. Sistema de Resultados de Simulacro de Examen de Ingreso , hecho por un Gato.
            </footer>

        </section>
    </MainLayout>
</template>
