<script setup>
import UserDashboardLayout from '@/Layouts/UserDashboardLayout.vue';
import { ref, computed } from 'vue'
import { usePage, useForm, Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    course: Object,
});

// Check if there's a live class today
const todaysLiveClass = computed(() => {
    const today = new Date();
    return props.course.liveclass.find(live => {
        const liveDate = new Date(live.start_time);
        return (
            liveDate.getDate() === today.getDate() &&
            liveDate.getMonth() === today.getMonth() &&
            liveDate.getFullYear() === today.getFullYear()
        );
    });
});

// Format date/time for display
const formatDateTime = (dateTimeString) => {
    const options = { 
        weekday: 'long', 
        day: 'numeric', 
        month: 'long', 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: true
    };
    return new Date(dateTimeString).toLocaleDateString('bn-BD', options);
};
</script>

<template>
    <UserDashboardLayout>
        <Head title="My Course"/>
        <div class="m-5 flex gap-4">
            <!-- Main Content (Left Side) -->
            <div class="flex-1">
                <div class="p-4 bg-white border border-gray-200 rounded-lg w-full">
                    <div class="p-2">
                        <p class="text-lg font-medium text-gray-800">Live Class Details of: {{ course.title }}</p>
                    </div>
                    <div class="border-t border-gray-200 mt-2"></div>
                    <div class="bg-white w-full overflow-hidden border border-gray-200 rounded-lg mt-4">
                        <table class="w-full">
                            <thead class="bg-gray-600">
                                <tr>
                                    <th class="py-4 px-6 text-left text-white font-normal w-[25%]">শিরোনাম</th>
                                    <th class="py-4 px-6 text-left text-white font-normal w-[25%]">সময়কাল</th>
                                    <th class="py-4 px-6 text-left text-white font-normal w-[25%]">সময়</th>
                                    <th class="py-4 px-6 text-left text-white font-normal w-[25%]">দেখুন</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr 
                                    class="bg-white hover:bg-gray-50" 
                                    v-for="(liveclass, index) in course.liveclass" 
                                    :key="index"
                                    :class="{ 'bg-blue-50': todaysLiveClass && liveclass.id === todaysLiveClass.id }"
                                >
                                    <td class="py-4 px-6">
                                        <div class="flex gap-4 items-center">
                                            <img src="https://cdn.ostad.app/public/icons/play-circle-line.svg"
                                                class="w-5 h-5" alt="Play icon">
                                            <span>{{ liveclass.title }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">{{ liveclass.duration_minutes }} মিনিট</td>
                                    <td class="py-4 px-6">{{ formatDateTime(liveclass.start_time) }}</td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex justify-end">
                                            <a v-if="liveclass.recording_path" :href="`/dashboard/my-courses/${course.id}/recordings?play=${liveclass.id}`">
                                                <button
                                                    class="group flex gap-2 items-center h-10 px-6 py-2 rounded-md bg-black bg-opacity-5 hover:bg-opacity-10 active:bg-opacity-20 transition-all duration-200 active:scale-95">
                                                    <img class="w-5 h-5"
                                                        src="https://cdn.ostad.app/public/icons/play-line.svg" alt="Play">
                                                    <span class="uppercase text-sm font-medium text-gray-900">দেখুন</span>
                                                </button>
                                            </a>
                                            <p v-if="!liveclass.recording_path">ক্লাস শেষ হলে ভিডিওটি দেখতে পারবেন</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sticky Live Class Cart (Right Side) - Only shows if there's a live class today -->
            <div v-if="todaysLiveClass" class="sticky top-5 h-fit w-80 flex-shrink-0">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-medium text-gray-900">আজকের লাইভ ক্লাস</h3>
                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">LIVE</span>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">কোর্সের নাম</p>
                            <p class="font-medium">{{ course.title }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">ক্লাসের শিরোনাম</p>
                            <p class="font-medium">{{ todaysLiveClass.title }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">ক্লাস টাইম</p>
                            <p class="font-medium">{{ formatDateTime(todaysLiveClass.start_time) }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">সময়কাল</p>
                            <p class="font-medium">{{ todaysLiveClass.duration_minutes }} মিনিট</p>
                        </div>
                    </div>
                    <a :href="todaysLiveClass.meeting_link" target="_blank" rel="noopener noreferrer">
                    <button class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        লাইভ ক্লাসে যোগ দিন
                    </button>
                    </a>

                    <div class="mt-3 text-xs text-gray-500">
                        <p>ক্লাস শুরু হওয়ার ১৫ মিনিট আগে জয়েন করা যাবে</p>
                    </div>
                </div>
            </div>
        </div>
    </UserDashboardLayout>
</template>

<style></style>