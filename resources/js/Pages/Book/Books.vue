<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { usePage, useForm, Head, Link } from '@inertiajs/vue3';
import { ref, computed } from "vue";

const { props } = usePage();
const books = ref(props.books);

// State for controlling the modal
const isModalOpen = ref(false);
const selectedPdfUrl = ref('');

// Function to open the modal with the PDF URL
const openPdfModal = (pdfPath) => {
    selectedPdfUrl.value = '/storage/' + pdfPath; // Construct the full PDF URL
    isModalOpen.value = true;
};

// Function to close the modal
const closeModal = () => {
    isModalOpen.value = false;
    selectedPdfUrl.value = '';
};
</script>

<template>
    <Head title="E Books" />
    <FrontendLayout>
        <!-- Book List -->
        <div class="bg-gray-100 flex justify-center py-10" v-for="(book, index) in books" :key="index">
            <div class="grid grid-cols-12 gap-6 mt-5 max-w-6xl">
                <!-- Left Section - Book Image -->
                <div class="col-span-6 hidden md:flex">
                    <div class="w-[760px]">
                        <div class="aspect-w-4 aspect-h-3">
                            <img :src="'/storage/' + book.bookthum" alt="Book" class="object-cover">
                        </div>
                    </div>
                </div>

                <!-- Right Section - Book Details -->
                <div class="col-span-12 md:col-span-6">
                    <div class="relative flex flex-col rounded-[15px] mx-auto max-w-[387px] min-h-[400px] border-transparent bg-white shadow-lg">
                        <div class="rounded-[12px] overflow-hidden flex items-center justify-center">
                            <img :src="'/storage/' + book.thumbnail" alt="Book" class="object-cover">
                        </div>

                        <div class="p-5 flex flex-col gap-2 grow">
                            <div class="flex justify-between items-center font-bold">
                                <p class="text-xl font-semibold">{{ book.title }}</p>
                                <p class="flex gap-2">
                                    <span class="line-through text-gray-500 text-lg">{{ book.price }} টাকা</span>
                                    <span class="text-lg text-yellow-600 font-bold">{{ book.price - ((book.price * book.discount)/100) }} টাকা</span>
                                </p>
                            </div>

                            <div class="flex gap-4 mt-4">
                                <!-- Button to open the PDF modal -->
                                <button 
                                    @click="openPdfModal(book.ebookpdf)" 
                                    class="w-full text-lg font-semibold text-white hover:text-black bg-gradient-to-r from-yellow-500 to-orange-500 px-4 py-3 rounded-lg"
                                >
                                    ইবুকটি পড়ুন
                                </button>
                                <Link :href="route('ebookcheckout', book.slug)" target="_blank" class="w-full">
                                    <button class="w-full text-lg font-semibold text-black hover:bg-black hover:text-white border border-black px-4 py-3 rounded-lg">
                                        অর্ডার করুন
                                    </button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PDF Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg w-11/12 md:w-3/4 lg:w-1/2 h-3/4 overflow-hidden">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-semibold">Read PDF</h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>

                <!-- Modal Body - PDF Viewer -->
                <div class="h-full p-4">
                    <iframe 
                        :src="selectedPdfUrl" 
                        class="w-full h-full" 
                        frameborder="0"
                    ></iframe>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>