<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, computed } from 'vue'
import { usePage, useForm } from '@inertiajs/vue3';
import { ElMessage } from "element-plus";

const { props } = usePage()
const liveclass = ref(props.liveclass)

const itemsPerPage = ref(10)
const currentPage = ref(1)
const searchQuery = ref('')

const filteredliveclass = computed(() => {
  const filtered = liveclass.value.filter(liveclass => 
  liveclass.course.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
  )
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filtered.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(
    liveclass.value.filter(liveclass => 
    liveclass.course.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
    ).length / itemsPerPage.value
  )
})

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
  }
}

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
  }
}


defineProps({ 
    errors: Object 
})


const deleteliveclass = (liveclassId) => {
    if (confirm("Are you sure you want to delete this data?")) {
        liveclassForm.delete(route('live-class.destroy', liveclassId), {
            onSuccess: (page) => {
                liveclass.value = page.props.liveclass; // Update the liveclass list after deletion
                ElMessage.success("liveclass deleted successfully!");
            },
            onError: () => {
                ElMessage.error("Failed to delete the liveclass. Please try again.");
            },
        });
    }
};


</script>

<template>
    <AuthenticatedLayout>
        <div v-if="$page.props.flash?.message" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 alert">
        {{ $page.props.flash?.message }}
      </div>
      
        <Head title="Course List"></Head>
        
        <div class="container mx-auto">
            <div class="relative mx-4 lg:mx-0 mb-2 mt-3">
                <input v-model="searchQuery"
                    class="w-32 pl-10 pr-4 text-indigo-600 border-gray-200 rounded-md sm:w-64 focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    type="text" placeholder="Search">
                    <Link class="ml-3" :href="route('live-class.create')">
                        <el-button type="primary">Create Schedule Class</el-button>
                    </Link>

            </div>

            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 px-4 border-b-2">#</th>
                        <th class="py-2 px-4 border-b-2">Course Title</th>
                        <th class="py-2 px-4 border-b-2">Class Topic</th>
                        <th class="py-2 px-4 border-b-2">Batch</th>
                        <th class="py-2 px-4 border-b-2">Start Date & Time</th>
                        <th class="py-2 px-4 border-b-2">Duration (min)</th>
                        <th class="py-2 px-4 border-b-2">Platform</th>
                        <th class="py-2 px-4 border-b-2">Recoded Video</th>
                        <th class="py-2 px-4 border-b-2">Status</th>
                        <th class="py-2 px-4 border-b-2">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(liveclass, index) in filteredliveclass" :key="index" class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ index + 1 }}</td>
                        <td class="py-2 px-4 border-b">{{ liveclass.course.title }}</td>
                        <td class="py-2 px-4 border-b">{{ liveclass.title }}</td>
                        <td class="py-2 px-4 border-b">{{ liveclass.course.batch_number }}</td>
                        <td class="py-2 px-4 border-b">{{ liveclass.start_time }}</td> 
                        <td class="py-2 px-4 border-b">{{ liveclass.duration_minutes }}</td> 
                        <td class="py-2 px-4 border-b">{{ liveclass.platform }}</td> 
                        <td class="py-2 px-4 border-b">{{ liveclass.recording_path }}</td> 
                        <td class="py-2 px-4 border-b">{{ liveclass.status }}</td> 
                        <td class="py-2 px-4 border-b flex">

                           <!-- Edit button to open modal for editing -->
                            <Link :href="route('live-class.edit', liveclass.id)">
                                <button>
                                    <svg class="w-6 h-6 text-blue-400 dark:text-white ml-5" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </button>
                            </Link>

                            <Link @click="deleteliveclass(liveclass.id)">
                            <svg class="w-6 h-6 text-red-400 dark:text-white ml-5" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            </Link>
                        </td>
                    </tr>
                </tbody>

            </table>
            <tfoot class="flex items-center mt-4">

                <button class="py-2 px-4 bg-gray-300 hover:bg-gray-400 rounded" :disabled="currentPage === 1"
                    @click="prevPage">
                    Previous
                </button>
                <span class="ml-2">Page {{ currentPage }} of {{ totalPages }}</span>
                <button class="py-2 px-4 bg-gray-300 hover:bg-gray-400 rounded ml-2"
                    :disabled="currentPage === totalPages" @click="nextPage">
                    Next
                </button>

            </tfoot>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
