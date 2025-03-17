<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'menu-item flex items-center p-2 bg-yellow-300 rounded-lg'
        : 'menu-item flex items-center p-2 hover:bg-gray-200 rounded-lg',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
