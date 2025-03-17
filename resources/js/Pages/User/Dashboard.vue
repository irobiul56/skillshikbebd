<script setup>
import UserDashboardLayout from '@/Layouts/UserDashboardLayout.vue';
</script>
<template>
    <UserDashboardLayout>
        <h1 class="m-10">{{ $page.props.auth.user.name }}</h1>
    </UserDashboardLayout>
</template>