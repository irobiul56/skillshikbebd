<script setup>
import { ref } from 'vue';

</script>

<template>
  <section class="w-full pt-10 md:pt-16">
  <div class="w-full px-4 mx-auto sm:max-w-[540px] md:max-w-[720px] lg:max-w-[1150px] xl:max-w-[1150px]">
    <div class="flex flex-col items-center gap-3 p-0 md:p-4 bg-none md:bg-white md:rounded-2xl md:shadow-md overflow-hidden">
      <div class="flex items-center gap-2">
        <img class="w-10 h-10" src="https://cdn.ostad.app/public/upload/2023-08-07T04-54-15.325Z-broadcast-line-red.svg">
        <p class="text-lg md:text-2xl font-medium text-gray-800">আপকামিং লাইভ কোর্স</p>
      </div>
      
      <div class="w-full flex flex-col items-center gap-4 md:gap-6">
        <!-- Category tabs -->
        <div class="flex flex-col gap-6 w-full">
          <div class="relative">
            <div class="flex overflow-x-auto gap-3 pb-2 scrollbar-hide">
              <!-- Active category -->
              <div class="flex-shrink-0">
                <div class="group flex items-center gap-1.5 px-4 py-2 rounded-md bg-gray-800 border border-gray-700 cursor-pointer">
                  <div class="w-7 bg-white flex justify-center items-center rounded-full shadow-sm p-1.5">
                    <img class="w-4" src="https://cdn.ostad.app/public/upload/2023-06-22T06-40-41.054Z-code-box-line.png">
                  </div>
                  <div>
                    <p class="text-sm font-medium text-white">Web & App Development</p>
                    <p class="text-xs text-gray-400">• ৩২ কোর্স • ৫ ওয়ার্কশপ</p>
                  </div>
                </div>
              </div>
              
              <!-- Inactive categories -->
              <div class="flex-shrink-0">
                <div class="group flex items-center gap-1.5 px-4 py-2 rounded-md bg-gray-100 border border-gray-200 hover:bg-gray-200 hover:border-gray-300 cursor-pointer">
                  <div class="w-7 bg-white flex justify-center items-center rounded-full shadow-sm p-1.5">
                    <img class="w-4 filter brightness-0 group-hover:brightness-100 transition-all" src="https://cdn.ostad.app/public/upload/2023-06-07T09-55-30.105Z-product-design.png">
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-800 group-hover:underline">Product Management & Design</p>
                    <p class="text-xs text-gray-500">• ৮ কোর্স • ২ ওয়ার্কশপ</p>
                  </div>
                </div>
              </div>
              
              <!-- More category items... -->
            </div>
          </div>
          
          <!-- Course cards grid -->
          <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-3">
            <!-- Course card 1 -->
            <a href="/course/web-development-with-python-django" class="w-full h-full">
              <div class="relative flex flex-col w-full h-full bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-gray-300 hover:shadow-md transition-all">
                <div class="w-full aspect-video overflow-hidden">
                  <img src="https://cdn.ostad.app/course/cover/2024-12-19T15-48-52.487Z-Full-Stack-Web-Development-with-Python,-Django-&amp;-React.jpg" 
                       class="w-full h-full object-cover" loading="lazy" alt="Course thumbnail">
                </div>
                
                <div class="flex flex-wrap p-2 items-center gap-2 border-t border-b border-gray-200 bg-gray-100">
                  <div class="hidden sm:block">
                    <div class="flex items-center gap-1 px-2 py-1 rounded bg-gray-200">
                      <p class="text-xs text-gray-700">ব্যাচ ৫</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-1 px-2 py-1 rounded bg-gray-200">
                    <img class="w-3 h-3" src="https://cdn.ostad.app/public/icons/team-line.svg">
                    <p class="text-xs text-gray-700">৭৫ সিট বাকি</p>
                  </div>
                  <div class="flex items-center gap-1 px-2 py-1 rounded bg-gray-200">
                    <img class="w-3 h-3" src="https://cdn.ostad.app/public/icons/time-line.svg">
                    <p class="text-xs text-gray-700">১৭ দিন বাকি</p>
                  </div>
                </div>
                
                <div class="flex flex-col flex-grow justify-between">
                  <div class="p-2 md:p-4">
                    <p class="text-sm md:text-lg font-bold text-gray-900 line-clamp-3">Full Stack Web Development with Python, Django & React</p>
                  </div>
                  
                  <div class="w-full p-2 md:px-4 md:py-3 bg-none md:bg-gray-100">
                    <div class="sm:hidden">
                      <button class="w-full flex gap-2 justify-center items-center h-8 px-3 py-2 rounded bg-gray-200 hover:bg-gray-300 active:bg-gray-400 transition-all">
                        <p class="text-xs uppercase text-gray-900">বিস্তারিত দেখি</p>
                        <img class="w-5 h-5 filter invert brightness-0" src="https://cdn.ostad.app/public/icons/arrow-right-line.svg">
                      </button>
                    </div>
                    <div class="hidden sm:block">
                      <button class="w-full flex gap-2 justify-center items-center h-10 px-6 py-2 rounded-md bg-gray-200 hover:bg-gray-300 active:bg-gray-400 transition-all">
                        <p class="text-sm uppercase font-medium text-gray-900">বিস্তারিত দেখি</p>
                        <img class="w-5 h-5" src="https://cdn.ostad.app/public/icons/arrow-right-line.svg">
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            
            <!-- More course cards... -->
          </div>
          
          <!-- See all button -->
          <div class="flex justify-center">
            <div class="w-full max-w-[375px]">
              <a href="/category/web-and-app-development" class="w-full">
                <button class="w-full flex gap-2 justify-center items-center h-12 px-6 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 active:bg-gray-400 transition-all">
                  <p class="text-sm uppercase font-medium text-gray-900">সব দেখুন</p>
                  <img class="w-6 h-6" src="https://cdn.ostad.app/public/icons/arrow-right-line.svg">
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</template>