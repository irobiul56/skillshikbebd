<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { ref, computed } from "vue";
import { usePage, useForm, Head, Link } from '@inertiajs/vue3';

const { props } = usePage();
const courses = ref(props.courses);

</script>
<template>
     <Head title="Chekout" />
    <FrontendLayout>
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-5">
        <h2 class="text-xl font-bold mb-4">আপনার পেমেন্ট কমপ্লিট করুন</h2>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <img :src="`/storage/${courses.thumbnail}`" alt="Course Image" class="w-full object-cover rounded">
                <h3 class="mt-4 font-semibold">{{ courses.title }}</h3>
                <div class="mt-2 text-sm">
                    <table class="w-full border-collapse border border-gray-300 mt-2">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 p-2 text-left">বিবরণ</th>
                                <th class="border border-gray-300 p-2 text-right">পরিমাণ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 p-2">কোর্সের মূল্য</td>
                                <td class="border border-gray-300 p-2 text-right">{{ courses.price }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2">ডিসকাউন্ট ({{ courses.discount }}%)</td>
                                <td class="border border-gray-300 p-2 text-right">- {{ $discount = courses.price * courses.discount/100 }}</td>
                            </tr>
                            <tr class="font-bold bg-gray-100">
                                <td class="border border-gray-300 p-2">মোট পেমেন্ট</td>
                                <td class="border border-gray-300 p-2 text-right">{{ courses.price - $discount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold mb-2">পেমেন্টের মাধ্যম</h3>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-200">
                        <input type="radio" name="payment" class="mr-2"> 
                        <img src="https://cdn.ostad.app/public/gateway/bkash-payment.png" alt="bKash" class="h-7">
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-200">
                        <input type="radio" name="payment" class="mr-2"> 
                        <img src="https://seeklogo.com/images/N/nagad-logo-AA1B37DF1B-seeklogo.com.png" alt="Nagad" class="h-7">
                    </label>
                    <!-- <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-200">
                        <input type="radio" name="payment" class="mr-2"> 
                        <span>Pay Visa (Card)</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-200">
                        <input type="radio" name="payment" class="mr-2"> 
                        <span>Pay Internationally (Card)</span>
                    </label> -->
                </div>
                <button class="mt-4 w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600">পেমেন্ট সম্পন্ন করি</button>
            </div>
        </div>
        <p class="mt-4 text-sm text-gray-600">প্রয়োজনে কল করুন <span class="text-red-500">+8801763264270</span> (সকাল ১০টা থেকে রাত ১০টা)</p>
    </div>
    </FrontendLayout>
</template>
<style scoped>
 @import url('https://fonts.googleapis.com/css?family=Baloo+Da');
</style>