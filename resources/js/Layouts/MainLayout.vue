<script setup lang="ts">
import { useColorMode } from '@vueuse/core';
import { computed } from 'vue';

const mode = useColorMode({
    disableTransition: false,
    initialValue: 'light',
});

const isDark = computed(() => mode.value === 'dark');

const toggleTheme = () => {
    mode.value = isDark.value ? 'light' : 'dark';
};
</script>

<template>
    <div class="relative min-h-screen w-full transition-colors duration-500">

      <div class="fixed inset-0 -z-50 h-full w-full bg-white transition-opacity duration-700"
             :class="isDark ? 'opacity-0' : 'opacity-100'">
            <div class="absolute h-full w-full bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-size-[24px_24px]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_800px_at_50%_200px,#ffffff00,transparent)]"></div>
            <div class="absolute top-[-10%] left-[-10%] h-125 w-125 rounded-full bg-aula20-500/30 blur-[80px] opacity-40 mix-blend-multiply"></div>
            <div class="absolute bottom-[-10%] right-[-10%] h-125 w-125 rounded-full bg-cyan-400/20 blur-[80px] opacity-40 mix-blend-multiply"></div>
        </div>

        <div class="fixed inset-0 -z-50 h-full w-full bg-aula20-950 transition-opacity duration-700"
             :class="isDark ? 'opacity-100' : 'opacity-0'">
             <div class="absolute inset-0 bg-gray-950"></div>
            <div class="absolute h-full w-full bg-[linear-gradient(to_right,#ffffff0a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0a_1px,transparent_1px)] bg-size-[24px_24px]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_800px_at_50%_200px,#00000000,transparent)]"></div>
            <div class="absolute top-[-10%] left-[-10%] h-125 w-125 rounded-full bg-aula20-600/30 blur-[100px] opacity-50"></div>
            <div class="absolute bottom-0 right-0 h-125 w-125 rounded-full bg-cyan-600/20 blur-[100px] opacity-40"></div>
        </div>

        <button
            @click="toggleTheme"
            class="fixed top-4 right-4 z-50 p-2 rounded-full transition-all duration-300 shadow-lg border backdrop-blur-md group"
            :class="isDark
                ? 'bg-gray-800/50 border-gray-700 text-yellow-400 hover:bg-gray-800'
                : 'bg-white/50 border-gray-200 text-gray-600 hover:bg-white hover:text-aula20-600'">

            <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <slot />
    </div>
</template>
