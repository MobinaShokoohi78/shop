<template>
    <DashboardAdmin>

        <template #content>
            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6">
                <!--                breadcrumb                -->
                <Breadcrumb></Breadcrumb>
                <!--                breadcrumb                -->

                <!--                main content                   -->
                <div class="flex flex-row-reverse m-4">
                    <button :data-modal-toggle="addModalId" class ="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        افزودن سایز
                    </button>
                </div>

                <DataTable :api="route('admin.sizes.data')" ref="sizesTable">
                    <template #action="{id , item, prem}">
                        <button v-if="prem.update"
                            :data-modal-toggle="editModalId"
                            @click="showEditForm(id)"
                            title="ویرایش"
                            :id="id"
                            class="mx-4 font-medium transition hover:scale-125 ease-in-out duration-150 w-5 h-5">
                            <i class="fa-solid fa-pen-to-square fa-lg text-green-500"></i>
                        </button>

                        <button
                            v-if="prem.update"
                            @click="remove(id)"
                            title="حذف"
                            :id="id"
                            class=" mx-4 w-5 h-5 font-medium transition hover:scale-125 ease-in-out duration-150">
                            <i class="fa-solid fa-trash-can fa-lg text-red-500"></i>
                        </button>
                    </template>
                </DataTable>
                <!--                end main content               -->

                <!--                modals content               -->
                <my-modal :modalId="addModalId" size="medium">
                    <template #content>
                        <form>
                            <div class="flex flex-row">
                                <div class="mb-6 basis-full ml-1">
                                    <label for="name" class="block mb-2 text-sm font-medium" :class="form.errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                    <input type="text" id="name" v-model="form.name" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                    <div v-if="form.errors.name">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{form.errors.name}}</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </template>
                    <template #buttons>
                        <button type="submit" @click="addSize" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >ثبت</button>
                    </template>
                </my-modal>

                <my-modal :modalId="editModalId" size="medium">
                    <template #content>
                        <form>
                            <div class="flex flex-row">
                                <div class="mb-6 basis-full ml-1">
                                    <label for="edit-name" class="block mb-2 text-sm font-medium" :class="editForm.errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                    <input type="text" id="edit-name" v-model="editForm.name" class="text-sm rounded-lg block w-full p-2.5" :class="editForm.errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                    <div v-if="editForm.errors.name">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{editForm.errors.name}}</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </template>
                    <template #buttons>
                        <button type="submit" @click="editSize" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >ثبت</button>
                    </template>
                </my-modal>
                <!--                end modals content               -->
            </div>

        </template>

    </DashboardAdmin>
</template>

<script>

    import {Link, useForm} from '@inertiajs/inertia-vue3';
    import DashboardAdmin from "@/Layouts/Admin/DashboardAdmin";
    import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
    import DataTable from "@/Layouts/Admin/DataTable";
    import {Inertia} from "@inertiajs/inertia";
    import SweetAlert from 'sweetalert2/dist/sweetalert2.js';
    import MyModal from "@/Layouts/Admin/MyModal";
    import Button from "@/Components/Button";

    export default {
        name: "all",
        components:{Button, Link,DashboardAdmin,Breadcrumb,DataTable,MyModal},
        data(){
            return{
                editModalId: 'editSizesModal',
                addModalId: 'addSizesModal',

                form :useForm({
                    name:'',
                    errors:[]
                }),

                editForm :useForm({
                    id:'',
                    name:'',
                    errors:[]
                }),

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

                                this.$refs.sizesTable.getData();
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
            addSize(event){
                event.preventDefault();
                this.form.post(this.currentUrl,{
                    onBefore: (visit) => {},
                    onStart: (visit) => {},
                    onProgress: (progress) => {},
                    onSuccess: () => {
                        const targetEl = document.getElementById(this.addModalId);
                        const modal = new Modal( targetEl );
                        modal.hide();
                        targetEl.setAttribute("aria-hidden", true);
                        targetEl.removeAttribute("role");
                        let tag = document.getElementsByClassName('bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40');
                        let len = tag.length;
                        if (len > 0) {
                            for (let i = 0; i < len; i++) {
                                tag[0].remove();
                            }
                        }

                        this.$refs.sizesTable.getData();

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
                            title: 'اطلاعات با موفقیت ثبت شد!'
                        });

                        this.form.errors = [];
                    },
                    onError: (errors) => {
                        this.form.errors = errors;
                    },
                    onCancel: () => {},
                })
            },
            showEditForm(id){
                const targetEl = document.getElementById(this.editModalId);
                const modal = new Modal( targetEl );
                modal.show();

                axios.get(this.currentUrl + '/' + id).then(
                    (response)=>{
                        let data = response.data;
                        this.editForm.id = data.id;
                        this.editForm.name = data.name;
                    }
                )
            },
            editSize(event){
                event.preventDefault();
                this.editForm.put(this.currentUrl+ '/' + this.editForm.id ,{
                    onBefore: (visit) => {},
                    onStart: (visit) => {},
                    onProgress: (progress) => {},
                    onSuccess: (data) => {
                        const targetEl = document.getElementById(this.editModalId);
                        const modal = new Modal( targetEl );
                        modal.hide();
                        targetEl.setAttribute("aria-hidden", true);
                        targetEl.removeAttribute("role");
                        let a = document.getElementsByClassName('bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40');
                        console.log(a)
                        a[0].remove();

                        this.$refs.sizesTable.getData();

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
                            title: 'اطلاعات با موفقیت ویرایش شد!'
                        });

                        this.editForm.errors = [];
                    },
                    onError: (errors) => {
                        this.editForm.errors = errors;
                    },
                    onCancel: () => {},
                })
            }
        },
        mounted() {

        }
    }

</script>

<style scoped>

</style>
