<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

const page = usePage();
const isAuthenticated = computed(() => !!page.props.auth.user);
</script>

<template>
    <header class="bg-white shadow p-2 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <img :src="'/storage/image/logo.png'" alt="Skill Shikbe Logo" class="h-10 w-20">
            <div class="relative flex items-center px-2 rounded-full py-1">
                <img src="https://cdn.ostad.app/public/upload/2024-03-10T04-41-51.748Z-ostad-search.svg" alt="Search Icon" class="h-5 w-5 absolute left-3">
                <input type="text" placeholder="কোর্স সার্চ করুন" class="pl-10 pr-4 text-gray-700 rounded-full focus:outline-none max-w-48">
            </div>
            <nav class="hidden md:flex space-x-4">
                <Link :href="route('home')" class="text-gray-700 py-1">Home</Link>
                <a href="#" class="text-gray-700 py-1">Course</a>
                <Link :href="route('ebooks')" class="text-gray-700 py-1">E-Book</Link>
            </nav>
        </div>
        <div class="flex space-x-4 items-center">
            <button class="border px-4 py-2 text-gray-700">EN</button>
            <template v-if="isAuthenticated">
                <Link :href="route('dashboard')" class="bg-blue-500 text-white px-4 py-2 rounded">ড্যাশবোর্ড</Link>
            </template>
            <template v-else>
                <Link :href="route('login')" class="bg-green-300 px-4 py-2 rounded">লগিন/সাইনআপ</Link>
            </template>
        </div>
    </header>
</template>
