<script setup lang="ts">
import { ref, reactive, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import Swal from 'sweetalert2';

const loading = ref(false);
const searchResult = ref<any>(null);
const form = reactive({ dni: '' });

// Lógica de beneficios
const tipoBeneficio = computed(() => {
    if (!searchResult.value) return null;
    const b = searchResult.value.beneficio;
    if (['BECA COMPLETA', '1/2 BECA', '1/4 BECA'].includes(b)) return 'BECA';
    if (b.includes('CUPON') || b.includes('CUPÓN')) return 'CUPON';
    if (b === 'NINGUNO') return 'NINGUNO';
    return 'OTRO';
});

const handleSearch = async () => {
    if (form.dni.length < 8) return;
    loading.value = true;
    searchResult.value = null;

    try {
        const response = await axios.post(route('internalStudent.findStudentForDni'), form);

        if (response.data.status === 'success') {
            searchResult.value = response.data.data;

            // Usamos setTimeout para esperar a que Vue renderice el DOM y la transición inicie
            setTimeout(() => {
                const element = document.getElementById('secondary-card');
                if (element) {
                    // block: 'start' asegura que el elemento se alinee al inicio de la vista
                    element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 50); // 100ms es suficiente para que el v-if pinte el elemento

        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No encontrado',
                text: response.data.message,
                background: '#1a1a1a',
                color: '#ffffff',
                confirmButtonColor: '#3b82f6'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error de conexión',
            background: '#1a1a1a',
            color: '#ffffff'
        });
    } finally {
        loading.value = false;
    }
};
</script>

<template>

    <Head title="Consulta Resultados" />

    <section class="w-full min-h-[85vh] flex flex-col items-center justify-center p-4 py-12">

        <div id="main-card"
            class="w-full max-w-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden shadow-2xl relative">

            <div class="relative w-full h-48 sm:h-full overflow-hidden group">
                <img src="/assets/img/header2025.jpg" alt="Portada AULA 20"
                    class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />

                <div class="absolute inset-0 bg-linear-to-t from-gray-900 via-gray-900/60 to-transparent"></div>

                <div class="absolute bottom-0 left-0 w-full p-2 text-center z-10">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-aula20-600/90 backdrop-blur-sm text-xs font-bold text-white uppercase tracking-wider mb-2 shadow-lg">
                        Aula20
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight drop-shadow-md">
                        Consulta de Resultados
                    </h1>
                </div>
            </div>

            <div class="px-6 sm:px-8 pb-6 pt-6 relative justify-center flex z-20">
                <form @submit.prevent="handleSearch" class="relative max-w-sm mx-auto sm:mx-0 w-full">
                    <div class="relative flex items-center group">
                        <div
                            class="absolute -inset-1 bg-linear-to-r from-aula20-600 to-cyan-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500">
                        </div>

                        <input v-model="form.dni" type="text" inputmode="numeric" maxlength="8"
                            placeholder="Ingresa tu DNI aquí..."
                            class="relative w-full h-16 pl-6 pr-16 rounded-2xl bg-gray-900 border border-white/10 text-white placeholder-gray-400 text-sm sm:text-lg font-mono tracking-widest focus:bg-gray-800 focus:border-aula20-500 focus:ring-1 focus:ring-aula20-500/50 transition-all outline-none shadow-inner"
                            required />

                        <button type="submit" :disabled="loading || form.dni.length < 8"
                            class="absolute right-2 top-2 bottom-2 aspect-square bg-aula20-600 hover:bg-aula20-500 text-white rounded-xl shadow-lg transition-all hover:scale-105 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed z-10">
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


            <div v-if="searchResult" id="secondary-card" class="border-t border-white/5 bg-black/20">

                <div
                    class="p-6 md:p-10 flex flex-col md:flex-row gap-6 items-center justify-between bg-linear-to-r from-aula20-900/30 to-transparent">
                    <div class="flex items-center gap-4">
                        <div
                            class="h-16 w-16 rounded-2xl bg-linear-to-br from-aula20-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-aula20-500/20 shrink-0">
                            <span class="text-3xl">🎓</span>
                        </div>
                        <div class="text-center md:text-left">
                            <h2 class="text-2xl font-bold text-white capitalize">{{ searchResult.fullname.toLowerCase()
                                }}</h2>
                            <p class="text-gray-400 font-mono text-sm tracking-wider">DNI: {{ searchResult.dni }}</p>
                        </div>
                    </div>

                    <div class="relative group cursor-default">
                        <div
                            class="absolute -inset-2 bg-linear-to-r from-green-500 to-emerald-600 rounded-full blur opacity-20 group-hover:opacity-40 transition duration-500">
                        </div>
                        <div
                            class="relative bg-gray-900/80 border border-white/10 rounded-2xl px-6 py-3 text-center min-w-35">
                            <span
                                class="block text-xs font-bold text-emerald-400 uppercase tracking-widest">Puntaje</span>
                            <span class="block text-4xl font-black text-white tracking-tighter">{{ searchResult.nota
                                }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-white/5 bg-white/5 border-y border-white/5">
                    <div class="p-6 flex justify-between items-center hover:bg-white/5 transition">
                        <span class="text-gray-400 text-sm font-medium uppercase">Sede</span>
                        <span class="text-white font-bold">{{ searchResult.sede }}</span>
                    </div>
                    <div class="p-6 flex justify-between items-center hover:bg-white/5 transition">
                        <span class="text-gray-400 text-sm font-medium uppercase">Carrera</span>
                        <span class="text-white font-bold text-right">{{ searchResult.carrera }}</span>
                    </div>
                </div>

                <div class="p-6 md:p-10">
                    <div class="text-center mb-8 flex flex-col">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-[0.2em]">Resultado
                            Obtenido</span>
                        <div class="flex items-center justify-center">
                            <div class="mt-3 inline-block relative">
                                <div class="absolute inset-0 blur-xl opacity-40 rounded-full" :class="{
                                    'bg-yellow-400': tipoBeneficio === 'BECA',
                                    'bg-cyan-400': tipoBeneficio === 'CUPON',
                                    'bg-gray-600': tipoBeneficio === 'NINGUNO'
                                }">
                                </div>
                                <span
                                    class="relative z-10 text-3xl md:text-4xl font-black uppercase tracking-tight drop-shadow-lg"
                                    :class="{
                                        'text-yellow-400': tipoBeneficio === 'BECA',
                                        'text-cyan-400': tipoBeneficio === 'CUPON',
                                        'text-gray-400': tipoBeneficio === 'NINGUNO'
                                    }">
                                    {{ searchResult.beneficio }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-black/20 rounded-xl p-6 border border-white/5 text-gray-300 text-sm leading-relaxed text-center max-w-2xl mx-auto">

                        <div v-if="tipoBeneficio === 'BECA'" class="space-y-4">
                            <p class="text-lg text-white">¡Felicitaciones! 🎉</p>
                            <p>Acércate en las próximas <strong class="text-yellow-400">48 horas</strong> posteriores a
                                la publicacion de resultados a la sede donde rendiste tu examen.</p>
                            <p>Deberas portar los siguientes documentos:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-left bg-white/5 p-4 rounded-lg">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Mayores de edad</p>
                                    <p class="text-white">DNI Original y Copia</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Menores de edad</p>
                                    <p class="text-white">Copia DNI Apoderado y Estudiante</p>
                                </div>
                            </div>
                            <p>Al llegar, consulten con el Director de la sede, quien les informará sobre los beneficios
                                de la beca y los documentos a firmar.</p>
                            <p>Los beneficiarios de la modalidad virtual deben comunicarse por WhatsApp al 913 203 328
                                para recibir información sobre el proceso de matrícula.</p>
                            <a href="https://wa.me/51913203328" target="_blank"
                                class="block w-full bg-white/10 hover:bg-white/20 py-2 rounded-lg text-cyan-300 font-bold transition">
                                ¿Modalidad Virtual? Click aquí
                            </a>
                        </div>

                        <div v-else-if="tipoBeneficio === 'CUPON'" class="space-y-3">
                            <p class="text-lg text-white">¡Has ganado un descuento! 🎫</p>
                            <p>Nuestros asesores te llamarán pronto para activar tu beneficio.</p>
                            <p>Si tienes alguna consulta adicional, no dudes en escribirnos al WhatsApp: 959 924 327</p>
                            <a href="https://wa.me/51959924327" target="_blank"
                                class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 font-bold mt-2">
                                <span>Contáctanos por WhatsApp</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                            </a>
                        </div>

                        <div v-else class="py-2">
                            <p>No tienes ningun beneficio  </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-16 text-center text-white/20 text-xs">
            &copy; 2025 Aula 20. Sistema de Resultados de Becas , hecho por un Gato.
        </footer>

    </section>
</template>
