<script setup>
import { Link } from '@inertiajs/vue3';

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
                
                <a href="#" class="text-gray-700 py-1">প্রোগ্রাম</a>
                <a href="#" class="text-gray-700 py-1">ফ্রী কোর্স</a>
                <a href="#" class="text-gray-700 py-1">ব্লগ</a>
            </nav>
        </div>
        <div class="flex space-x-4 items-center">
            <button class="border px-4 py-2 text-gray-700">EN</button>
            <Link :href="route('login')" class="bg-green-300 px-4 py-2 rounded">লগিন/সাইনআপ</Link>
        </div>
    </header>
</template>

<style scoped>
</style>