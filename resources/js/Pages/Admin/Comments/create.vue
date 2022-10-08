<template>

    <DashboardAdmin>

        <template #content>

            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6">

                <!--                breadcrumb                -->
                <breadcrumb></breadcrumb>
                <!--                breadcrumb                -->

                <!--                main content                   -->
                <div class="p-7 relative overflow-x-auto shadow-md sm:rounded-lg mt-6">

                    <div class="mb-5">
                        <h2 class="">کاربر جدید</h2>
                    </div>
                    <form>
                        <div class="flex flex-row">
                            <div class="mb-6 basis-1/2 ml-1">
                                <label for="name" class="block mb-2 text-sm font-medium" :class="errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                <input type="text" id="name" v-model="form.name" class="text-sm rounded-lg block w-full p-2.5" :class="errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                <div v-if="errors.name">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{errors.name}}</p>
                                </div>
                            </div>
                            <div class="mb-6 basis-1/2 mr-1">
                                <label for="email" class="block mb-2 text-sm font-medium" :class="errors.email ? 'text-red-700' : 'text-gray-900'">ایمیل</label>
                                <input type="email" id="email" v-model="form.email" class="text-sm rounded-lg block w-full p-2.5" :class="errors.email ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="name@gmail.com"  >
                                <div v-if="errors.email">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{errors.email}}</p>
                                </div>
                            </div>

                        </div><div class="flex flex-row">

                            <div class="mb-6 basis-1/2 ml-1">
                                <label for="password" class="block mb-2 text-sm font-medium" :class="errors.password ? 'text-red-700' : 'text-gray-900'">پسورد</label>
                                <input type="password" id="password" v-model="form.password" class="text-sm rounded-lg block w-full p-2.5" :class="errors.password ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'"  >
                                <div v-if="errors.password">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{errors.password}}</p>
                                </div>
                            </div>
                            <div class="mb-6 basis-1/2 mr-1">
                                <label for="password" class="block mb-2 text-sm font-medium" :class="errors.password_confirmation ? 'text-red-700' : 'text-gray-900'">تکرار پسورد</label>
                                <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="text-sm rounded-lg block w-full p-2.5" :class="errors.password_confirmation ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'"  >
                            </div>
                        </div>
                        <div class="flex items-start mb-6">
                            <div class="flex items-center h-5">
                                <input id="remember" type="checkbox" value="" v-model="form.is_admin" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300">
                            </div>
                            <label for="remember" class="mr-2 text-sm font-medium text-gray-900">کاربر ادمین</label>
                        </div>
                        <button type="submit" @click="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >ثبت</button>
                        <a class=" mr-5 text-white bg-slate-700 hover:bg-Slate-800 focus:ring-4 focus:outline-none focus:ring-Slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                           :href="route('admin.users.index')">
                            لغو
                        </a>
                    </form>

                </div>
                <!--                end main content               -->

            </div>

        </template>

    </DashboardAdmin>

</template>

<script >

import { useForm } from '@inertiajs/inertia-vue3';
import DashboardAdmin from "@/Layouts/Admin/DashboardAdmin";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import SweetAlert from 'sweetalert2/dist/sweetalert2.js'

export default {
    name: "create",
    components: {Breadcrumb, DashboardAdmin},
    data(){
        return{
            form :useForm({
                name:'',
                email:'',
                password:'',
                password_confirmation:'',
                is_admin:false,
            }),

            errors:[],
            columnsSearch:[],

            data: {},

        }
    },
    methods:{
        submit(event){
            event.preventDefault();
            this.form.is_admin  = this.form.is_admin ? 1 : 0 ;
            this.form.post('/admin/users',{
                onBefore: (visit) => {},
                onStart: (visit) => {},
                onProgress: (progress) => {},
                onSuccess: () => {
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

                    this.errors = [];
                },
                onError: (errors) => {
                    this.errors = errors;
                },
                onCancel: () => {},
            })
        },

    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
