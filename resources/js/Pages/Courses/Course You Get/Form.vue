<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const iconPreviews = ref([null]);


const form = useForm({
  items: [
    {
      icon: null,
      title: '',
      description: ''
    }
  ]
});

const addItem = () => {
  form.items.push({
    icon: null,
    title: '',
    description: ''
  });
  iconPreviews.value.push(null);
};

const removeItem = (index) => {
  if (form.items.length > 1) {
    form.items.splice(index, 1);
    iconPreviews.value.splice(index, 1);
  }
};


const handleIconUpload = (event, index) => {
  const file = event.target.files[0];
  if (file) {
    form.items[index].icon = file;
    iconPreviews.value[index] = URL.createObjectURL(file);
  }
};


const removeIcon = (index) => {
  form.items[index].icon = null;
  iconPreviews.value[index] = null;
  const fileInput = document.getElementById(`icon-upload-${index}`);
  if (fileInput) fileInput.value = '';
};


const submit = () => {
  form.post(route('courseyouget.store'), {
    preserveScroll: true,
    onSuccess: () => {
    form.reset();
    form.items = [{
        icon: null,
        title: '',
        description: ''
    }];
    iconPreviews.value = [null];
    }

  });
};
</script>

<template>
  <Head title="Create Items" />

  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-6">
      <form @submit.prevent="submit" class="space-y-6">
        <!-- List of Items -->
        <div v-for="(item, index) in form.items" :key="index" class="p-4 border border-gray-200 rounded-lg shadow-sm">
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
                    <img v-if="iconPreviews[index]" :src="iconPreviews[index]" class="w-10 h-10 rounded-full object-cover" />
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
              <p v-if="form.errors[`items.${index}.icon`]" class="text-red-500 text-xs mt-2">
                {{ form.errors[`items.${index}.icon`] }}
              </p>
            </div>
            
            <!-- Title Field -->
            <div class="col-span-4">
              <input
                v-model="item.title"
                placeholder="Title"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': form.errors[`items.${index}.title`] }"
              />
              <p v-if="form.errors[`items.${index}.title`]" class="text-red-500 text-xs mt-1">
                {{ form.errors[`items.${index}.title`] }}
              </p>
            </div>
            
            <!-- Description Field -->
            <div class="col-span-5">
              <input
                v-model="item.description"
                placeholder="Description"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': form.errors[`items.${index}.description`] }"
              />
              <p v-if="form.errors[`items.${index}.description`]" class="text-red-500 text-xs mt-1">
                {{ form.errors[`items.${index}.description`] }}
              </p>
            </div>
            
            <!-- Remove Button -->
            <div class="col-span-2 flex justify-end space-x-2">
              <button
                type="button"
                @click="removeItem(index)"
                class="p-2 text-red-500 hover:text-red-700 transition-colors"
                title="Remove item"
                :disabled="form.items.length <= 1"
                :class="{'opacity-50 cursor-not-allowed': form.items.length <= 1}"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
              
              <button
                type="button"
                @click="addItem"
                v-if="index === form.items.length - 1"
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
            :disabled="form.processing"
          >
            <span v-if="!form.processing">Submit Form</span>
            <span v-else class="flex items-center">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Processing...
            </span>
          </button>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>