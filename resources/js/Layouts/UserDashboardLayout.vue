<script setup>
import { ref } from 'vue';
import UserNavBar from '@/Components/UserNavBar.vue';
import UserSidebar from '@/Components/UserSidebar.vue';

const isCollapsed = ref(false);
const toggleSidebar = () => {
    isCollapsed.value = !isCollapsed.value;
};
</script>

<template>
  <UserNavBar @toggle-sidebar="toggleSidebar" />
  <div class="flex">
    <UserSidebar :is-collapsed="isCollapsed" />
    <slot />
  </div>
</template>

<style scoped>
</style>
