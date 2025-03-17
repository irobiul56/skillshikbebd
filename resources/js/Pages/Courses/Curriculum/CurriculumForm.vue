<script setup>
import { ref } from "vue";
import { usePage, useForm, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ElMessage } from 'element-plus';

const { props } = usePage();
const courses = ref(props.courses);

const selectedCourse = ref(""); // Store selected course ID
const curriculums = ref([{ week: "", carriculum: "", details: "" }]);

const addCurriculum = () => {
    curriculums.value.push({ week: "", carriculum: "", details: "" });
};

const removeCurriculum = (index) => {
    curriculums.value.splice(index, 1);
};

const submitForm = () => {
    if (!selectedCourse.value) {
        ElMessage.error("Please select a course.");
        return;
    }

    // Send data to Laravel backend
    useForm({
        course_id: selectedCourse.value,
        curriculums: curriculums.value,
    }).post(route("curriculum.store"), {
        onSuccess: () => {
            ElMessage.success("Curriculum added successfully!");
            selectedCourse.value = "";
            curriculums.value = [{ week: "", carriculum: "", details: "" }];
        },
        onError: (errors) => {
            console.log(errors);
            ElMessage.error("Failed to add curriculum. Please check your inputs.");
        },
    });
};
</script>

<template>
    <Head title="Curriculum Form"/>
    <AuthenticatedLayout>
        <div class="container mt-5">
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-5">Add Curriculum</h1>
            <form @submit.prevent="submitForm" class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg border border-gray-200">
                
                <!-- Course Selection Dropdown -->
                <label class="block mb-4">
                    <span class="text-gray-600 font-medium">Select Course</span>
                    <select v-model="selectedCourse" class="input-field">
                        <option value="" disabled>Select a course</option>
                        <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.title }} ({{ course.batch_number }})</option>
                    </select>
                </label>

                <!-- Dynamic Curriculum Fields -->
                <div v-for="(curriculum, index) in curriculums" :key="index" class="border-b border-gray-300 pb-4 mb-4">
                    <div class="flex justify-between">
                        <h2 class="text-xl font-semibold">Curriculum {{ index + 1 }}</h2>
                        <button type="button" @click="removeCurriculum(index)" class="text-red-500">Remove</button>
                    </div>
                    <label class="block mt-2">
                        <span class="text-gray-600 font-medium">Week</span>
                        <input v-model="curriculum.week" type="text" class="input-field" required />
                    </label>
                    <label class="block mt-2">
                        <span class="text-gray-600 font-medium">Topic</span>
                        <input v-model="curriculum.carriculum" type="text" class="input-field" required />
                    </label>
                    <label class="block mt-2">
                        <span class="text-gray-600 font-medium">Details</span>
                        <textarea v-model="curriculum.details" class="input-field"></textarea>
                    </label>
                </div>

                <!-- Add More Curriculum -->
                <button type="button" @click="addCurriculum" class="btn-upload">Add More Curriculum</button>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.input-field {
    @apply mt-1 block w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none;
}

.btn-upload {
    @apply mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700;
}

.btn-submit {
    @apply w-full mt-4 bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-200;
}
</style>
