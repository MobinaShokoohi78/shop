<template xmlns="http://www.w3.org/1999/html">
    <DashboardAdmin>

        <template #content>

            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6">

                <!--                breadcrumb                -->
                <Breadcrumb></Breadcrumb>
                <!--                breadcrumb                -->

                <!--                main content                   -->
                <div class="flex flex-row-reverse m-4">
                    <Link class ="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                        :href="route('admin.products.create')">
                        افزودن محصول
                    </Link>
                </div>

                <DataTable :api="route('admin.products.data')" ref="attributesTable">
                    <template #action="{id , item, prem}">
                        <a v-if="prem.update"
                            :href="route(prem.update,id)"
                             title="ویرایش"
                             class="mx-4 font-medium transition hover:scale-125 ease-in-out duration-150 w-5 h-5">
                            <i class='fa-solid fa-pen-to-square fa-lg text-green-500'></i>
                        </a>

                        <button v-if="prem.delete"
                            @click="remove(id)"
                            title="حذف"
                            :id="id"
                            class=" mx-4 w-5 h-5 font-medium transition hover:scale-125 ease-in-out duration-150">
                            <i class="fa-solid fa-trash-can fa-lg text-red-500"></i>
                        </button>
                    </template>
                </DataTable>
                <!--                end main content               -->

            </div>

        </template>

    </DashboardAdmin>
</template>

<script>

    import { Link } from '@inertiajs/inertia-vue3';
    import DashboardAdmin from "@/Layouts/Admin/DashboardAdmin";
    import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
    import DataTable from "@/Layouts/Admin/DataTable";
    import Button from "@/Components/Button";
    import {Inertia} from "@inertiajs/inertia";
    import SweetAlert from 'sweetalert2/dist/sweetalert2.js';

    export default {
        name: "all",
        components:{Button,DashboardAdmin,Breadcrumb,DataTable,Link},
        data(){
            return {
                currentUrl: window.location.href,
            }
        },
        methods:{
            remove(id){
                SweetAlert.fire({
                    title: 'آیا مایل به حذف این گزینه هستید؟',
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'بله',
                    denyButtonText: `خیر`,
                    confirmButtonColor:'#22c55e',
                    denyButtonColor:'#ef4444',
                }).then((result) => {

                    if (result.isConfirmed) {
                        Inertia.delete(this.currentUrl + '/' + id,{
                            onBefore: (visit) => {},
                            onStart: (visit) => {},
                            onProgress: (progress) => {},
                            onSuccess: (page) => {
                                const Toast = SweetAlert.mixin({
                                    toast: true,
                                    position: 'top-start',
                                    showConfirmButton: false,
                                    timer: 4000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', SweetAlert.stopTimer)
                                        toast.addEventListener('mouseleave', SweetAlert.resumeTimer)
                                    }
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: 'اطلاعات با موفقیت حذف شد!'
                                });

                                this.$refs.attributesTable.getData();
                            },
                            onError: (errors) => {
                                console.log(errors);

                                const Toast = SweetAlert.mixin({
                                    toast: true,
                                    position: 'top-start',
                                    showConfirmButton: false,
                                    timer: 4000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', SweetAlert.stopTimer)
                                        toast.addEventListener('mouseleave', SweetAlert.resumeTimer)
                                    }
                                });

                                Toast.fire({
                                    icon: 'error',
                                    title: 'حذف اطلاعات با مشکل مواجه شد!'
                                });
                            },
                            onCancel: () => {},
                            onFinish: visit => {
                                this.getData();
                            },
                        });
                    } else if (result.isDenied) {

                    }
                })
            },
        }
    }
</script>

<style scoped>

</style>
