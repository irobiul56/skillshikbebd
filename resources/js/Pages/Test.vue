<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const items = ref([{
  icon: '',
  title: '',
  description: ''
}]);

const isSubmitting = ref(false);
const submitMessage = ref(null);

const addItem = () => {
  items.value.push({
    icon: '',
    title: '',
    description: ''
  });
};

const removeItem = (index) => {
  if (items.value.length > 1) {
    items.value.splice(index, 1);
  }
};

const handleIconUpload = (event, index) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      items.value[index].icon = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const removeIcon = (index) => {
  items.value[index].icon = '';
};

const submitForm = async () => {
  try {
    isSubmitting.value = true;
    submitMessage.value = null;
    
    // Validate form
    if (!items.value.every(item => item.title && item.description)) {
      throw new Error('Please fill all required fields');
    }
    
    // Prepare form data
    const formData = new FormData();
    items.value.forEach((item, index) => {
      formData.append(`items[${index}][title]`, item.title);
      formData.append(`items[${index}][description]`, item.description);
      if (item.icon) {
        const blob = dataURLtoBlob(item.icon);
        formData.append(`items[${index}][icon]`, blob, `icon_${index}.png`);
      }
    });
    
    // Here you would make your actual API call
    console.log('Form data prepared:', Object.fromEntries(formData));
    
    submitMessage.value = {
      type: 'success',
      text: 'Form submitted successfully!'
    };
    
  } catch (error) {
    submitMessage.value = {
      type: 'error',
      text: error.message || 'Failed to submit form'
    };
  } finally {
    isSubmitting.value = false;
  }
};

const dataURLtoBlob = (dataURL) => {
  const arr = dataURL.split(',');
  const mime = arr[0].match(/:(.*?);/)[1];
  const bstr = atob(arr[1]);
  let n = bstr.length;
  const u8arr = new Uint8Array(n);
  while (n--) {
    u8arr[n] = bstr.charCodeAt(n);
  }
  return new Blob([u8arr], { type: mime });
};
</script>

<template>
  <Head title="Live Class" />
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-6">
      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- List of Items -->
        <div v-for="(item, index) in items" :key="index" class="p-4 border border-gray-200 rounded-lg shadow-sm">
          <div class="grid grid-cols-12 gap-4 items-center">
            <!-- Icon Upload Field -->
            <div class="col-span-1">
              <div class="relative">
                <input
                  type="file"
                  @change="handleIconUpload($event, index)"
                  accept="image/*"
                  class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                  :id="`icon-upload-${index}`"
                />
                <label 
                  v-if="!item.icon" 
                  :for="`icon-upload-${index}`" 
                  class="flex items-center justify-center w-10 h-10 border-2 border-dashed border-gray-300 rounded-full cursor-pointer hover:border-blue-500 transition-colors"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                </label>
                <div v-if="item.icon" class="relative group">
                  <img :src="item.icon" class="w-10 h-10 rounded-full object-cover" />
                  <button
                    type="button"
                    @click="removeIcon(index)"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Title Field -->
            <div class="col-span-4">
              <input
                v-model="item.title"
                placeholder="Title"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            
            <!-- Description Field -->
            <div class="col-span-5">
              <input
                v-model="item.description"
                placeholder="Description"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            
            <!-- Remove Button -->
            <div class="col-span-2 flex justify-end space-x-2">
              <button
                type="button"
                @click="removeItem(index)"
                class="p-2 text-red-500 hover:text-red-700 transition-colors"
                title="Remove item"
                :disabled="items.length <= 1"
                :class="{'opacity-50 cursor-not-allowed': items.length <= 1}"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
              
              <button
                type="button"
                @click="addItem"
                v-if="index === items.length - 1"
                class="p-2 text-green-500 hover:text-green-700 transition-colors"
                title="Add item"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between items-center pt-4">
          
          <button
            type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center"
            :disabled="isSubmitting"
          >
            <span v-if="!isSubmitting">Submit Form</span>
            <span v-else class="flex items-center">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Processing...
            </span>
          </button>
        </div>

        <!-- Submission Message -->
        <div 
          v-if="submitMessage" 
          class="p-3 rounded-md"
          :class="{
            'bg-green-100 text-green-800': submitMessage.type === 'success',
            'bg-red-100 text-red-800': submitMessage.type === 'error'
          }"
        >
          {{ submitMessage.text }}
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>