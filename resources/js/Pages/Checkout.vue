<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { ref, computed } from "vue";
import { usePage, useForm, Head } from '@inertiajs/vue3';
import { ElDrawer, ElInput, ElButton, ElForm, ElFormItem, ElMessage } from 'element-plus';

// Reactive props from Inertia
const page = usePage();
const course = computed(() => page.props.courses);
const isAuthenticated = computed(() => usePage().props.auth.user);

// Drawer and form state
const isDrawerVisible = ref(false);
const isLoginMode = ref(true); // Toggle Login/Register
const selectedPaymentMethod = ref(""); // Default payment method
const transactionId = ref(""); // To store the transaction ID

// Computed Pricing
const discountAmount = computed(() => ((course.value.price * course.value.discount) / 100).toFixed(2));
const totalPrice = computed(() => (course.value.price - discountAmount.value).toFixed(2));

// Login Form
const loginForm = useForm({ email: '', password: '' });

// Register Form
const registerForm = useForm({ name: '', email: '', password: '', password_confirmation: '' });

// Handle Payment Click
// Initialize the form with default values
const form = useForm({
    course_id: course.value.id,
    payment_method: selectedPaymentMethod.value,
    transaction_id: transactionId.value,
    totalPrice: totalPrice,
});

// Handle Payment Click
const submitForm = () => {
    // Check if user is authenticated
    if (!isAuthenticated.value) {
        isDrawerVisible.value = true; // Show login/register drawer
        ElMessage.warning('Please login or register to complete your order.');
        return; // Stop further execution
    }

    // Validate required fields (only if authenticated)
    if (!selectedPaymentMethod.value) {
        ElMessage.error('Please select a payment method.');
        return;
    }
    if (!transactionId.value) {
        ElMessage.error('Please enter the transaction ID.');
        return;
    }

    // Update the form data with the latest values
    form.course_id = course.value.id;
    form.totalPrice = totalPrice; // Note: added .value here
    form.payment_method = selectedPaymentMethod.value;
    form.transaction_id = transactionId.value;

    // Submit the form
    form.post(route('checkoutcourse'), {
        onSuccess: () => {
            ElMessage.success('Order placed successfully!');
            // Optionally, you can redirect the user to a thank you page or clear the form
        },
        onError: (errors) => {
            ElMessage.error('There was an error submitting your order. Please try again.');
        },
    });
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
                <ElForm @submit.prevent="submitForm" class="bg-gray-50 p-4 rounded-lg shadow-md">
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
                        <div v-if="selectedPaymentMethod === 'bKash'">
                            <p>Send money via <span class="text-blue-800">BKash (Personal)</span> to this number <span class="text-blue-800">01884612917</span>  and enter the transaction ID in the box below.</p>
                            <ElInput v-model="transactionId" placeholder="Enter Transaction Id"/>
                        </div>
                        <div v-if="selectedPaymentMethod === 'Nagad'">
                            <p>Send money via <span class="text-blue-800">Nagad (Personal)</span> to this number <span class="text-blue-800">01884612917</span>  and enter the transaction ID in the box below.</p>
                            <ElInput v-model="transactionId" placeholder="Enter Transaction Id" class="w-full"/>
                        </div>
                    </div>
                    <ElButton type="warning" native-type="submit" class="mt-4 w-full" :loading="submitForm.processing">
                        অর্ডার সম্পন্ন করুন
                    </ElButton>
                </ElForm>

            </div>

            <p class="mt-4 text-sm text-gray-600">
                প্রয়োজনে কল করুন <span class="text-red-500">+8801763264270</span> (সকাল ১০টা থেকে রাত ১০টা)
            </p>
        </div>

        <!-- Login/Register Drawer -->
        <ElDrawer 
  v-model="isDrawerVisible" 
  title="লগইন বা রেজিস্ট্রেশন করুন" 
  direction="rtl"
  size="400px"
  class="auth-drawer"
>
  <div class="p-6">
    <!-- Toggle Buttons -->
    <div class="flex justify-center mb-6">
      <div class="inline-flex bg-gray-100 rounded-lg p-1">
        <button
          @click="isLoginMode = true"
          :class="{'bg-white shadow-sm': isLoginMode, 'text-gray-500': !isLoginMode}"
          class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none transition-colors"
        >
          লগইন
        </button>
        <button
          @click="isLoginMode = false"
          :class="{'bg-white shadow-sm': !isLoginMode, 'text-gray-500': isLoginMode}"
          class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none transition-colors"
        >
          রেজিস্ট্রেশন
        </button>
      </div>
    </div>

    <!-- Login Form -->
    <div v-if="isLoginMode" class="space-y-6">
      <h3 class="text-xl font-bold text-center text-gray-800">আপনার অ্যাকাউন্টে লগইন করুন</h3>
      
      <ElForm @submit.prevent="submitLogin" class="space-y-6">
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">ইমেইল</label>
          <ElInput 
            v-model="loginForm.email" 
            type="email" 
            placeholder="আপনার ইমেইল লিখুন"
            size="large"
            class="w-full"
          />
        </div>
        
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">পাসওয়ার্ড</label>
          <ElInput 
            v-model="loginForm.password" 
            type="password" 
            placeholder="আপনার পাসওয়ার্ড লিখুন"
            size="large"
            class="w-full"
            show-password
          />
        </div>
        
        <div class="pt-2">
          <ElButton 
            type="primary" 
            native-type="submit" 
            class="w-full h-12"
            :loading="loginForm.processing"
          >
            লগইন করুন
          </ElButton>
        </div>
      </ElForm>
      
      <div class="text-center text-sm text-gray-600">
        অ্যাকাউন্ট নেই? 
        <button @click="isLoginMode = false" class="text-blue-600 hover:underline">
          রেজিস্ট্রেশন করুন
        </button>
      </div>
    </div>

    <!-- Registration Form -->
    <div v-else class="space-y-6">
      <h3 class="text-xl font-bold text-center text-gray-800">নতুন অ্যাকাউন্ট তৈরি করুন</h3>
      
      <ElForm @submit.prevent="submitRegister" class="space-y-6">
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">পূর্ণ নাম</label>
          <ElInput 
            v-model="registerForm.name" 
            placeholder="আপনার পূর্ণ নাম লিখুন"
            size="large"
            class="w-full"
          />
        </div>
        
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">ইমেইল</label>
          <ElInput 
            v-model="registerForm.email" 
            type="email" 
            placeholder="আপনার ইমেইল লিখুন"
            size="large"
            class="w-full"
          />
        </div>
        
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">পাসওয়ার্ড</label>
          <ElInput 
            v-model="registerForm.password" 
            type="password" 
            placeholder="পাসওয়ার্ড লিখুন (ন্যূনতম ৮ অক্ষর)"
            size="large"
            class="w-full"
            show-password
          />
        </div>
        
        <div class="space-y-1">
          <label class="block text-sm font-medium text-gray-700">পাসওয়ার্ড নিশ্চিত করুন</label>
          <ElInput 
            v-model="registerForm.password_confirmation" 
            type="password" 
            placeholder="আবার পাসওয়ার্ড লিখুন"
            size="large"
            class="w-full"
            show-password
          />
        </div>
        
        <div class="pt-2">
          <ElButton 
            type="primary" 
            native-type="submit" 
            class="w-full h-12"
            :loading="registerForm.processing"
          >
            রেজিস্ট্রেশন করুন
          </ElButton>
        </div>
      </ElForm>
      
      <div class="text-center text-sm text-gray-600">
        ইতিমধ্যে অ্যাকাউন্ট আছে? 
        <button @click="isLoginMode = true" class="text-blue-600 hover:underline">
          লগইন করুন
        </button>
      </div>
    </div>
  </div>
</ElDrawer>

    </FrontendLayout>
</template>
<style scoped>
.auth-drawer .el-drawer__header {
  @apply border-b border-gray-200 mb-0 p-4;
}

.auth-drawer .el-drawer__body {
  @apply p-0;
}

.auth-drawer .el-form-item__label {
  @apply block text-sm font-medium text-gray-700 mb-1;
}

.auth-drawer .el-input__wrapper {
  @apply !rounded-lg !h-12;
}

.auth-drawer .el-button {
  @apply !rounded-lg;
}
</style>

