<template>
    <DashboardAdmin>

        <template #content>

            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6">

                <!--                breadcrumb                -->
                <Breadcrumb></Breadcrumb>
                <!--                breadcrumb                -->

                <!--                main content                   -->

                <DataTable :api="route('admin.comments.data')">

                    <template #created_at="{id , item, perm}">

                    </template>

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
