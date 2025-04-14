<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";

const { props } = usePage()
const category = ref(props.category)

const fileInput = ref(null);
const previewUrl = ref(null);
const imageSize = ref(null);
const selectedFile = ref(null);

// Create a form using Inertia's useForm helper
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
});

// Function to trigger file input click
const triggerFileInput = () => {
    fileInput.value.click();
};

// Handle file selection
// Function to handle file selection
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

// Modify submitForm to ensure FormData is set correctly
const submitForm = () => {
    const formData = new FormData();

    // Append form fields
    Object.keys(form).forEach((key) => {
        formData.append(key, form[key]);
    });

    // Append thumbnail file if selected
    if (selectedFile.value) {
        formData.append("thumbnail", selectedFile.value);
    }

    // Submit the form
    form.post(route("courses.store"), {
        data: formData,
        forceFormData: true,
        onSuccess: () => {
            ElMessage.success("Course created successfully!");
            form.reset(); // Reset the form after submission
            previewUrl.value = null;
            selectedFile.value = null;
        },
        onError: (errors) => {
            console.log(errors);
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
            <form @submit.prevent="submitForm"
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
                        <option :value="categories.id" v-for="(categories, index) in category" :key="index">{{ categories.name }}</option>
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
                        <span class="text-gray-600 font-medium">Thumbnail (1280x720 pixels)</span>
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
                    <span class="text-gray-600 font-medium">Embed Videos URL</span>
                    <input v-model="form.video" type="text" name="video" class="input-field">
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
