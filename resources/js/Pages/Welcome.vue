<script setup>
import { ref } from "vue";
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const courses = ref(props.courses);
const allCourses = ref(props.courses); // Store all courses for resetting filter
const category = ref(props.category);
const selectedCategory = ref(null);

// Function to filter courses by category
const filterCourses = (categoryId) => {
  if (selectedCategory.value === categoryId) {
    // If same category is clicked again, reset filter
    selectedCategory.value = null;
    courses.value = allCourses.value;
  } else {
    // Filter courses by category
    selectedCategory.value = categoryId;
    courses.value = allCourses.value.filter(course =>
      course.category_id === categoryId
    );
  }
};
</script>
<template>

  <body class="bg-gray-100">

    <Head title="Welcome" />
    <FrontendLayout>

      <section
        class="w-full pt-2 pb-2 md:pb-0 relative rounded-2xl md:rounded-none md:bg-none bg-cover bg-center bg-no-repeat">
        <!-- Blob background elements -->
        <div class="relative w-full h-full overflow-hidden">
          <div class="absolute -top-20 -left-20 w-64 h-64 rounded-full bg-blue-100 opacity-30 blur-xl"></div>
          <div class="absolute top-0 right-0 w-40 h-40 rounded-full bg-purple-100 opacity-20 blur-xl"></div>
          <div class="absolute bottom-10 left-1/4 w-48 h-48 rounded-full bg-yellow-100 opacity-20 blur-xl"></div>
          <div class="absolute bottom-20 right-20 w-32 h-32 rounded-full bg-green-100 opacity-20 blur-xl"></div>
        </div>

        <div class="w-full px-4 mx-auto sm:max-w-[540px] md:max-w-[720px] lg:max-w-[1150px] xl:max-w-[1150px]">
          <div
            class="w-full grid grid-cols-1 justify-between gap-6 md:relative md:p-6 md:rounded-2xl shadow-none md:shadow-md border-0 md:border border-gray-200 lg:flex lg:h-full bg-white p-3">
            <!-- Content section -->
            <div class="w-full h-full flex flex-col gap-6 md:gap-12 z-10">
              <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-2">
                  <div class="flex items-center flex-wrap justify-center md:justify-start gap-4">
                    <h1 class="text-4xl font-bold text-center text-gray-900">Skill Shikbe
                    </h1>
                    <div class="flex gap-4 items-center">
                      <h1 class="text-4xl font-bold text-red-500">Bangladesh</h1>
                      <div class="flex gap-1">
                        <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                        <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse delay-100"></div>
                      </div>
                    </div>
                  </div>
                  <p class="text-lg max-w-full lg:max-w-[425px] text-center md:text-start text-gray-600">নতুন স্কিল,
                    নতুন
                    সম্ভাবনা: আজই শুরু করুন শেখা</p>
                </div>

                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                  <a href="#course" class="w-full">
                    <button
                      class="group w-full flex gap-2 justify-center items-center transition-all duration-200 active:scale-95 h-12 px-6 py-3 rounded-lg bg-yellow-400 hover:bg-yellow-500 active:bg-yellow-600">
                      <span
                        class="uppercase whitespace-nowrap transition-all duration-200 font-medium text-gray-900">শেখা
                        শুরু করুন</span>
                      <svg class="transition-all duration-200 w-6 h-6 min-w-[24px]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M14 5l7 7m0 0l-7 7m7-7H3">
                        </path>
                      </svg>
                    </button>
                  </a>
                </div>
              </div>

              <img class="block md:hidden w-full h-80 rounded-2xl aspect-[4/3]" :src="'/storage/image/banner.png'"
                alt="Learning image">

              <div class="flex flex-col w-full gap-4">
                <p class="text-gray-600">নতুন স্কিল শেখার মাধ্যমে খুলে যেতে পারে অসংখ্য সম্ভাবনার দরজা। আজই শিখতে শুরু
                  করুন
                  ভবিষ্যতের জন্য! 🚀</p>
                <div class="flex flex-col w-full gap-4">
                  <div class="flex gap-4 flex-wrap">
                    <img class="w-auto h-5 transition-all duration-300 filter grayscale hover:grayscale-0"
                      src="https://i0.wp.com/exprtusa.com/wp-content/uploads/2020/12/exprtusa-logo.png"
                      alt="Company logo">
                    <img class="w-auto h-5 transition-all duration-300 filter grayscale hover:grayscale-0"
                      src="https://genarticle.com/wp-content/uploads/2023/07/genarticle-logo-1.png" alt="Company logo">
                    <img class="w-auto h-5 transition-all duration-300 filter grayscale hover:grayscale-0"
                      src="https://skillshikbebd.com/storage/image/logo.png" alt="Company logo">
                    <img class="w-auto h-5 transition-all duration-300 filter grayscale hover:grayscale-0"
                      src="https://visaconsultncy.com/storage/image/Visa%20Consultncy%20Logo.jpg" alt="Company logo">
                    <img class="w-auto h-5 transition-all duration-300 filter grayscale hover:grayscale-0"
                      src="https://bdkafela.com/wp-content/uploads/2024/09/New-Project-1.png" alt="Company logo">
                    <img class="w-auto h-5 transition-all duration-300 filter grayscale hover:grayscale-0"
                      :src="'/storage/image/learn and teach logo.png'" alt="Company logo">
                  </div>
                </div>
              </div>
            </div>

            <!-- Right side image (hidden on mobile) -->
            <img
              class="w-full h-full aspect-[4/3] lg:h-[301px] overflow-hidden hidden md:block object-cover rounded-2xl"
              :src="'/storage/image/banner.png'" alt="Learning image">
          </div>
        </div>
      </section>

      <section id="course" class="w-full pt-10 md:pt-16">
        <div class="w-full px-4 mx-auto sm:max-w-[540px] md:max-w-[720px] lg:max-w-[1150px] xl:max-w-[1150px]">
          <div
            class="flex flex-col items-center gap-3 p-0 md:p-4 bg-none md:bg-white md:rounded-2xl md:shadow-md overflow-hidden">
            <div class="flex items-center gap-2">
              <img class="w-10 h-10"
                src="https://cdn.ostad.app/public/upload/2023-08-07T04-54-15.325Z-broadcast-line-red.svg">
              <p class="text-lg md:text-2xl font-medium text-gray-800">আপকামিং লাইভ কোর্স</p>
            </div>

            <div class="w-full flex flex-col items-center gap-4 md:gap-6">
              <!-- Category tabs -->
              <div class="flex flex-col gap-6 w-full">
                <div class="relative">
                  <div class="flex overflow-x-auto gap-3 pb-2 scrollbar-hide">
                    <!-- Active category -->
                    <div class="flex-shrink-0" v-for="(categories, index) in category" :key="index">
                      <div @click="filterCourses(categories.id)"
                        class="group flex items-center gap-1.5 px-4 py-2 rounded-md cursor-pointer" :class="{
                          'bg-gray-800 border border-gray-700': selectedCategory === categories.id,
                          'bg-gray-100 border border-gray-200 hover:bg-gray-200 hover:border-gray-300': selectedCategory !== categories.id
                        }">
                        <div class="w-7 bg-white flex justify-center items-center rounded-full shadow-sm p-1.5">
                          <img class="w-4"
                            :src="categories.icon || 'https://cdn.ostad.app/public/upload/2023-06-22T06-40-41.054Z-code-box-line.png'">
                        </div>
                        <div>
                          <p class="text-sm font-medium" :class="{
                            'text-white': selectedCategory === categories.id,
                            'text-gray-800': selectedCategory !== categories.id
                          }">
                            {{ categories.name }}
                          </p>
                          <p class="text-xs" :class="{
                            'text-gray-400': selectedCategory === categories.id,
                            'text-gray-500': selectedCategory !== categories.id
                          }">
                            • {{ categories.courses_count || '' }} কোর্স
                          </p>
                        </div>
                      </div>
                    </div>

                    <!-- Inactive categories -->
                    <!-- <div class="flex-shrink-0">
                <div class="group flex items-center gap-1.5 px-4 py-2 rounded-md bg-gray-100 border border-gray-200 hover:bg-gray-200 hover:border-gray-300 cursor-pointer">
                  <div class="w-7 bg-white flex justify-center items-center rounded-full shadow-sm p-1.5">
                    <img class="w-4 filter brightness-0 group-hover:brightness-100 transition-all" src="https://cdn.ostad.app/public/upload/2023-06-07T09-55-30.105Z-product-design.png">
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-800 group-hover:underline">Product Management & Design</p>
                    <p class="text-xs text-gray-500">• ৮ কোর্স • ২ ওয়ার্কশপ</p>
                  </div>
                </div>
              </div> -->

                    <!-- More category items... -->
                  </div>
                </div>

                <!-- Course cards grid -->
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-3">
                  <!-- Course card 1 -->
                  <Link v-for="(course, index) in courses" :key="index" :href="route('course.single', course.slug)"
                    class="w-full h-full">
                  <div
                    class="relative flex flex-col w-full h-full bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-gray-300 hover:shadow-md transition-all">
                    <div class="w-full aspect-video overflow-hidden">
                      <img :src="course.thumbnail" class="w-full h-full object-cover" loading="lazy"
                        alt="Course thumbnail">
                    </div>

                    <div class="flex flex-wrap p-2 items-center gap-1 border-t border-b border-gray-200 bg-gray-100">
                      <div class="hidden sm:block">
                        <div class="flex items-center gap-1 px-1 py-1 rounded bg-gray-200">
                          <p class="text-xs text-gray-700">ব্যাচ {{ course.batch_number }}</p>
                        </div>
                      </div>
                      <div class="flex items-center gap-1 px-1 py-1 rounded bg-gray-200">
                        <img class="w-3 h-3" src="https://cdn.ostad.app/public/icons/team-line.svg">
                        <p class="text-xs text-gray-700">{{ course.projects }} প্রজেক্টস</p>
                      </div>
                      <div class="flex items-center gap-1 px-1 py-1 rounded bg-gray-200">
                        <img class="w-3 h-3" src="https://cdn.ostad.app/public/icons/time-line.svg">
                        <p class="text-xs text-gray-700">{{ course.total_classes }} দিন ব্যাপি</p>
                      </div>
                    </div>

                    <div class="flex flex-col flex-grow justify-between">
                      <div class="p-2 md:p-4">
                        <p class="text-sm md:text-lg font-bold text-gray-900 line-clamp-3">{{ course.title }}</p>
                      </div>

                      <div class="w-full p-2 md:px-4 md:py-3 bg-none md:bg-gray-100">
                        <div class="sm:hidden">
                          <button
                            class="w-full flex gap-2 justify-center items-center h-8 px-3 py-2 rounded bg-gray-200 hover:bg-gray-300 active:bg-gray-400 transition-all">
                            <p class="text-xs uppercase text-gray-900">বিস্তারিত দেখি</p>
                            <img class="w-5 h-5 filter invert brightness-0"
                              src="https://cdn.ostad.app/public/icons/arrow-right-line.svg">
                          </button>
                        </div>
                        <div class="hidden sm:block">
                          <button
                            class="w-full flex gap-2 justify-center items-center h-10 px-6 py-2 rounded-md bg-gray-200 hover:bg-gray-300 active:bg-gray-400 transition-all">
                            <p class="text-sm uppercase font-medium text-gray-900">বিস্তারিত দেখি</p>
                            <img class="w-5 h-5" src="https://cdn.ostad.app/public/icons/arrow-right-line.svg">
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  </Link>

                  <!-- More course cards... -->
                </div>

                <!-- See all button -->
                <!-- <div class="flex justify-center">
                      <div class="w-full max-w-[375px]">
                        <a :href="selectedCategory ? `/category/${selectedCategory}` : '/courses'" class="w-full">
                          <button class="w-full flex gap-2 justify-center items-center h-12 px-6 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 active:bg-gray-400 transition-all">
                            <p class="text-sm uppercase font-medium text-gray-900">সব দেখুন</p>
                            <img class="w-6 h-6" src="https://cdn.ostad.app/public/icons/arrow-right-line.svg">
                          </button>
                        </a>
                      </div>
                    </div> -->
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="max-w-6xl mt-8 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
          <div class="bg-gray-900 text-white rounded-lg p-6 flex items-center">
            <img src="https://cdn.ostad.app/public/upload/2023-09-24T10-51-25.393Z-codemama-img.webp" alt="CodeMama"
              class="w-2/4  h-24 object-cover rounded-md">
            <div class="ml-4">
              <h3 class="text-lg font-bold">স্কিল শিখে আপনার নলেজকে সমৃদ্ধ করুন আমাদের সাথে</h3>
              <button class="mt-2 px-4 py-2 bg-gray-800 text-white rounded-lg">CHECK COURSE →</button>
            </div>
          </div>
          <div class="bg-gray-900 text-white rounded-lg p-6 flex items-center">
            <img src="https://cdn.ostad.app/public/upload/2023-09-24T10-52-11.735Z-skillable-img.webp" alt="Skillable"
              class="w-2/4  h-24 object-cover rounded-md">
            <div class="ml-4">
              <h3 class="text-lg font-bold">স্কিল টেস্ট করে পেয়ে যান ফ্রি সার্টিফিকেট</h3>
              <button class="mt-2 px-4 py-2 bg-gray-800 text-white rounded-lg">GET CERTIFICATE →</button>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md mt-10 p-6">
          <h2 class="text-xl font-bold text-center text-gray-800 mb-6">কি কি পাচ্ছেন লাইভ কোর্সে</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center border border-gray-100 p-6">
            <div class="border border-gray-200 p-6">
              <span class="text-3xl">💼</span>
              <p class="text-gray-700">জবের জন্য ডেডিকেটেড জব প্লেসমেন্ট টিম</p>
            </div>
            <div class="border border-gray-200 p-6">
              <span class="text-3xl">📜</span>
              <p class="text-gray-700">সিভি বিল্ডার ও এক্সপার্ট সিভি রিভিউ</p>
            </div>
            <div class="border border-gray-200 p-6">
              <span class="text-3xl">🛠️</span>
              <p class="text-gray-700">১৮ ঘণ্টা লাইভ সাপোর্ট নিশ্চিত কোর্স</p>
            </div>
            <div class="border border-gray-200 p-6">
              <span class="text-3xl">🏅</span>
              <p class="text-gray-700">প্রো ব্যাচে স্পেশাল সিভি ও জব সাপোর্ট</p>
            </div>
            <div class="border border-gray-200 p-6">
              <span class="text-3xl">📝</span>
              <p class="text-gray-700">লাইভ টেস্ট নিজের যাচাইয়ের সুযোগ</p>
            </div>
            <div class="border border-gray-200 p-6">
              <span class="text-3xl">🎨</span>
              <p class="text-gray-700">দিনে ৩ টিঃ পর্যন্ত সাপোর্ট ক্লাস নিশ্চিত কোর্স</p>
            </div>
          </div>
        </div>
      </div>

    </FrontendLayout>
  </body>
</template>
<style scoped></style>