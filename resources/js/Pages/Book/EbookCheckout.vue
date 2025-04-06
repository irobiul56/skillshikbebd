<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { ref } from "vue";
import { usePage, useForm, Head } from '@inertiajs/vue3';
import { ElInput, ElButton, ElForm, ElMessage } from 'element-plus';

const { props } = usePage();
const ebook = ref(props.ebook);

const selectedPaymentMethod = ref(""); // Default payment method
const transactionId = ref(""); // To store the transaction ID
const name = ref(""); // To store the name
const email = ref(""); // To store the email
const phone = ref(""); // To store the phone

// Initialize the form with default values
const form = useForm({
    ebook_id: ebook.value.id,
    payment_method: selectedPaymentMethod.value,
    transaction_id: transactionId.value,
    name: name.value,
    email: email.value,
    phone: phone.value,
    amount: ebook.value.price - ((ebook.value.price * ebook.value.discount) / 100),
});

// Handle form submission
const submitForm = () => {
    // Validate required fields
    if (!selectedPaymentMethod.value) {
        ElMessage.error('Please select a payment method.');
        return;
    }
    if (!transactionId.value) {
        ElMessage.error('Please enter the transaction ID.');
        return;
    }
    if (!name.value) {
        ElMessage.error('Please enter your name.');
        return;
    }
    if (!email.value) {
        ElMessage.error('Please enter your email.');
        return;
    }
    if (!phone.value) {
        ElMessage.error('Please enter your phone number.');
        return;
    }

    // Update the form data with the latest values
    form.payment_method = selectedPaymentMethod.value;
    form.transaction_id = transactionId.value;
    form.name = name.value;
    form.email = email.value;
    form.phone = phone.value;

    // Submit the form
    form.post(route('checkoutebook'), {
        onSuccess: () => {
            ElMessage.success('Order placed successfully!');
            // Optionally, you can redirect the user to a thank you page or clear the form
        },
        onError: (errors) => {
            ElMessage.error('There was an error submitting your order. Please try again.');
        },
    });
};
</script>

<template>
    <Head title="Checkout" />
    <FrontendLayout>
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-5">
            <h2 class="text-xl font-bold mb-4">আপনার পেমেন্ট কমপ্লিট করুন</h2>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- ebook Details -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                    <img v-if="ebook.thumbnail" :src="ebook.thumbnail" alt="ebook Image" class="w-full object-cover rounded">
                    <h3 class="mt-4 font-semibold">{{ ebook.title }}</h3>
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
                                <td class="border border-gray-300 p-2 text-right">{{ ebook.price }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2">ডিসকাউন্ট ({{ ebook.discount }}%)</td>
                                <td class="border border-gray-300 p-2 text-right">- {{ (ebook.price * ebook.discount)/100 }}</td>
                            </tr>
                            <tr class="font-bold bg-gray-100">
                                <td class="border border-gray-300 p-2">মোট পেমেন্ট</td>
                                <td class="border border-gray-300 p-2 text-right">{{ ebook.price - ((ebook.price * ebook.discount)/100) }}</td>
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
                        <div>
                            <label>Name:</label>
                            <ElInput v-model="name" placeholder="Enter your name" class="w-full"/>
                        </div>
                        <div>
                            <label>Email:</label>
                            <ElInput v-model="email" placeholder="Enter your email" class="w-full" />
                        </div>
                        <div>
                            <label>Phone:</label>
                            <ElInput v-model="phone" placeholder="Enter your phone" class="w-full"/>
                        </div>
                    </div>
                    <ElButton type="warning" native-type="submit" class="mt-4 w-full">
                        অর্ডার সম্পন্ন করুন
                    </ElButton>
                </ElForm>
            </div>

            <p class="mt-4 text-sm text-gray-600">
                প্রয়োজনে কল করুন <span class="text-red-500">+8801763264270</span> (সকাল ১০টা থেকে রাত ১০টা)
            </p>
        </div>
    </FrontendLayout>
</template>