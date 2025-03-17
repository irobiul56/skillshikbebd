<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { ref, computed } from "vue";
import { usePage, useForm, Head } from '@inertiajs/vue3';
import { ElDrawer, ElInput, ElButton, ElForm, ElFormItem, ElMessage } from 'element-plus';
import axios from "axios";

// Reactive props from Inertia
const page = usePage();
const course = computed(() => page.props.courses);
const isAuthenticated = computed(() => usePage().props.auth.user);
const csrfToken = computed(() => usePage().props.csrf_token || '');

// Drawer and form state
const isDrawerVisible = ref(false);
const isLoginMode = ref(true); // Toggle Login/Register
const selectedPaymentMethod = ref("bKash"); // Default payment method

// Computed Pricing
const discountAmount = computed(() => ((course.value.price * course.value.discount) / 100).toFixed(2));
const totalPrice = computed(() => (course.value.price - discountAmount.value).toFixed(2));

// Login Form
const loginForm = useForm({ email: '', password: '' });

// Register Form
const registerForm = useForm({ name: '', email: '', password: '', password_confirmation: '' });

// Handle Payment Click
const handlePaymentClick = async () => {
    if (!csrfToken.value) {
        ElMessage.error("CSRF টোকেন পাওয়া যায়নি, অনুগ্রহ করে পেজ রিফ্রেশ করুন!");
        return;
    }

    try {
        const response = await axios.post("/bkash/payment", {
            amount: totalPrice.value,
            course_id: course.value.id,
        }, {
            headers: { 'X-CSRF-TOKEN': csrfToken.value }
        });

        if (response.data?.redirect_url) {
            window.location.href = response.data.redirect_url;
        } else {
            ElMessage.error("bKash পেমেন্ট লিংক তৈরি করতে ব্যর্থ হয়েছে!");
        }
    } catch (error) {
        console.error("Payment Error:", error);
        ElMessage.error("পেমেন্ট প্রসেস করতে ব্যর্থ হয়েছে!");
    }
};

// Login Submission
const submitLogin = () => {
    loginForm.post('/login', {
        onSuccess: () => isDrawerVisible.value = false,
        onError: () => ElMessage.error("লগইন ব্যর্থ হয়েছে!"),
    });
};

// Register Submission
const submitRegister = () => {
    registerForm.post('/register', {
        onSuccess: () => isDrawerVisible.value = false,
        onError: () => ElMessage.error("রেজিস্ট্রেশন ব্যর্থ হয়েছে!"),
    });
};
</script>

<template>
    <Head title="Checkout" />
    <FrontendLayout>
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-5">
            <h2 class="text-xl font-bold mb-4">আপনার পেমেন্ট কমপ্লিট করুন</h2>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Course Details -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                    <img v-if="course.thumbnail" :src="course.thumbnail" alt="Course Image" class="w-full object-cover rounded">
                    <h3 class="mt-4 font-semibold">{{ course.title }}</h3>
                    <table class="w-full border-collapse border border-gray-300 mt-2 text-sm">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 p-2 text-left">বিবরণ</th>
                                <th class="border border-gray-300 p-2 text-right">পরিমাণ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 p-2">কোর্সের মূল্য</td>
                                <td class="border border-gray-300 p-2 text-right">{{ course.price }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2">ডিসকাউন্ট ({{ course.discount }}%)</td>
                                <td class="border border-gray-300 p-2 text-right">- {{ discountAmount }}</td>
                            </tr>
                            <tr class="font-bold bg-gray-100">
                                <td class="border border-gray-300 p-2">মোট পেমেন্ট</td>
                                <td class="border border-gray-300 p-2 text-right">{{ totalPrice }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Payment Methods -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                    <h3 class="font-semibold mb-2">পেমেন্টের মাধ্যম</h3>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-200">
                            <input type="radio" v-model="selectedPaymentMethod" value="bKash" class="mr-2"> 
                            <img src="https://cdn.ostad.app/public/gateway/bkash-payment.png" alt="bKash" class="h-7">
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-200">
                            <input type="radio" v-model="selectedPaymentMethod" value="Nagad" class="mr-2"> 
                            <img src="https://seeklogo.com/images/N/nagad-logo-AA1B37DF1B-seeklogo.com.png" alt="Nagad" class="h-7">
                        </label>
                    </div>
                    <ElButton type="warning" class="mt-4 w-full" @click="handlePaymentClick">
                        পেমেন্ট সম্পন্ন করি
                    </ElButton>
                </div>
            </div>

            <p class="mt-4 text-sm text-gray-600">
                প্রয়োজনে কল করুন <span class="text-red-500">+8801763264270</span> (সকাল ১০টা থেকে রাত ১০টা)
            </p>
        </div>

        <!-- Login/Register Drawer -->
        <ElDrawer v-model="isDrawerVisible" title="লগইন বা রেজিস্ট্রেশন করুন" direction="rtl">
            <div class="p-4">
                <h3 class="text-lg font-bold text-gray-700 mb-2">
                    {{ isLoginMode ? 'লগইন করুন' : 'নতুন অ্যাকাউন্ট তৈরি করুন' }}
                </h3>

                <ElForm v-if="isLoginMode" @submit.prevent="submitLogin">
                    <ElFormItem label="ইমেইল">
                        <ElInput v-model="loginForm.email" type="email" placeholder="আপনার ইমেইল লিখুন" />
                    </ElFormItem>
                    <ElFormItem label="পাসওয়ার্ড">
                        <ElInput v-model="loginForm.password" type="password" placeholder="আপনার পাসওয়ার্ড লিখুন" />
                    </ElFormItem>
                    <ElButton type="primary" native-type="submit" class="w-full">লগইন করুন</ElButton>
                </ElForm>

                <ElForm v-else @submit.prevent="submitRegister">
                    <ElFormItem label="নাম">
                        <ElInput v-model="registerForm.name" placeholder="আপনার নাম লিখুন" />
                    </ElFormItem>
                    <ElFormItem label="ইমেইল">
                        <ElInput v-model="registerForm.email" type="email" placeholder="আপনার ইমেইল লিখুন" />
                    </ElFormItem>
                    <ElFormItem label="পাসওয়ার্ড">
                        <ElInput v-model="registerForm.password" type="password" placeholder="পাসওয়ার্ড লিখুন" />
                    </ElFormItem>
                    <ElFormItem label="পাসওয়ার্ড নিশ্চিত করুন">
                        <ElInput v-model="registerForm.password_confirmation" type="password" placeholder="আবার পাসওয়ার্ড লিখুন" />
                    </ElFormItem>
                    <ElButton type="primary" native-type="submit" class="w-full">রেজিস্ট্রেশন করুন</ElButton>
                </ElForm>
            </div>
        </ElDrawer>
    </FrontendLayout>
</template>
