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
                                <label for="name" class="block mb-2 text-sm font-medium" :class="form.errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                <input type="text" id="name" v-model="form.name" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                <div v-if="form.errors.name">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{form.errors.name}}</p>
                                </div>
                            </div>

                        </div>
                        <div class="w-3/4">
                            <p class="mb-4">مقادیر ویژگی</p>
                            <div v-if="form.errors.values">
                                <p class="mb-2 text-sm text-red-600 dark:text-red-500"> {{form.errors.values}}</p>
                            </div>
                            <div id="values">
                                <div v-for="(item,key) in form.values">
                                    <div class="flex flex-row mb-4" :id="'row-'+key">
                                        <input type="text" :id="key" v-model="form.values[key].value"  class="text-sm rounded-lg block w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="submit" @click="deleteField(key)" class="w-1/4 mr-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">حذف</button>
                                    </div>
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

<script>

import { useForm } from '@inertiajs/inertia-vue3';
import DashboardAdmin from "@/Layouts/Admin/DashboardAdmin";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import SweetAlert from 'sweetalert2/dist/sweetalert2.js'
import Button from "@/Components/Button";

export default {
    name: "edit",
    components: {Button, Breadcrumb, DashboardAdmin},
    props:['attribute','values'],
    data(){
        return{
            form :useForm({
                name :'',
                values:{},
                errors: []
            }),
        }
    },
    mounted() {
        this.form =  useForm({
            name   : this.attribute.name,
            values : this.values,
            errors : []

        })
    },
    methods:{
        submit(event){
            event.preventDefault();
            this.form.put('/admin/attributes/'+ this.attribute.id,{
                onBefore: (visit) => {},
                onStart: (visit) => {},
                onProgress: (progress) => {},
                onSuccess: (page) => {
                    this.form =  useForm({
                        name   : page.props.attribute.name,
                        values : page.props.values,
                        errors : []

                    })
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

                },
                onError: (errors) => {},
                onCancel: () => {},
            })
        },
        addField(event){
            event.preventDefault();

            let x =  Math.random().toString(36).substring(2,7);
            this.form.values[x] = {'value' : ''};
        },
        deleteField(key){

            let element = document.getElementById("row-"+key);
            element.remove();

            let values = { ...this.form.values };
            delete values[key];
            this.form.values = values;

        },
    }
}
</script>

<style scoped>

</style>
