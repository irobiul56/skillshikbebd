<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from 'vue';
import { usePage, useForm, Head } from '@inertiajs/vue3';
import { ElMessage } from "element-plus";

const { props } = usePage()
const course = ref(props.course)

const form = ref({
    courseId: '',
    title: '',
    description: '',
    date: '',
    time: '',
    duration: 60,
    platform: 'zoom',
    meetingLink: '',
    recordSession: true
});

const submitForm = () => {
    useForm(form.value).post(route('live-class.store'), {
        preserveScroll: true,
        onSuccess: () => {
            ElMessage.success('Live class created successfully!');
            form.value = {
                courseId: '',
                title: '',
                description: '',
                date: '',
                time: '',
                duration: 60,
                platform: 'zoom',
                meetingLink: '',
                recordSession: true
            };
        },
        onError: (errors) => {
            if (errors.meetingLink) {
                ElMessage.error('Please provide a valid meeting link');
            } else {
                ElMessage.error('There was an error creating the live class. Please check the form and try again.');
            }
        },
    });
};

</script>

<template>
    <Head title="Live Class" />
    <AuthenticatedLayout>
        <div class="container m-10 ml-10 mx-auto p-6 bg-white">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Live Class</h2>
            <form @submit.prevent="submitForm">
                <!-- Course Selection -->
                <div class="mb-6">
                    <label for="course" class="block text-sm font-medium text-gray-700 mb-2">Select Course</label>
                    <select id="course"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        v-model="form.courseId" required >
                        <option value="" disabled selected>Select a course</option>
                        <option v-for="(courses, index) in course" :key="index" :value="courses.id">{{ courses.title }}</option>
                    </select>
                </div>

                <!-- Class Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Class Title</label>
                    <input type="text" id="title"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g. Introduction to React" v-model="form.title" required>
                </div>

                <!-- Class Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="What will this class cover?" v-model="form.description"></textarea>
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" id="date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.date" required>
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                        <input type="time" id="time"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.time" required>
                    </div>
                </div>

                <!-- Duration -->
                <div class="mb-6">
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Duration
                        (minutes)</label>
                    <input type="number" id="duration" min="15" max="240"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g. 90" v-model="form.duration" required>
                </div>

                <!-- Meeting Platform -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Meeting Platform</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input id="zoom" name="platform" type="radio"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500" value="zoom" v-model="form.platform"
                                checked>
                            <label for="zoom" class="ml-3 block text-sm font-medium text-gray-700">Zoom</label>
                        </div>
                        <div class="flex items-center">
                            <input id="google_meet" name="platform" type="radio"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500" value="google_meet"
                                v-model="form.platform">
                            <label for="google_meet" class="ml-3 block text-sm font-medium text-gray-700">Google
                                Meet</label>
                        </div>
                        <div class="flex items-center">
                            <input id="custom" name="platform" type="radio"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500" value="custom"
                                v-model="form.platform">
                            <label for="custom" class="ml-3 block text-sm font-medium text-gray-700">Custom Link</label>
                        </div>
                    </div>
                </div>

                <!-- Meeting Link (conditional) -->
                <div class="mb-6">
                    <label for="meeting-link" class="block text-sm font-medium text-gray-700 mb-2">Meeting Link</label>
                    <input type="url" id="meeting-link"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://" v-model="form.meetingLink">
                </div>

                <!-- Recording Option -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input id="record" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded"
                            v-model="form.recordSession">
                        <label for="record" class="ml-3 block text-sm font-medium text-gray-700">Record this
                            session</label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Recording will be available to students after the session ends
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="button"
                        class="mr-4 px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" :loading="submitForm.processing"                        >
                        Schedule Live Class
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>