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
                        افزودن کاربر
                    </button>
                </div>

                <DataTable :api="route('admin.users.data')" ref="usersTable">
                    <template #is_admin="{id , item, prem}">
                        <span class="text-green-500" v-if="item == 1">کاربر ادمین</span>
                        <span class="text-red-500" v-else>کاربر معمولی</span>
                    </template>

                    <template #created_at="{id , item, prem}">
                    </template>

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
                <my-modal :modalId="addModalId" size="large">
                    <template #content>

                        <form>
                            <div class="flex flex-row">
                                <div class="mb-6 basis-1/2 ml-1">
                                    <label for="name" class="block mb-2 text-sm font-medium" :class="form.errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                    <input type="text" id="name" v-model="form.name" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                    <div v-if="form.errors.name">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{form.errors.name}}</p>
                                    </div>
                                </div>
                                <div class="mb-6 basis-1/2 mr-1">
                                    <label for="email" class="block mb-2 text-sm font-medium" :class="form.errors.email ? 'text-red-700' : 'text-gray-900'">ایمیل</label>
                                    <input type="email" id="email" v-model="form.email" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.email ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="name@gmail.com"  >
                                    <div v-if="form.errors.email">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{form.errors.email}}</p>
                                    </div>
                                </div>

                            </div><div class="flex flex-row">

                            <div class="mb-6 basis-1/2 ml-1">
                                <label for="password" class="block mb-2 text-sm font-medium" :class="form.errors.password ? 'text-red-700' : 'text-gray-900'">پسورد</label>
                                <input type="password" id="password" v-model="form.password" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.password ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'"  >
                                <div v-if="form.errors.password">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{form.errors.password}}</p>
                                </div>
                            </div>
                            <div class="mb-6 basis-1/2 mr-1">
                                <label for="password" class="block mb-2 text-sm font-medium" :class="form.errors.password_confirmation ? 'text-red-700' : 'text-gray-900'">تکرار پسورد</label>
                                <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.password_confirmation ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'"  >
                            </div>
                        </div>
                            <div class="flex items-start mb-6">
                                <div class="flex items-center h-5">
                                    <input id="remember" type="checkbox" value="" v-model="form.is_admin" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300">
                                </div>
                                <label for="remember" class="mr-2 text-sm font-medium text-gray-900">کاربر ادمین</label>
                            </div>
                        </form>

                    </template>
                    <template #buttons>
                        <button type="submit" @click="addUser" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >ثبت</button>
                    </template>
                </my-modal>

                <my-modal :modalId="editModalId" size="large">
                    <template #content>
                        <form>
                            <div class="flex flex-row">
                                <div class="mb-6 basis-1/2 ml-1">
                                    <label for="edit_name" class="block mb-2 text-sm font-medium" :class="editForm.errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                    <input type="text" id="edit_name" v-model="editForm.name" class="text-sm rounded-lg block w-full p-2.5" :class="editForm.errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                    <div v-if="editForm.errors.name">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{editForm.errors.name}}</p>
                                    </div>
                                </div>
                                <div class="mb-6 basis-1/2 mr-1">
                                    <label for="edit_email" class="block mb-2 text-sm font-medium" :class="editForm.errors.email ? 'text-red-700' : 'text-gray-900'">ایمیل</label>
                                    <input type="email" id="edit_email" v-model="editForm.email" class="text-sm rounded-lg block w-full p-2.5" :class="editForm.errors.email ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="name@gmail.com"  >
                                    <div v-if="editForm.errors.email">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{editForm.errors.email}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row">
                            <div class="mb-6 basis-1/2 ml-1">
                                <label for="edit_password" class="block mb-2 text-sm font-medium" :class="editForm.errors.password ? 'text-red-700' : 'text-gray-900'">پسورد</label>
                                <input type="password" id="edit_password" v-model="editForm.password" class="text-sm rounded-lg block w-full p-2.5" :class="editForm.errors.password ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'"  >
                                <div v-if="editForm.errors.password">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{editForm.errors.password}}</p>
                                </div>
                            </div>
                            <div class="mb-6 basis-1/2 mr-1">
                                <label for="edit_password" class="block mb-2 text-sm font-medium" :class="editForm.errors.password_confirmation ? 'text-red-700' : 'text-gray-900'">تکرار پسورد</label>
                                <input type="password" id="edit_password_confirmation" v-model="editForm.password_confirmation" class="text-sm rounded-lg block w-full p-2.5" :class="editForm.errors.password_confirmation ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'"  >
                            </div>
                        </div>
                            <div class="flex items-start mb-6">
                                <div class="flex items-center h-5">
                                    <input id="edit_remember" type="checkbox" value="" v-model="editForm.is_admin" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300">
                                </div>
                                <label for="edit_remember" class="mr-2 text-sm font-medium text-gray-900">کاربر ادمین</label>
                            </div>
                        </form>
                    </template>
                    <template #buttons>
                        <button type="submit" @click="editUser" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >ثبت</button>
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
                editModalId: 'editUsersModal',
                addModalId: 'addUsersModal',

                form :useForm({
                    name:'',
                    email:'',
                    password:'',
                    password_confirmation:'',
                    is_admin:false,
                    errors:[]
                }),

                editForm :useForm({
                    id:'',
                    name:'',
                    email:'',
                    password:'',
                    password_confirmation:'',
                    is_admin:false,
                    errors:[]
                }),

                currentUrl: window.location.href,

                data: {},

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

                                this.$refs.usersTable.getData();
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
            addUser(event){
                event.preventDefault();
                this.form.is_admin  = this.form.is_admin ? 1 : 0 ;
                this.form.post('/admin/users',{
                    onBefore: (visit) => {},
                    onStart: (visit) => {},
                    onProgress: (progress) => {},
                    onSuccess: () => {

                        const targetEl = document.getElementById(this.addModalId);
                        const modal = new Modal( targetEl );
                        modal.hide();

                        this.$refs.usersTable.getData();

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
                            title: 'کاربر با موفقیت ثبت شد!'
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
                        this.editForm.email = data.email;
                        this.editForm.is_admin = data.is_admin == 1 ? true : false;
                    }
                )
            },
            editUser(event){
                event.preventDefault();
                this.editForm.is_admin  = this.editForm.is_admin ? 1 : 0 ;
                this.editForm.put(this.currentUrl+ '/' + this.editForm.id ,{
                    onBefore: (visit) => {},
                    onStart: (visit) => {},
                    onProgress: (progress) => {},
                    onSuccess: (data) => {
                        const targetEl = document.getElementById(this.editModalId);
                        const modal = new Modal( targetEl );
                        modal.hide();

                        this.$refs.usersTable.getData();

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
                            title: 'کاربر با موفقیت ویرایش شد!'
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
