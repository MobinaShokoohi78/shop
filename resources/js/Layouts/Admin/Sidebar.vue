<template>
    <div class=" fixed p-5 bg-gray-800 p-5 text-indigo-100 inset-y-0 right-0 z-10 hover:w-2/12" :class="show ? ' w-2/12' : 'w-20'" aria-label="Sidebar" @mouseenter="hover = true" @mouseleave="hover = false">

        <div class="flex justify-between pb-7">
            <div class="text-indigo-100" v-if="hover || show" >
                داشبورد
            </div>

            <div>
                <div class="text-indigo-100 w-5 h-5 transition hover:scale-125 ease-in-out duration-150 mr-2 " @click="$emit('toggle-menu')" v-if="show">
                    <i class="fa-solid fa-angles-right fa-xl fill-indigo-50"></i>
                </div>

                <div class="text-indigo-100 w-5 h-5 transition hover:scale-125 ease-in-out duration-150 mr-2" @click="$emit('toggle-menu')" v-if="!show" >
                    <i class="fa-solid fa-angles-left fa-xl fill-indigo-50"></i>
                </div>
            </div>
        </div>

        <ul class="space-y-2">
            <li>
                <div class="flex items-center p-2 w-full text-base font-normal text-gray-500 rounded-lg transition duration-75 group text-white fill-gray-500">
                    <span v-if="hover || show" class="text-gray-500 text-lg	">فرم ها</span>
                    <i v-else class="fa-solid fa-ellipsis fa-xl flex-shrink-0 w-6 h-6 transition duration-75"></i>
                </div>
            </li>
            <li>
                <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-100 rounded-lg transition duration-75 group hover:bg-gray-100 text-white hover:bg-gray-700 fill-gray-100" aria-controls="dropdown-user" data-collapse-toggle="dropdown-user">
                    <i class="fa-solid fa-users fa-lg flex-shrink-0 transition duration-75 group-hover:text-gray-100"></i>
                    <span v-if="hover || show" class="flex-1 mr-3 text-right whitespace-nowrap">کاربران</span>
                    <i v-if="hover || show" class="fa-solid fa-angle-down fa-lg"></i>
                </button>
                <ul v-show="hover || show" id="dropdown-user" class="mr-3 hidden py-2 space-y-2"  >
                    <li>
                        <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 text-white hover:bg-gray-700">کاربر جدید</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 text-white hover:bg-gray-700">لیست کاربران</a>
                    </li>

                </ul>
            </li>

        </ul>

    </div>
</template>

<script setup>

    defineProps(['show','hover'])
    defineEmits(['toggle-menu'])

</script>

<style scoped>

</style>
