<script setup>
import UserDashboardLayout from '@/Layouts/UserDashboardLayout.vue';
import { ref, computed } from "vue";
import { usePage, useForm, Head, Link } from '@inertiajs/vue3';
import { ElDrawer, ElInput, ElButton, ElForm, ElFormItem, ElMessage } from 'element-plus';

// Reactive props from Inertia
const { props } = usePage();
const course = ref(props.course);

</script>
<template>
    <UserDashboardLayout>
      <div v-if="$page.props.flash?.message" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 alert">
        {{ $page.props.flash?.message }}
      </div>
        <div class="w-full m-5 p-0 md:p-6 flex flex-col items-start gap-4 md:gap-6 rounded-none md:rounded-2xl border-none md:border border-gray-200 bg-none md:bg-white">
  <!-- Heading -->
  <div class="flex flex-col md:flex-row gap-3 w-full justify-between items-start">
    <p class="text-xl md:text-2xl font-semibold text-gray-800">আমার কোর্সসমূহ</p>
  </div>

  <!-- Course Cards Grid -->
  <div class="grid grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-2 2xl:gap-6 md:gap-x-2 md:gap-y-6 w-full" v-for='(courses, index) in course' :key='index'>
    <Link :href="route('mycourse', courses.course.id)" class="group relative transition-all duration-200 flex flex-col md:flex-row h-full w-full p-0 md:p-1.5 2xl:p-2.5 items-center gap-0 md:gap-2 2xl:gap-3 rounded-lg md:rounded-md cursor-pointer border border-gray-200 md:border-gray-300 hover:border-gray-400 hover:md:border-gray-300 bg-white md:bg-gray-50 hover:md:bg-gray-100">
      <img class="w-full md:w-[175px] lg:w-[140px] xl:w-[175px] 2xl:w-[212px] rounded-lg md:rounded aspect-video object-cover mix-blend-luminosity" :src="'/storage/'+courses.course.thumbnail">
      
      <div class="flex pt-1 pb-0 px-2 md:pt-0 md:px-0 flex-col gap-2 md:gap-1.5 items-start justify-between md:justify-center flex-1 self-stretch">
        <p class="text-sm md:text-base font-semibold 2xl:text-lg text-gray-500">{{courses.course.title}}</p>
        
        <div class="flex gap-1.5">
          <div class="flex py-0.5 px-1.5 justify-center text-gray-500 items-center gap-1 rounded bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 13 13" fill="currentColor">
              <path d="M6.47971 7.03161L7.18571 7.73761L11.4187 3.50461L12.1257 4.21161L7.18571 9.15161L4.00371 5.96961L4.71071 5.26261L5.77321 6.32511L6.47971 7.03111V7.03161ZM6.48071 5.61761L8.95671 3.14111L9.66171 3.84611L7.18571 6.32261L6.48071 5.61761ZM5.06721 8.44511L4.36071 9.15161L1.17871 5.96961L1.88571 5.26261L2.59221 5.96911L2.59171 5.96961L5.06721 8.44511Z"></path>
            </svg>
            <p class="text-xs">{{courses.status}}</p>
          </div>
          <div class="flex py-0.5 px-1.5 justify-center items-center gap-1 rounded bg-gray-200">
            <p class="text-xs text-gray-500">ব্যাচ {{courses.course.batch_number}}</p>
          </div>
        </div>
      </div>
      
      <div class="flex p-2 items-center gap-2 self-stretch md:hidden">
        <button type="button" class="btn bg-gray-800 text-white hover:bg-gray-700 active:bg-gray-800 rounded" style="height: 40px; padding: 8px 24px; font-size: 14px;">
          <div class="flex justify-center items-center gap-2">
            <p class="whitespace-nowrap">কোর্সে যাই</p>
            <div class="flex justify-center items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
              </svg>
            </div>
          </div>
        </button>
      </div>
      
      <div class="absolute hidden justify-center items-center right-0 w-[45px] h-full bg-gray-100/30 backdrop-blur-sm">
        <div class="w-8 h-8 rounded-full bg-white flex justify-center items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6"/>
          </svg>
        </div>
      </div>
    </Link>

  </div>
</div>
    </UserDashboardLayout>
</template>