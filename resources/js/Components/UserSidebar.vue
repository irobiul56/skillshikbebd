<!-- UserSidebar.vue -->
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  isCollapsed: Boolean
});
</script>

<template>
  <div class="min-h-screen" :class="['bg-white shadow-lg p-4 transition-all duration-300', isCollapsed ? 'w-16' : 'w-64']">
    <ul class="space-y-2">
      <li>
        <a href="#" class="menu-item flex items-center p-2 bg-yellow-300 rounded-lg">
          <span class="mr-2">📚</span> <span v-if="!isCollapsed">আমার কোর্স</span>
        </a>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">📦</span> <span v-if="!isCollapsed">বান্ডেল কোর্স</span>
          <span v-if="!isCollapsed" class="ml-2 bg-red-500 text-white px-2 text-xs rounded-full">নতুন</span>
        </a>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">📘</span> <span v-if="!isCollapsed"> আমার বুক </span>
          <span v-if="!isCollapsed" class="ml-2 bg-red-500 text-white px-2 text-xs rounded-full">নতুন</span>
        </a>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">🔄</span> <span v-if="!isCollapsed">রেটিং</span>
        </a>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">📂</span> <span v-if="!isCollapsed">রিসোর্স</span>
        </a>
      </li>
    </ul>
  </div>
</template>