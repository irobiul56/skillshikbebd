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

</script>
<template>
     <Head title="Course" />
    <FrontendLayout>
    <div class="max-w-6xl mx-auto shadow-lg rounded-lg p-6 flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-2/4">
            <span class="border border-green-600 text-green text-sm px-3 py-1 rounded-full">🔴 লাইভ কোর্স</span>
            <h1 class="text-3xl font-bold mt-2">{{courses.title}}</h1>
            <div class="flex items-center mt-2 text-gray-700">
                <span class="text-green-600 font-semibold">4.7 ⭐</span>
                <span class="ml-2">(253 Ratings)</span>
            </div>
            <p style="font-family: 'Baloo Da', cursive" class="text-gray-600 mt-2">{{ courses.description }}</p>
            
            <div class="mt-4 flex items-center">
                <Link :href="route('checkout', courses.slug)" class="bg-yellow-400 px-5 py-2 rounded font-semibold text-black flex items-center">  {{ courses.batch_number }} ব্যাচে ভর্তি হন → </Link>
                <span style="font-family: 'Baloo Da', cursive" class="line-through text-3xl font-bold ml-4">৳ {{ courses.price }}</span>
                <span style="font-family: 'Baloo Da', cursive" class="text-3xl font-bold ml-4">৳ {{ courses.price - ((courses.price * courses.discount)/100) }}</span>
               
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
    
    <section style="font-family: 'Baloo Da', cursive" class="max-w-6xl mx-auto p-6 rounded-lg mt-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-center text-gray-700">
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
  <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-6">
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

    <section class="max-w-6xl mx-auto rounded-lg p-6 mt-6">
            <h2 class="text-2xl font-bold text-center">কোর্সে আপনি পাচ্ছেন</h2>
            <div class="flex justify-center">
                <img src="https://cdn.ostad.app/public/upload/2023-11-05T09-20-16.532Z-learn_topic.svg" alt="">

            </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 p-6">
            <div class="bg-gray-100 p-4 rounded text-center">
                <span class="text-2xl">📚</span>
                <h3 class="font-semibold mt-2">৬ মাসের কারিকুলাম</h3>
                <p class="text-gray-600 text-sm">বেসিক থেকে এডভান্সড পর্যন্ত স্ট্রাকচার্ড লার্নিং</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center">
                <span class="text-2xl">🎥</span>
                <h3 class="font-semibold mt-2">১০০+ ভিডিও লেকচার</h3>
                <p class="text-gray-600 text-sm">প্রতিটি টপিকের জন্য রেকর্ডেড ভিডিও</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center">
                <span class="text-2xl">💻</span>
                <h3 class="font-semibold mt-2">লাইভ ক্লাস</h3>
                <p class="text-gray-600 text-sm">১০+ লাইভ ক্লাস অভিজ্ঞ ইন্সট্রাক্টরের সাথে</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center">
                <span class="text-2xl">📊</span>
                <h3 class="font-semibold mt-2">প্র্যাকটিকাল প্রজেক্ট</h3>
                <p class="text-gray-600 text-sm">রিয়েল ওয়ার্ল্ড স্কিল ডেভেলপমেন্ট</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center">
                <span class="text-2xl">🏆</span>
                <h3 class="font-semibold mt-2">সার্টিফিকেট</h3>
                <p class="text-gray-600 text-sm">কোর্স শেষে ইন্ডাস্ট্রি-রেডি সার্টিফিকেট</p>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center">
                <span class="text-2xl">🚀</span>
                <h3 class="font-semibold mt-2">ক্যারিয়ার সাপোর্ট</h3>
                <p class="text-gray-600 text-sm">জব প্লেসমেন্ট সহায়তা</p>
            </div>
        </div>
    </section>    
    </FrontendLayout>
</template>
<style scoped>
 @import url('https://fonts.googleapis.com/css?family=Baloo+Da');
</style>