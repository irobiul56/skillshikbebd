<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, useForm, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { ElMessage } from "element-plus";

const { props } = usePage();
const curriculum = ref(props.curriculum);
const itemsPerPage = ref(10);
const currentPage = ref(1);
const searchQuery = ref("");

const groupedCurriculum = computed(() => {
  const grouped = {};
  curriculum.value.forEach((item) => {
    if (!grouped[item.course_id]) {
      grouped[item.course_id] = { ...item, topics: [] };
    }
    grouped[item.course_id].topics.push({ week: item.week, topic: item.topic });
  });
  return Object.values(grouped);
});

const filteredCurriculum = computed(() => {
  const query = searchQuery.value.toLowerCase();
  return groupedCurriculum.value
    .filter(({ course }) => course.title.toLowerCase().includes(query))
    .slice((currentPage.value - 1) * itemsPerPage.value, currentPage.value * itemsPerPage.value);
});

const totalPages = computed(() => Math.ceil(filteredCurriculum.value.length / itemsPerPage.value));
const nextPage = () => currentPage.value < totalPages.value && currentPage.value++;
const prevPage = () => currentPage.value > 1 && currentPage.value--;

const deleteCurriculum = (curriculumId) => {
  if (confirm("Are you sure you want to delete this data?")) {
    useForm().delete(route("curriculums.destroy", curriculumId), {
      onSuccess: ({ props }) => {
        curriculum.value = props.curriculum;
        ElMessage.success("Curriculum deleted successfully!");
      },
      onError: () => ElMessage.error("Failed to delete the curriculum. Please try again."),
    });
  }
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Curriculum List" />
    <div v-if="$page.props.flash?.message" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 alert">
      {{ $page.props.flash?.message }}
    </div>
    <div class="container mx-auto">
      <div class="relative mx-4 lg:mx-0 mb-2 mt-3 flex items-center">
        <input v-model="searchQuery" class="w-64 pl-3 pr-4 border rounded-md focus:ring focus:ring-indigo-500" type="text" placeholder="Search" />
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
            <th class="py-2 px-4 border-b-2">Topics</th>
            <th class="py-2 px-4 border-b-2">Status</th>
            <th class="py-2 px-4 border-b-2">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(curr, index) in filteredCurriculum" :key="curr.course_id" class="hover:bg-gray-100">
            <td class="py-2 px-4 border-b">{{ index + 1 }}</td>
            <td class="py-2 px-4 border-b">{{ curr.course.title }}</td>
            <td class="py-2 px-4 border-b">{{ curr.course.batch_number }}</td>
            <td class="py-2 px-4 border-b">
              <tr v-for="(topic, idx) in curr.topics" :key="idx">
                <td class="border-b">{{ topic.week }}</td>
              </tr>
            </td>
            <td class="py-2 px-4 border-b">
              <tr v-for="(topic, idx) in curr.topics" :key="idx">
                <td class="border-b">{{ topic.topic }}</td>
              </tr>
            </td>
            <td class="py-2 px-4 border-b">{{ curr.course.status }}</td>
            <td class="py-2 px-4 flex space-x-2">
              <Link :href="route('curriculum.edit', curr.course_id)">
                <el-button>Edit</el-button>
              </Link>
              <el-button @click="deleteCurriculum(curr.course_id)">Delete</el-button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="flex items-center mt-4">
        <button class="py-2 px-4 bg-gray-300 hover:bg-gray-400 rounded" :disabled="currentPage === 1" @click="prevPage">Previous</button>
        <span class="ml-2">Page {{ currentPage }} of {{ totalPages }}</span>
        <button class="py-2 px-4 bg-gray-300 hover:bg-gray-400 rounded ml-2" :disabled="currentPage === totalPages" @click="nextPage">Next</button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
</style>