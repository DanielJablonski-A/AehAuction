<template>
    <form v-on:submit.prevent="handleSubmit" class="background-white px-8 pt-6 pb-8 mb-4 sm:w-1/2 md:w-1/2">
        <div v-if="error" class="bg-red-500 text-white font-bold py-2 px-4 my-3">
            {{ error }}
        </div>
      <div class="mb-4 font-bold">
        Zaloguj się
      </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input
                class="shadow appearance-none border w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                :class="{ 'border-red-500': error }"
                id="email"
                v-model="email"
                type="email"
                placeholder="email">
            <p class="mt-1 text-xs text-gray-500">Demo: <a href="#" tabindex="-1" @click.prevent="loadEmailField">admin@admin.pl</a></p>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input
                class="shadow appearance-none border  w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                :class="{ 'border-red-500': error }"
                id="password"
                v-model="password"
                type="password"
                placeholder="hasło"
                >
            <p class="mt-1 text-xs text-gray-500">Demo: <a href="#" tabindex="-1" @click.prevent="loadPasswordField">admin</a></p>
        </div>
        <div class="flex items-center justify-between">
            <button
                class="def_button w-full shadow-lg text-white py-2 px-4 focus:outline-none focus:shadow-outline text-sm"
                type="submit"
                :disabled="isLoading"
                :class="{ 'def_button_hover': isLoading, 'hover:def_button_hover': isLoading }"
            >
                ZALOGUJ SIĘ
            </button>
        </div>
    </form>
</template>

<script setup>

import { ref } from 'vue';

const email = ref('');
const password = ref('');
const error = ref('');
const isLoading = ref(false);
const emit = defineEmits(['user-authenticated']);

const loadEmailField = () => {
    email.value = 'admin@admin.pl';
};
const loadPasswordField = () => {
    password.value = 'admin';
};

const handleSubmit = async () => {
    isLoading.value = true;
    error.value = '';

    const response = await fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email.value,
            password: password.value
        })
    });

    isLoading.value = false;

    if (!response.ok) {
        const data = await response.json();
        error.value = data.error;

        return;
    }

    email.value = '';
    password.value = '';
    const userIri = response.headers.get('Location');
    emit('user-authenticated', userIri);
}

</script>
