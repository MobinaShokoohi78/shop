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
                        <h3 class="">ویژگی جدید</h3>
                    </div>
                    <form>
                        <div class="flex flex-row">
                            <div class="mb-6 basis-full ml-1">
                                <label for="name" class="block mb-2 text-sm font-medium" :class="errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                <input type="text" id="name" v-model="form.name" class="text-sm rounded-lg block w-full p-2.5" :class="errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                <div v-if="errors.name">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{errors.name}}</p>
                                </div>
                            </div>

                        </div>
                        <div class="w-3/4">
                            <p class="mb-4">مقادیر ویژگی</p>
                            <div id="values">
                                <div class="flex flex-row mb-4" v-for="(item,key) in form.values" :id="'row-'+key">
                                    <input type="text" :id="key" v-model="form.values[key]" class="text-sm w-3/4 rounded-lg block w-full p-2.5 ml-1" :class="errors.value ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'">
                                    <button type="submit" @click="deleteField(key)" class="w-1/4 mr-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">حذف</button>
                                </div>
                            </div>

                            <button @click="addField" class="mb-4 text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >فیلد جدید</button>
                        </div>

                        <button type="submit" @click="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >ثبت</button>
                        <a class=" mr-5 text-white bg-slate-700 hover:bg-Slate-800 focus:ring-4 focus:outline-none focus:ring-Slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                           :href="route('admin.attributes.index')">
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
import Button from "@/Components/Button";

export default {
    name: "create",
    components: {Button, Breadcrumb, DashboardAdmin},
    data(){
        return{
            form :useForm({
                name: '',
                values: {
                    'value-0' :''
                },
            }),

            rows: {

            },
            count: 0,

            errors:[],
            columnsSearch:[],

            data: {},

        }
    },
    methods:{
        submit(event){
            event.preventDefault();
            this.form.is_admin  = this.form.is_admin ? 1 : 0 ;
            this.form.post('/admin/attributes',{
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
        addField(event){
            event.preventDefault();

            this.count = ++this.count;

            let key = 'value-' + this.count;

            this.form.values[key] = '';
        },
        deleteField(key){

            let element =document.getElementById("row-"+key);
            element.remove();

            let values = { ...this.form.values };
            delete values[key];
            this.form.values = values;

        },

    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
