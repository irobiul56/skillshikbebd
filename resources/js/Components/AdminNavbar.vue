<!-- UserNavBar.vue -->
<script setup>
import { defineEmits } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const emit = defineEmits(['toggle-sidebar']);
</script>

<template>
  <nav class="bg-white shadow-md p-4 flex justify-between items-center">
    <div class="flex items-center space-x-2">
      <button @click="emit('toggle-sidebar')" class="p-2">☰</button>
      <img :src="'/storage/image/logo.png'" alt="Skill Shikbe Logo" class="h-10 w-20">
      <h1 class="text-xl font-semibold">skillshikbebd.com</h1>
    </div>
    <div class="flex items-center space-x-4">
      <button class="p-2">🔔</button>
      <button class="p-2">🌍 EN</button>
      <div class="hidden sm:ms-6 sm:flex sm:items-center">
        <div class="relative ms-3">
          <Dropdown align="right" width="48">
            <template #trigger>
              <span class="inline-flex rounded-md">
                <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                  {{ $page.props.auth.user.name }}
                  <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                  </svg>
                </button>
              </span>
            </template>
            <template #content>
              <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
              <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
            </template>
          </Dropdown>
        </div>
      </div>
    </div>
  </nav>
</template>
