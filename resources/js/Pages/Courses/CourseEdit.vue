<script setup>
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";

// Props to receive course data (this will come from the parent component or Inertia)
const props = defineProps({
  course: Object, //Expecting the 'course' object as a prop
  category: Object, // Expecting the 'category' object as a prop
});

const fileInput = ref(null);
const previewUrl = ref(null);
const imageSize = ref(null);
const selectedFile = ref(null);

// Initialize the form with the existing course data
const form = useForm({
  title: props.course.title,
  description: props.course.description,
  price: props.course.price,
  discount: props.course.discount,
  liveclass: props.course.live_classes,
  project: props.course.projects,
  batch: props.course.batch_number,
  category: props.course.category,
  start: props.course.start_date,
  schedule: props.course.class_schedule,
  totalclass: props.course.total_classes,
  status: props.course.status,
  thumbnail: null, // Keep this null initially; will be handled separately
  video: props.course.videos,
});

// Set the preview image if a thumbnail is already set
onMounted(() => {
  if (props.course.thumbnail) {
    previewUrl.value = props.course.thumbnail; // Now this will be a full URL
  }
});



// Function to trigger file input click
const triggerFileInput = () => {
  fileInput.value.click();
};

// Handle file selection
const handleFileUpload = (event) => {
  const file = event.target.files[0];
  form.thumbnail = file;
  if (file) {
    // Create a preview URL and set other properties
    previewUrl.value = URL.createObjectURL(file);
    imageSize.value = (file.size / 1024).toFixed(2) + " KB"; // Convert to KB
    selectedFile.value = file;
  } else {
    // Reset if no file is selected
    previewUrl.value = null;
    imageSize.value = null;
    selectedFile.value = null;
  }
};

const updateCourse = () => {
    form.transform((data) => ({
        ...data,
        _method: "PUT", // Forces Laravel to recognize it as a PUT request
    })).post(route("courses.update", props.course.id), {
        forceFormData: true, // Ensures FormData is used correctly
        onSuccess: () => {
            ElMessage.success("Course updated successfully!");
        },
        onError: () => {
            ElMessage.error("Failed to update course. Please try again.");
        }
    });
};
</script>

<template>
  <Head title="Edit Course" />
  <AuthenticatedLayout>
    <div class="container mt-5">
      <div class="max-auto text-center mb-3">
        <h1 class="text-3xl font-bold text-gray-800">Edit Course</h1>
      </div>
      <form @submit.prevent="updateCourse"
        class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg border border-gray-200 grid grid-cols-4 gap-6">
        <label class="block col-span-4">
          <span class="text-gray-600 font-medium">Course Title</span>
          <input v-model="form.title" type="text" name="title" class="input-field">
        </label>
        <label class="block col-span-3">
          <span class="text-gray-600 font-medium">Short Description</span>
          <textarea v-model="form.description" name="description" class="input-field"></textarea>
        </label>
        <label class="block">
          <span class="text-gray-600 font-medium">Price</span>
          <input v-model="form.price" type="number" name="price" class="input-field">
        </label>
        <label class="block">
          <span class="text-gray-600 font-medium">Discount (%)</span>
          <input v-model="form.discount" type="number" name="price" class="input-field">
        </label>
        <label class="block">
          <span class="text-gray-600 font-medium">Live Classes</span>
          <input v-model="form.liveclass" type="number" name="liveclass" class="input-field">
        </label>
        <label class="block">
          <span class="text-gray-600 font-medium">Project</span>
          <input v-model="form.project" type="number" name="project" class="input-field">
        </label>
        <label class="block">
          <span class="text-gray-600 font-medium">Batch Number</span>
          <input v-model="form.batch" type="number" name="batch" class="input-field">
        </label>
        <label class="block">
          <span class="text-gray-600 font-medium">Category</span>
          <select v-model="form.category" name="category" class="input-field">
            <option value="" disabled>Select category</option>
            <option v-for="(categories, index) in props.category" :key="index">{{ categories.name }}</option>
            
          </select>
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Class Start Date</span>
          <input v-model="form.start" type="date" name="start" class="input-field">
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Class Schedule</span>
          <input v-model="form.schedule" type="text" name="schedule" class="input-field">
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Total Classes</span>
          <input v-model="form.totalclass" type="number" name="totalclass" class="input-field">
        </label>

        <div class="col-span-2 border-dashed border-2 border-gray-300 rounded-lg p-6 text-center flex flex-col items-center">
          <input type="file" ref="fileInput" accept="image/*" class="hidden" @change="handleFileUpload" />

          <template v-if="!previewUrl">
            <span class="text-gray-600 font-medium">Thumbnail</span>
            <p class="text-gray-500 text-sm">Click to upload or drag and drop</p>
            <button type="button" class="btn-upload" @click="triggerFileInput">Upload</button>
          </template>

          <div v-if="previewUrl">
            <img :src="previewUrl" alt="Selected Image"
              class="w-full object-cover rounded-lg cursor-pointer" @click="triggerFileInput" />
            <p class="text-gray-600 text-sm mt-2">Size: {{ imageSize }}</p>
          </div>
        </div>

        <label class="block">
          <span class="text-gray-600 font-medium">Status</span>
          <select v-model="form.status" name="status" class="input-field">
            <option>Upcoming</option>
            <option>Ongoing</option>
            <option>Finished</option>
            <option>Draft</option>
          </select>
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Videos URL</span>
          <input v-model="form.video" type="text" name="video" class="input-field">
        </label>

        <button type="submit" class="btn-submit">Update</button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.input-field {
  @apply mt-1 block w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none;
}

.btn-upload {
  @apply mt-2 bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700;
}

.btn-submit {
  @apply w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-200;
}
</style>
