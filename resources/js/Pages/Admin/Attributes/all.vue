<template>
    <DashboardAdmin>

        <template #content>

            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6">

                <!--                breadcrumb                -->
                <Breadcrumb></Breadcrumb>
                <!--                breadcrumb                -->

                <!--                main content                   -->
                <div class="flex flex-row-reverse m-4">
                    <Link class ="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                        :href="route('admin.attributes.create')">
                        افزودن ویژگی
                    </Link>
                </div>

                <DataTable :api="route('admin.attributes.data')">

                    <template #action="{id , item, perm}">

                    </template>

                </DataTable>

                <!--                end main content               -->

            </div>

        </template>

    </DashboardAdmin>
</template>

<script setup>

    import { Link } from '@inertiajs/inertia-vue3';
    import DashboardAdmin from "@/Layouts/Admin/DashboardAdmin";
    import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
    import DataTable from "@/Layouts/Admin/DataTable";


</script>

<style scoped>

</style>
