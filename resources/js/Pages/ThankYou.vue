<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ElButton } from 'element-plus';

// Props (if you want to pass data from the backend)
const props = defineProps({
    order: Object, // Order details (optional)
});
</script>

<template>
    <Head title="Thank You" />
    <FrontendLayout>
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl w-full bg-white rounded-2xl shadow-2xl p-8 text-center transform transition-all duration-500 hover:scale-105">
                <!-- Animated Checkmark -->
                <div class="flex justify-center mb-6">
                    <svg class="w-24 h-24 text-green-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Thank You Message -->
                <h1 class="text-4xl font-bold text-green-600 mb-4 animate-fade-in">
                    ধন্যবাদ!
                </h1>
                <p class="text-xl text-gray-700 mb-8 animate-fade-in delay-100">
                    আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে। আমরা আপনার পেমেন্ট যাচাই করার পর আপনাকে ইবুকটি ডাউনলোড করার লিঙ্ক ইমেইল করব।
                </p>

                <!-- Order Details Table -->
                <div v-if="order" class="bg-gray-50 p-6 rounded-lg shadow-sm text-center animate-fade-in delay-200 mt-5">
                    <h2 class="text-2xl font-semibold mb-4 text-purple-700">অর্ডার বিবরণ</h2>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-purple-100 text-center">
                                <th class="border border-purple-200">বিবরণ</th>
                                <th class="border border-purple-200">তথ্য</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-purple-200 font-sm">ইনভয়েস নম্বর</td>
                                <td class="border border-purple-200">{{ order.id }}</td>
                            </tr>
                            <tr>
                                <td class="border border-purple-200 font-sm">পেমেন্ট মাধ্যম</td>
                                <td class="border border-purple-200">{{ order.payment_method }}</td>
                            </tr>
                            <tr>
                                <td class="border border-purple-200 font-sm">লেনদেন আইডি</td>
                                <td class="border border-purple-200">{{ order.transaction_id }}</td>
                            </tr>
                            <tr>
                                <td class="border border-purple-200 font-sm">পরিমাণ</td>
                                <td class="border border-purple-200">{{ order.amount }} টাকা</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Call to Action -->
                <div class="mt-8 animate-fade-in delay-300">
                    <p class="text-gray-600 mb-4">
                        যদি আপনার কোনো প্রশ্ন থাকে, অনুগ্রহ করে আমাদের সাথে যোগাযোগ করুন:
                    </p>
                    <a href="https://wa.me/8801763264270" target="_blank" rel="noopener noreferrer">
                        <ElButton type="primary" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition-all duration-300 hover:scale-110">
                            যোগাযোগ করুন
                        </ElButton>
                    </a>

                </div>

                <!-- Additional Information -->
                <div class="mt-8 text-sm text-gray-500 animate-fade-in delay-400">
                    <p>আমরা সাধারণত ৩০ মিনিটের মধ্যে পেমেন্ট যাচাই করে থাকি।</p>
                    <p>ইমেইল না পেলে আপনার স্প্যাম ফোল্ডার চেক করুন।</p>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<style scoped>
/* Custom styles for the thank you page */
.text-green-600 {
    color: #16a34a;
}

.bg-gray-50 {
    background-color: #f9fafb;
}

.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>