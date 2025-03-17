<!-- UserSidebar.vue -->
<script setup>
import { defineProps } from 'vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
  isCollapsed: Boolean
});
</script>

<template>
  <div class="min-h-screen" :class="['bg-white shadow-lg p-4 transition-all duration-300', isCollapsed ? 'w-16' : 'w-64']">
    <ul class="space-y-2">
      <li>
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
          <span class="mr-2">📊</span> <span v-if="!isCollapsed">Dashboard</span>
        </NavLink>
      </li>

      <li>
        <NavLink :href="route('course.list')" :active="route().current('course.list')">
          <span class="mr-2">📚</span> <span v-if="!isCollapsed">Course</span>
        </NavLink>
      </li>
      <li>
        <NavLink :href="route('curriculum.list')"
        :active="route().current('curriculum.list')">
          <span class="mr-2">✍️</span> <span v-if="!isCollapsed">Curriculum</span>
        </NavLink>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">📋</span> <span v-if="!isCollapsed"> Course Material </span>
        
        </a>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">📘</span> <span v-if="!isCollapsed"> Book </span>
          <span v-if="!isCollapsed" class="ml-2 bg-red-500 text-white px-2 text-xs rounded-full">নতুন</span>
        </a>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">🔄</span> <span v-if="!isCollapsed">Admin User</span>
        </a>
      </li>
      <li>
        <NavLink :href="route('category.index')"
        :active="route().current('category.index')">
          <span class="mr-2">📂</span> <span v-if="!isCollapsed">Category</span>
        </NavLink>
      </li>
      <li>
        <a href="#" class="menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg">
          <span class="mr-2">👨🏻‍🎓</span> <span v-if="!isCollapsed">Student</span>
        </a>
      </li>
    </ul>
  </div>
</template>