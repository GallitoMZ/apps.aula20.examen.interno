<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    show: boolean;
    student: any;
}>();

const emit = defineEmits(['close']);

// Lógica de mensajes convertida a Computed Property de Vue
const condiciones = computed(() => {
    if (!props.student) return '';
    const beneficio = props.student.beneficio;

    if (['BECA COMPLETA', '1/2 BECA', '1/4 BECA'].includes(beneficio)) {
        return `
            <p class="mb-2">Los estudiantes que hayan obtenido una <strong>${beneficio}</strong> deberán presentarse dentro de las 48 horas posteriores...</p>
            <ul class="list-disc pl-5 mb-2">
                <li>Mayor de edad: DNI original y copia.</li>
                <li>Menor de edad: Copia DNI apoderado y estudiante.</li>
            </ul>
            <p class="mb-2">Preguntar por el Director de sede.</p>
            <p class="font-bold text-teal-700">WhatsApp: 913 203 328</p>
        `;
    }

    if (beneficio.includes('CUPON')) {
        return `
            <p>Los estudiantes con <strong>CUPÓN DE DESCUENTO</strong> serán contactados por nuestros asesores.</p>
            <p class="mt-2 font-bold text-teal-700">WhatsApp: 959 924 327</p>
        `;
    }

    if (beneficio === 'NINGUNO') {
        return `<p>Examen exclusivo para alumnos externos.</p>`;
    }

    return '<p>-</p>';
});
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-60 backdrop-blur-sm transition-opacity" @click.self="$emit('close')">

        <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white rounded-xl shadow-2xl dark:bg-gray-800 animate-scale-in">

            <div class="flex justify-between items-center p-5 border-b dark:border-gray-700 bg-teal-600 rounded-t-xl text-white">
                <h3 class="text-xl font-bold">Detalle de Resultados</h3>
                <button @click="$emit('close')" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-6" v-if="student">

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1 bg-gray-50 p-3 rounded border">
                        <span class="text-xs text-gray-500 uppercase">Postulante</span>
                        <div class="font-bold text-gray-800">{{ student.fullname }}</div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 bg-gray-50 p-3 rounded border">
                        <span class="text-xs text-gray-500 uppercase">Puntaje Total</span>
                        <div class="font-bold text-teal-600 text-xl">{{ student.nota }}</div>
                    </div>
                </div>

                <div class="text-center py-4 bg-teal-50 rounded-lg border border-teal-100">
                    <h4 class="text-sm font-bold text-teal-800 uppercase tracking-widest">Beneficio Obtenido</h4>
                    <div class="text-3xl font-extrabold text-teal-600 mt-1">{{ student.beneficio }}</div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-700">
                    <h5 class="font-bold mb-2 uppercase text-xs text-gray-500">Términos y Condiciones</h5>
                    <div v-html="condiciones" class="prose prose-sm max-w-none"></div>
                </div>

            </div>

            <div class="flex justify-end p-5 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-xl">
                <button @click="$emit('close')" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

