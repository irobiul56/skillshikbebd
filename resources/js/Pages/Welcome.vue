<script setup>
import { ref } from "vue";
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const courses = ref(props.courses);

</script>
<template>

    <body class="bg-gray-100">

        <Head title="Welcome" />
        <FrontendLayout>

            <section
                class="max-w-6xl mx-auto mt-8 p-6 bg-gray-100 shadow rounded-lg border border-green-600 bg-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Skill Shikbe <span class="text-red-600">Bangladesh
                            </span> 🔴</h1>
                        <p class="mt-4 text-gray-600">নতুন স্কিল, নতুন সম্ভাবনা: আজই শুরু করুন শেখা</p>
                        <button class="mt-6 bg-green-400 px-6 py-3 text-black font-semibold rounded">শেখা শুরু করুন
                            →</button>
                        <p class="mt-6 text-gray-600">নতুন স্কিল শেখার মাধ্যমে খুলে যেতে পারে অসংখ্য সম্ভাবনার দরজা। আজই
                            শিখতে শুরু করুন ভবিষ্যতের জন্য! 🚀</p>
                    </div>
                    <div>
                        <img :src="`/storage/image/banner.png`"
                            class="w-full h-80 rounded-lg shadow-lg" alt="Skill Learning">
                    </div>
                </div>
            </section>

            <div class="max-w-6xl mt-8 mx-auto">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">🔴 আপকামিং লাইভ কোর্স</h2>

                <div class="flex space-x-4 overflow-x-auto pb-2 text-center">
                    <button class="px-4 py-1 bg-blue-600 text-white rounded-lg">Web & App Development</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Quran Shikkha</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Calligraphy</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Business & Marketing</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Data Engineering</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Creatives</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Cyber Security</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border hover:border-indigo-600 bg-gray-100" v-for="(course, index) in courses" :key="index">
                        <Link :href="route('course.single', course.slug)">
                            <img :src="course.thumbnail"
                                alt="Course Image" class="w-full">
                            <div class="p-4">
                                <p class="text-sm text-gray-600 text-center"><span class="border bg-gray-100">ব্যাচ
                                {{ course.batch_number }}</span> <span
                                class="border bg-gray-100 ml-1">{{ course.projects }} প্রজেক্টস</span> <span
                                        class="border bg-gray-100 ml-1">{{ course.total_classes }} দিন ব্যাপি</span></p>
                                <h3 class="font-bold text-lg mt-4 mb-4">{{ course.title }}</h3>
                                <button id="" type="button"
                                    class="group w-full flex gap-2 justify-center items-center transition-all duration-200 active:scale-[98%] h-10 rounded-md mt-2 px-4 py-2 bg-gray-100 text-black rounded-lg">
                                    <p> বিস্তারিত দেখি </p><img
                                        class=" transition-all duration-200 w-5 h-5 min-w-[20px] "
                                        src="https://cdn.ostad.app/public/icons/arrow-right-line.svg">
                                </button>
                            </div>
                        </Link>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                    <div class="bg-gray-900 text-white rounded-lg p-6 flex items-center">
                        <img src="https://cdn.ostad.app/public/upload/2023-09-24T10-51-25.393Z-codemama-img.webp"
                            alt="CodeMama" class="w-2/4  h-24 object-cover rounded-md">
                        <div class="ml-4">
                            <h3 class="text-lg font-bold">স্কিল শিখে আপনার নলেজকে সমৃদ্ধ করুন আমাদের সাথে</h3>
                            <button class="mt-2 px-4 py-2 bg-gray-800 text-white rounded-lg">CHECK COURSE →</button>
                        </div>
                    </div>
                    <div class="bg-gray-900 text-white rounded-lg p-6 flex items-center">
                        <img src="https://cdn.ostad.app/public/upload/2023-09-24T10-52-11.735Z-skillable-img.webp"
                            alt="Skillable" class="w-2/4  h-24 object-cover rounded-md">
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
                            <p class="text-gray-700">সিটি বিল্ডার ও এক্সপার্ট সিটি রিভিউ</p>
                        </div>
                        <div class="border border-gray-200 p-6">
                            <span class="text-3xl">🛠️</span>
                            <p class="text-gray-700">১৮ ঘণ্টা লাইভ সাপোর্ট নিশ্চিত কোর্স</p>
                        </div>
                        <div class="border border-gray-200 p-6">
                            <span class="text-3xl">🏅</span>
                            <p class="text-gray-700">প্রো ব্যাচে স্পেশাল সিটি ও জব সাপোর্ট</p>
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