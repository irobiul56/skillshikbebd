<script setup>
import { Link } from "@inertiajs/vue3";
</script>
<template>
        <footer class="py-10 container max-w-6xl mt-8 mx-auto border-t border-blue-300">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-6">
                <div>
                    <img :src="'/storage/image/logo.png'" class="h-20 w-40"  alt="">
                    <h3 class="text-lg font-bold">Skill Shikbe Bangladesh</h3>
                    <p class="text-gray-600">অনলাইন লাইভ স্কিল ডেভেলপমেন্ট প্লাটফর্ম।</p>
                    
                </div>
                <div>
                    <h4 class="font-semibold">কুইক লিংক</h4>
                    <ul class="text-gray-600 space-y-2 mt-2">
                        <li>আপকামিং লাইভ ব্যাচ</li>
                        <li>ফ্রি কোর্সসমূহ</li>
                        <li>লাইভ ওয়ার্কশপ</li>
                        <li>ব্লগ</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold">যোগাযোগ</h4>
                    <p class="text-gray-600">📧 support@skillshikbebd.com</p>
                    <p class="text-gray-600">Dhaka, Rajshahi, Gazipur.</p>
                </div>
                <div>
                    <h4 class="font-semibold">কোম্পানি</h4>
                    <ul class="text-gray-600 space-y-2 mt-2">
                        <li>আমাদের সম্পর্কে</li>
                        <li>রিফান্ড পলিসি</li>
                        <Link :href="route('privacy')"><li class="mt-2">প্রাইভেসী পলিসি</li></Link> 
                        <Link :href="route('terms')"><li class="mt-2">টার্মস এবং শর্তাবলী</li></Link>
                    </ul>
                </div>
            </div>
        </footer>
</template>

<style scoped>
</style>