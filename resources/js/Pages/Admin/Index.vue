<template>
    <DashboardAdmin>

        <template #content>

            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6">

                <!--                breadcrumb                -->
                <Breadcrumb></Breadcrumb>
                <!--                breadcrumb                -->

                <!--                main content                   -->
<!--                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">-->

                    <DataTable
                        :api="route('dashboard')"
                    ></DataTable>

<!--                </div>-->
                <!--                end main content               -->

            </div>

        </template>

    </DashboardAdmin>
</template>

<script setup>
    import DashboardAdmin from "@/Layouts/Admin/DashboardAdmin";
    import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
    import DataTable from "@/Layouts/Admin/DataTable";

</script>

<style scoped>

</style>
