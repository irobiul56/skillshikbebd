<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";

const { props } = usePage();
const category = ref(props.category);
const tagOptions = ref(props.getdata);
const tool = ref(props.tools);

const fileInput = ref(null);
const previewUrl = ref(null);
const imageSize = ref(null);
const selectedFile = ref(null);

// Initialize form
const form = useForm({
  title: "",
  description: "",
  price: "",
  discount: "",
  liveclass: "",
  project: "",
  batch: "",
  category: "",
  start: "",
  schedule: "সময়: রাত ৯ - ১০ (শনি, সোম, বুধ)",
  totalclass: "",
  status: "Upcoming",
  thumbnail: null,
  video: "",
  group: "",
  gets: [], // ✅ Tags array for el-select
  tools: [], // ✅ tools array for el-select
});

// Trigger file input
const triggerFileInput = () => {
  fileInput.value.click();
};

// Handle file selection
const handleFileUpload = (event) => {
  const file = event.target.files[0];
  form.thumbnail = file;
  if (file) {
    previewUrl.value = URL.createObjectURL(file);
    imageSize.value = (file.size / 1024).toFixed(2) + " KB";
    selectedFile.value = file;
  } else {
    previewUrl.value = null;
    imageSize.value = null;
    selectedFile.value = null;
  }
};

// Submit form
const submitForm = () => {
  const formData = new FormData();
  Object.keys(form).forEach((key) => {
    const value = form[key];
    if (Array.isArray(value)) {
      value.forEach((v, i) => formData.append(`${key}[${i}]`, v));
    } else {
      formData.append(key, value);
    }
  });

  if (selectedFile.value) {
    formData.append("thumbnail", selectedFile.value);
  }

  form.post(route("courses.store"), {
    data: formData,
    forceFormData: true,
    onSuccess: () => {
      ElMessage.success("Course created successfully!");
      form.reset();
      previewUrl.value = null;
      selectedFile.value = null;
    },
    onError: () => {
      ElMessage.error("Failed to create course. Please check your inputs.");
    },
  });
};
</script>

<template>
  <Head title="Course Form" />
  <AuthenticatedLayout>
    <div class="container mt-5">
      <div class="max-auto text-center mb-3">
        <h1 class="text-3xl font-bold text-gray-800">Course Form</h1>
      </div>

      <form
        @submit.prevent="submitForm"
        class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg border border-gray-200 grid grid-cols-4 gap-6"
      >
        <label class="block col-span-4">
          <span class="text-gray-600 font-medium">Course Title</span>
          <input v-model="form.title" type="text" name="title" class="input-field" />
        </label>

        <label class="block col-span-3">
          <span class="text-gray-600 font-medium">Short Description</span>
          <textarea v-model="form.description" name="description" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Price</span>
          <input v-model="form.price" type="number" name="price" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Discount (%)</span>
          <input v-model="form.discount" type="number" name="discount" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Live Classes</span>
          <input v-model="form.liveclass" type="number" name="liveclass" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Project</span>
          <input v-model="form.project" type="number" name="project" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Batch Number</span>
          <input v-model="form.batch" type="number" name="batch" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Category</span>
          <select v-model="form.category" name="category" class="input-field">
            <option value="" disabled>Select category</option>
            <option v-for="(categories, index) in category" :key="index" :value="categories.id">
              {{ categories.name }}
            </option>
          </select>
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Class Start Date</span>
          <input v-model="form.start" type="date" name="start" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Class Schedule</span>
          <input v-model="form.schedule" type="text" name="schedule" class="input-field" />
        </label>

        <label class="block">
          <span class="text-gray-600 font-medium">Total Classes</span>
          <input v-model="form.totalclass" type="number" name="totalclass" class="input-field" />
        </label>

        

        <label class="block col-span-2">
          <span class="text-gray-600 font-medium">Embed Videos URL</span>
          <input v-model="form.video" type="text" name="video" class="input-field" />
        </label>

        <label class="block col-span-2">
          <span class="text-gray-600 font-medium">Facebook Group URL</span>
          <input v-model="form.group" type="text" name="group" class="input-field" />
        </label>

        <!-- Tag Selector -->
        <label class="block col-span-2">
          <span class="text-gray-600 font-medium">In this course you get:</span>
          <el-select
            v-model="form.gets"
            multiple
            filterable
            allow-create
            default-first-option
            :reserve-keyword="false"
            placeholder="Choose or create gets"
            style="width: 100%"
          >
            <el-option
              v-for="(item, index) in tagOptions"
              :key="index"
              :label="item.title"
              :value="item.id"
            />
          </el-select>
        </label>

         <!-- Tools Selector -->
         <label class="block col-span-2">
          <span class="text-gray-600 font-medium">Tools & Technology:</span>
          <el-select
            v-model="form.tools"
            multiple
            filterable
            allow-create
            default-first-option
            :reserve-keyword="false"
            placeholder="Choose or create tools"
            style="width: 100%"
          >
            <el-option
              v-for="(item, index) in tool"
              :key="index"
              :label="item.title"
              :value="item.id"
            />
          </el-select>
        </label>

        <!-- Thumbnail Upload -->
        <div
          class="col-span-2 border-dashed border-2 border-gray-300 rounded-lg p-6 text-center flex flex-col items-center"
        >
          <input type="file" ref="fileInput" accept="image/*" class="hidden" @change="handleFileUpload" />

          <template v-if="!previewUrl">
            <span class="text-gray-600 font-medium">Thumbnail (1280x720 pixels)</span>
            <p class="text-gray-500 text-sm">Click to upload or drag and drop</p>
            <button type="button" class="btn-upload" @click="triggerFileInput">Upload</button>
          </template>

          <div v-if="previewUrl">
            <img
              :src="previewUrl"
              alt="Selected Image"
              class="w-full object-cover rounded-lg cursor-pointer"
              @click="triggerFileInput"
            />
            <p class="text-gray-600 text-sm mt-2">Size: {{ imageSize }}</p>
          </div>
        </div>

        <label class="block col-span-2">
          <span class="text-gray-600 font-medium">Status</span>
          <select v-model="form.status" name="status" class="input-field">
            <option>Upcoming</option>
            <option>Ongoing</option>
            <option>Finished</option>
            <option>Draft</option>
          </select>
        </label>

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
  @apply mt-2 bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700;
}

.btn-submit {
  @apply w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-200;
}
</style>
