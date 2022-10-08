<template>
    <div class="flex" dir="rtl">

        <!--     sidebar       -->
        <Sidebar :show="show" :hover="hover" @toggle-menu="toggleMenu"></Sidebar>
        <!--     end sidebar       -->

        <div class="absolute inset-y-0 left-0 " :class="show ? 'w-10/12'  : 'w-full pr-24'">

            <!--            header                -->
            <div class="h-16 sticky bg-gray-100 shadow-md shadow-gray-200 px-3 box-border">
                <div class="my-auto flex justify-end">
                    <a class="text-gray-700 border border-gray-700 rounded p-3 hover:bg-gray-700 hover:text-gray-100 transition delay-100 left-0" href="#"> خروج</a>
                </div>
            </div>
            <!--            end header            -->


            <!--            content               -->
            <slot name="content" />
            <!--            end content           -->

        </div>

    </div>
</template>

<script setup>

    import { reactive,ref } from 'vue'
    import Sidebar from "@/Layouts/Admin/Sidebar";

    const show = ref(true);
    const hover = ref(false);

    function toggleMenu(){
        show.value = !show.value;
    }

</script>

<style scoped>

</style>
