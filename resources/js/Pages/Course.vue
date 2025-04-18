<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { ref, computed } from "vue";
import { usePage, useForm, Head, Link } from '@inertiajs/vue3';
import { ElMessage } from 'element-plus';

const { props } = usePage();
const courses = ref(props.courses);
const activeNames = ref(["week10"]); // Default open section


const daysRemaining = computed(() => {
    if (!courses.value.start_date) return "তারিখ নেই"; // Handle empty or invalid date

    const today = new Date(); // Get today's date
    const start = new Date(courses.value.start_date); // Convert start_date to Date object

    if (isNaN(start)) return "ভুল তারিখ"; // Handle invalid date

    const diffTime = start.getTime() - today.getTime(); // Get difference in milliseconds
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convert to days
});

const faqs = ref([
  {
    id: 1,
    question: '1. আমি কি ভিডিওগুলো ডাউনলোড করতে পারবো?',
    answer: 'হ্যা, আপনি ভিডিও ডাউনলোড করে রাখতে পারবেন।',
    isOpen: false
  },
  {
    id: 2,
    question: '2. আমি কি মোবাইল দিয়ে জয়েন করতে পারবো?',
    answer: 'মোবাইল দিয়ে লাইভ ক্লাসে জয়েন করতে পারবেন',
    isOpen: false
  },
  {
    id: 3,
    question: '3. আমার কি ভিডিওগুলোর লাইফটাইম এক্সেস থাকবে?',
    answer: 'জ্বি, ভিডিও এবং রিসোর্সের লাইফ টাইম এক্সেস পাচ্ছেন।',
    isOpen: false
  },
  {
    id: 4,
    question: '4. লাইভ ক্লাস কোথায় হবে?',
    answer: 'স্কিল শিখবের প্লাটফরম থেকেই লাইভ ক্লাসে আপনি একটি সিঙ্গেল ক্লিকে জয়েন করতে পারবেন',
    isOpen: false
  },
  {
    id: 8,
    question: '8. লাইভ ক্লাসের রেকর্ডিং থাকবে?',
    answer: 'জ্বী, পাবেন লাইভ ক্লাস রেকর্ডিং এর লাইফ টাইম এক্সেস।',
    isOpen: false
  },
  {
    id: 9,
    question: '9. প্র্যাকটিস করতে গিয়ে সমস্যায় পড়লে সাপোর্ট পাবো কোথায়?',
    answer: 'যেকোনো সমস্যায় দুইবেলা সাপোর্ট ক্লাসে স্ক্রিন শেয়ার করে সাপোর্ট নিবেন দক্ষ সাবজেক্ট ম্যাটার এক্সপার্টদের থেকে।',
    isOpen: false
  }
]);

const toggleAccordion = (index) => {
  faqs.value[index].isOpen = !faqs.value[index].isOpen;
};


</script>
<template>
     <Head title="Course" />
    <FrontendLayout>
    <div style="font-family: 'Hind Siliguri'" class="max-w-6xl mx-auto shadow-lg rounded-lg p-6 flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-2/4">
            <span class="border border-green-600 text-green text-sm px-3 py-1 rounded-full">🔴 লাইভ কোর্স</span>
            <h1 class="text-3xl font-bold mt-2">{{courses.title}}</h1>
            <div class="flex items-center mt-2 text-gray-700">
                <span class="text-green-600 font-semibold">4.7 ⭐</span>
                <span class="ml-2">(253 Ratings)</span>
            </div>
            <p class="text-gray-600 mt-2">{{ courses.description }}</p>
            
            <div class="mt-4 flex items-center">
                <Link :href="route('checkout', courses.slug)" class="bg-yellow-400 px-5 py-2 rounded font-semibold text-black flex items-center">  {{ courses.batch_number }} ব্যাচে ভর্তি হন → </Link>
                <span class="line-through text-3xl font-bold ml-4">৳ {{ courses.price }}</span>
                <span class="text-3xl font-bold ml-4">৳ {{ courses.price - ((courses.price * courses.discount)/100) }}</span>
               
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-1 mt-4 text-center">
                <div class="bg-gray-200 p-2 rounded text-xs">🔴 {{courses.live_classes}} টি লাইভ ক্লাস</div>
                <div class="bg-gray-200 p-2 rounded text-xs">📚 {{ courses.projects }} টি প্রজেক্টসমূহ</div>
                <div class="bg-gray-200 p-2 rounded text-xs">🕒 {{ daysRemaining }} দিন বাকি</div>
                <div class="bg-gray-200 p-2 rounded text-xs">🎥 {{ courses.total_classes }} টি ভিডিও</div>
            </div>
            
            <div class="mt-4 flex gap-2">
                <div class="bg-green-400 p-2 rounded text-xs">জব প্লেসমেন্ট সাপোর্ট</div>
                <div class="bg-green-200 p-2 rounded text-xs">ক্লাস রেকর্ডিং & লাইফটাইম এক্সেস</div>
            </div>

        </div>
        <div class="w-full md:w-2/4 relative">
            <a href="#" onclick="this.nextElementSibling.style.display='block'; this.style.display='none';">
                <div class="relative">
                    <img class="w-full h-56 md:h-full rounded-lg" v-if="courses.thumbnail" :src="courses.thumbnail" alt="YouTube Thumbnail">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white bg-black bg-opacity-50 rounded-full p-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-4.586-2.672A1 1 0 009 9v6a1 1 0 001.166.98l4.586-2.672a1 1 0 000-1.72z" />
                        </svg>
                    </div>
                </div>
            </a>
            <iframe class="w-full h-56 md:h-full rounded-lg" :src="courses.videos" frameborder="0" allowfullscreen style="display: none;"></iframe>
            <div class="absolute top-2 left-2 bg-green-500 bg-opacity-75 text-white px-3 py-1 text-xs rounded"> ক্লিক করে দেখে নিন কোর্সের ডেমো ক্লাস</div>
        </div>
    </div>
    
    <section style="font-family: 'Hind Siliguri'" class="max-w-6xl mx-auto p-6 rounded-lg mt-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-center text-gray-700">
        <div>
            <p class="text-sm font-semibold">ব্যাচ শুরু</p>
            <p class="text-lg font-bold p-2 rounded">{{ courses.start_date }}</p>
        </div>
        <div>
            <p class="text-sm font-semibold">📅 লাইভ ক্লাস</p>
            <p class="text-lg font-bold">{{ courses.class_schedule }}</p>
        </div>
        <div>
            <p class="text-sm font-semibold">💻 ক্লাস সংখ্যা</p>
            <p class="text-lg font-bold">{{ courses.total_classes }} টি</p>
        </div>
        <div>
            <p class="text-sm font-semibold">🚀 ভর্তি চলছে</p>
            <p class="text-lg font-bold">{{ courses.batch_number }} ব্যাচ</p>
        </div>
    </section>
  <div style="font-family: 'Hind Siliguri'" class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-6">
    <h2 class="text-2xl font-bold text-center">কারিকুলাম</h2>
    <h2 class="text-xl font-bold text-green-600 text-center">{{ courses.title }}</h2>
    <p class="text-center text-gray-500">ক্লাস নিবেনঃ <strong>Robiul Islam</strong> & <strong>Rakib Hasan</strong></p>

    <el-collapse v-model="activeNames" accordion class="grid grid-cols-1 md:grid-cols-2 gap-1 mt-4 bg-green-50">
      <el-collapse-item 
        v-for="curriculum in courses.curriculums" 
        :key="curriculum.id" 
        :name="curriculum.id"
      >
        <template #title>
          <el-tag type="success" class="ml-2">{{ curriculum.week }}</el-tag>
          <span class="ml-3 font-semibold text-green-700">{{ curriculum.topic }}</span>
        </template>
        <p v-if="curriculum.details" class="text-gray-700 text-sm p-5">{{ curriculum.details }}</p>
      </el-collapse-item>
    </el-collapse>
  </div>

  <div class="max-w-6xl mx-auto rounded-lg p-6 mt-6 flex justify-center">
    <Link :href="route('checkout', courses.slug)" class="bg-yellow-400 px-5 py-3 rounded font-semibold text-black flex">
        কোর্সে এনরোল করুন →
    </Link>
</div>

    <section v-if="courses.gets && courses.gets.length > 0" style="font-family: 'Hind Siliguri'" class="max-w-6xl mx-auto rounded-lg p-6 mt-6">
            <h2 class="text-2xl font-bold text-center">কোর্সে আপনি পাচ্ছেন</h2>
            <div class="flex justify-center">
                <img src="https://cdn.ostad.app/public/upload/2023-11-05T09-20-16.532Z-learn_topic.svg" alt="">

            </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 p-6">
            <div class="flex py-6 px-2 flex-col justify-center items-center rounded bg-gray-50 shadow-sm" v-for="(get, index) in courses.gets" :key="index">
                <span class="text-2xl"><img :src="get.icon ? `/storage/${get.icon}` : ''" alt="" class="w-10 h-10 object-cover"></span>
                <h3 class="font-semibold mt-2">{{ get.title }}</h3>
                <p class="text-gray-600 text-sm">{{ get.description }}</p>
            </div>
        </div>
    </section> 


    <section class="py-10 md:pt-16 md:pb-[92px] bg-white" >
  <div class="w-full px-4 mx-auto max-w-screen-sm md:max-w-screen-md lg:max-w-[1150px] xl:max-w-[1150px]" v-if="courses.tools && courses.tools.length > 0">
    <div class="flex flex-col items-center justify-center gap-3 md:gap-6">
      <h2 class="text-2xl md:text-4xl font-bold text-gray-900 text-center">
        যেসব ট্যুলস ও টেকনোলোজি শিখবেন
      </h2>
      
      <div class="w-full md:w-[54%] grid grid-cols-3 md:grid-cols-4 gap-4">
        <!-- VS Code -->
        <div class="opacity-100 translate-y-[-6px]" v-for="(tool, index) in courses.tools" :key="index">
          <div class="flex py-6 px-2 flex-col justify-center items-center gap-3 rounded bg-gray-50 shadow-sm">
            <img class="w-8" :src="tool.icon ? `/storage/${tool.icon}` : ''"  alt="VS Code">
            <p class="text-sm text-center text-gray-700">{{ tool.title }}</p>
          </div>
        </div>
        
      </div>
    </div>
  </div>
  <div class="py-8 md:py-14 px-4 flex flex-col gap-5 bg-white">
  <div class="w-full mx-auto max-w-screen-sm md:max-w-screen-md lg:max-w-[1150px] xl:max-w-[1150px]">
    <div class="flex flex-col gap-5 text-center">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-900 relative pb-4 before:content-[''] before:absolute before:bottom-0 before:left-0 before:w-16 before:h-1 before:bg-y-400">
        কী কী <span class="text-yellow-500">থাকতে</span> হবে
      </h1>
      
      <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6 h-auto">
        <!-- Laptop/Desktop -->
        <div class="flex p-2 md:p-6 flex-col items-center md:items-start gap-4 flex-1 rounded-xl bg-gray-50">
          <div class="flex p-3 justify-center items-center gap-2 rounded bg-gray-100">
            <img class="w-10" src="https://cdn.ostad.app/public/upload/2023-11-04T08-40-03.645Z-laptop.png" alt="Laptop">
          </div>
          <p class="text-base font-medium text-gray-700">ল্যাপটপ/ডেস্কটপ (৪ জিবি র‌্যাম)</p>
        </div>
        
        <!-- Internet Connection -->
        <div class="flex p-2 md:p-6 flex-col items-center md:items-start gap-4 flex-1 rounded-xl bg-gray-50">
          <div class="flex p-3 justify-center items-center gap-2 rounded bg-gray-100">
            <img class="w-10" src="https://cdn.ostad.app/public/upload/2023-11-04T08-40-54.789Z-freelance.png" alt="Internet">
          </div>
          <p class="text-base font-medium text-gray-700">ভালো ইন্টারনেট কানেকশন</p>
        </div>
        
        <!-- Perseverance -->
        <div class="flex p-2 md:p-6 flex-col items-center md:items-start gap-4 flex-1 rounded-xl bg-gray-50">
          <div class="flex p-3 justify-center items-center gap-2 rounded bg-gray-100">
            <img class="w-10" src="https://cdn.ostad.app/public/upload/2023-11-04T08-41-05.911Z-perseverance.png" alt="Perseverance">
          </div>
          <p class="text-base font-medium text-gray-700">লেগে থাকার মানসিকতা</p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="py-6 md:pb-12 bg-white">
    <div class="relative">
      <h1 class="text-xl md:text-4xl text-gray-800 text-center relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-16 after:h-1 after:bg-yellow-500">
        প্রায়ই জিজ্ঞেস করা <span class="text-yellow-500">প্রশ্ন</span>
      </h1>
    </div>

    <div class="w-full px-4 mx-auto max-w-screen-sm md:max-w-screen-md lg:max-w-[1150px] xl:max-w-[1150px]">
      <div class="mx-auto mt-8 md:mt-12 w-full md:w-2/3">
        <div class="flex flex-col justify-center items-center">
          <ul class="w-full bg-transparent space-y-2">
            <li 
              v-for="(faq, index) in faqs" 
              :key="faq.id"
              class="w-full flex-1 cursor-pointer list-none overflow-hidden bg-white border border-transparent rounded-lg shadow-[0_0_0_1px_rgba(0,0,0,0.05)] p-4 mb-2"
              @click="toggleAccordion(index)"
            >
              <div class="flex flex-row justify-between items-center bg-transparent text-gray-900 p-0">
                <p class="font-semibold text-base leading-[27px]">{{ faq.question }}</p>
                <span>
                  <img 
                    src="https://cdn.ostad.app/public/upload/2023-11-15T06-41-25.085Z-arrow-down-s-line.svg" 
                    :class="['transform transition-transform duration-200', {'rotate-180': faq.isOpen}]"
                  >
                </span>
              </div>
              <div 
                class="overflow-hidden transition-all ease-in-out duration-200 bg-transparent text-gray-900"
                :class="{'h-auto': faq.isOpen, 'h-0': !faq.isOpen}"
              >
                <div class="font-normal text-base leading-6 whitespace-pre-wrap p-0 pt-2">
                  {{ faq.answer }}
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

<div class="max-w-6xl mx-auto rounded-lg p-6 mt-6 flex justify-center">
    <Link :href="route('checkout', courses.slug)" class="bg-yellow-400 px-5 py-3 rounded font-semibold text-black flex">
        কোর্সে এনরোল করুন →
    </Link>
</div>

</section>
<div class="w-full px-4 mx-auto max-w-screen-sm md:max-w-screen-md lg:max-w-[1150px] xl:max-w-[1150px]">
  <div class="  md:pb-[110px] flex flex-col md:flex-row gap-2 md:gap-6 items-center justify-center">
    <!-- Heading -->
    <p class="w-full md:w-[310px] text-xl md:text-4xl text-center md:text-end text-gray-800">
      জয়েন করুন আমাদের ফেসবুক গ্রুপে
    </p>
    
    <!-- Group Card -->
    <div class="w-full md:w-[554px]">
      <div class="flex flex-col justify-between items-start p-3 gap-4 w-full bg-white border border-gray-200 rounded-lg lg:flex-row lg:py-3 lg:px-4">
        <!-- Group Cover Image -->
        <img 
          class="w-full lg:min-w-[240px] lg:max-w-[240px] aspect-video object-cover rounded overflow-hidden" 
          alt="Facebook Group Cover" 
          :src="courses.thumbnail"
        >
        
        <!-- Group Info -->
        <div class="flex flex-col items-start p-0 gap-2 w-full">
          <!-- Member Count Badge -->
          <div class="flex flex-col gap-1 flex-wrap">
            <div class="flex flex-wrap justify-center items-center bg-blue-50 rounded px-1.5 py-0.5 w-fit gap-2 text-center">
              <img width="16" height="16" src="https://cdn.ostad.app/public/icons/team-line.svg" alt="Members">
              <p class="font-medium text-xs leading-[19px] tracking-wide whitespace-nowrap">
                ২০০০ জন মেম্বার
              </p>
            </div>
            
            <!-- Group Name -->
            <p class="text-base font-medium text-gray-900">
              {{courses.title}} Community @Bangladesh
            </p>
          </div>
          
          <!-- Join Button -->
           <a :href="courses.group" target="_blank" rel="noopener noreferrer">
          <button 
            type="button" 
            class="w-full md:w-auto text-gray-900 bg-gray-100 hover:bg-gray-200 active:bg-gray-300 rounded-md h-10 px-6 py-2 transition-colors duration-200"
          >
            <div class="flex justify-center items-center gap-2">
              <p class="whitespace-nowrap">জয়েন করুন</p>
              <div class="flex justify-center items-center">
                <img 
                  src="https://cdn.ostad.app/public/icons/facebook-circle-line.svg" 
                  class="w-[19px] min-w-[19px] h-[19px] min-h-[19px]" 
                  alt="Facebook"
                >
              </div>
            </div>
          </button>
        </a>
        </div>
      </div>
    </div>
  </div>
</div>
    </FrontendLayout>
</template>
<style scoped>
 @import url('https://fonts.googleapis.com/css?family=Baloo+Da');
</style>