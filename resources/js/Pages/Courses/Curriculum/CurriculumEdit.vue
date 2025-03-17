<script setup>
import { ref } from 'vue';
import { usePage, useForm, Head } from '@inertiajs/vue3';
import { ElMessage } from 'element-plus';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { props } = usePage();
const course = ref(props.course);
const curriculums = ref(props.curriculums);

// Use Inertia form to handle the update
const form = useForm({
  course_id: course.value.id,
  curriculums: curriculums.value,
});

// Handle curriculum update
const updateCurriculum = () => {
  form.curriculums = [...curriculums.value]; // Ensure reactivity
  form.put(route('courses.curriculum.update', { course: course.value.id }), {
    onSuccess: (response) => {
      ElMessage.success('Curriculum updated successfully!');
      curriculums.value = response.props.curriculums; // Update curriculums with the response data
    },
    onError: (errors) => {
      ElMessage.error('Failed to update curriculum.');
    },
  });
};

// Add new curriculum entry
const addCurriculum = () => {
  curriculums.value.push({ week: '', topic: '', details: '' });
};

// Remove curriculum entry
const removeCurriculum = (index) => {
  if (curriculums.value.length > 1) {
    curriculums.value.splice(index, 1);
  } else {
    ElMessage.error('At least one curriculum entry is required.');
  }
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Edit Curriculum"/>

    <div class="container mx-auto mt-5">
      <h1 class="text-3xl font-bold text-gray-800 text-center mb-5">Edit Curriculum for <span class="bg-green-200"> {{ course.title }} </span></h1>

      <form @submit.prevent="updateCurriculum" class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg border border-gray-200">
        <div v-for="(curriculum, index) in curriculums" :key="index" class="mb-4">
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
            <input v-model="curriculum.topic" type="text" class="input-field" required />
          </label>

          <label class="block mt-2">
            <span class="text-gray-600 font-medium">Details</span>
            <textarea v-model="curriculum.details" class="input-field"></textarea>
          </label>
        </div>

        <button type="button" @click="addCurriculum" class="btn-upload">Add More Curriculum</button>
        <button type="submit" class="btn-submit">Update Curriculum</button>
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
  @apply w-full mt-4 bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition duration-200;
}
</style>
