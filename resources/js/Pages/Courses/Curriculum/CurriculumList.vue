<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, computed } from 'vue'
import { usePage, useForm } from '@inertiajs/vue3';
import { ElMessage } from "element-plus";

const { props } = usePage()
const course = ref(props.course)

const itemsPerPage = ref(10)
const currentPage = ref(1)
const searchQuery = ref('')

const filteredcourse = computed(() => {
  const filtered = course.value.filter(course => 
  course.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
  )
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filtered.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(
    course.value.filter(course => 
    course.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
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


const deletecourse = (courseId) => {
    if (confirm("Are you sure you want to delete this data?")) {
        courseForm.delete(route('courses.destroy', courseId), {
            onSuccess: (page) => {
                course.value = page.props.course; // Update the course list after deletion
                ElMessage.success("course deleted successfully!");
            },
            onError: () => {
                ElMessage.error("Failed to delete the course. Please try again.");
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
                    <Link class="ml-3" :href="route('curriculum.index')">
                        <el-button type="primary">Create Curriculum</el-button>
                    </Link>

            </div>

            <table class="table-auto min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 px-4 border-b-2">#</th>
                        <th class="py-2 px-4 border-b-2">Course Title</th>
                        <th class="py-2 px-4 border-b-2">Batch</th>
                        <th class="py-2 px-4 border-b-2">Week</th>
                        <th class="py-2 px-4 border-b-2">Topic</th>
                        <th class="py-2 px-4 border-b-2">Status</th>
                        <th class="py-2 px-4 border-b-2">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(course, index) in filteredcourse" :key="index" class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ index + 1 }}</td>
                        <td class="py-2 px-4 border-b">{{ course.title }}</td>
                        <td class="py-2 px-4 border-b">{{ course.batch_number }}</td>
                        <td class="py-2 px-4 border-b">
                            <tr v-for="(curriculum, index) in course.curriculums" :key="index">
                                <td class="border-b">{{ curriculum.week }}</td>
                            </tr>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <tr v-for="(curriculum, index) in course.curriculums" :key="index">
                                <td class="border-b">{{ curriculum.topic }}</td>
                            </tr>
                        </td>
                        <td class="py-2 px-4 border-b">{{ course.status }}</td>
                        
                        <td class="py-2 px-4 flex justify-center items-center space-x-2">
                            <!-- Edit button to open modal for editing -->
                            <Link :href="route('curriculum.edit', course.id)">
                                <el-button>
                                    Edit
                                </el-button>
                            </Link>

                            <Link @click="deletecourse(course.id)">
                                <el-button>
                                    Delete
                                </el-button>
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
