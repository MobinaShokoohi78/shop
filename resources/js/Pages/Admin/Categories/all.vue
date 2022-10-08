<template>
    <DashboardAdmin>

        <template #content>

            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6">

                <!--                breadcrumb                -->
                <Breadcrumb></Breadcrumb>
                <!--                breadcrumb                -->


                <!--                main content                   -->
                <nested-table
                    :data="data"
                    :editModalId= "editModalId"
                    :addModalId= "addModalId"
                ></nested-table>

                <pagination :pages="pages" v-model="currentPage"></pagination>

                <my-modal :modalId="editModalId" size="default">
                    <template #content>

                        <div class="flex flex-row">
                            <div class="mb-6 basis-full ml-1">
                                <label for="editName" class="block mb-2 text-sm font-medium" :class="editForm.errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                <input type="text" id="editName" v-model="editForm.name" class="text-sm rounded-lg block w-full p-2.5" :class="editForm.errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                <div v-if="editForm.errors.name">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{editForm.errors.name}}</p>
                                </div>
                            </div>
                        </div>

                    </template>
                    <template #buttons>
<!--                        :data-modal-toggle="editModalId"-->

                        <button
                            @click="editCategory"
                            type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            ذخیره
                        </button>
                    </template>
                </my-modal>

                <my-modal :modalId="addModalId" size="default">
                    <template #content>

                        <div class="flex flex-row">
                            <div class="mb-6 basis-full ml-1">
                                <label for="name" class="block mb-2 text-sm font-medium" :class="addForm.errors.name ? 'text-red-700' : 'text-gray-900'">نام</label>
                                <input type="text" id="name" v-model="addForm.name" class="text-sm rounded-lg block w-full p-2.5" :class="addForm.errors.name ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="نام"  >
                                <div v-if="addForm.errors.name">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{addForm.errors.name}}</p>
                                </div>
                            </div>
                        </div>

                    </template>
                    <template #buttons>
                        <button type="submit" @click="addCategory" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" >ثبت</button>
                    </template>
                </my-modal>
                <!--                end main content               -->

            </div>

        </template>

    </DashboardAdmin>
</template>

<script>

import {Link, useForm} from '@inertiajs/inertia-vue3';
import DashboardAdmin from "@/Layouts/Admin/DashboardAdmin";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import NestedTable from "@/Layouts/Admin/NestedTable";
import Pagination from "@/Layouts/Admin/Pagination";
import MyModal from "@/Layouts/Admin/MyModal";
import SweetAlert from 'sweetalert2/dist/sweetalert2.js'

export default {
    name: "all",
    components: {Breadcrumb, DashboardAdmin, Link, NestedTable, Pagination, MyModal},
    props:['categories', 'pages', 'currentPage'],
    inject: ['emitter'],
    data(){
        return{
            currentUrl: window.location.href,

            data: '',

            editModalId: 'editCategoriesModal',
            addModalId: 'addCategoriesModal',

            addForm :useForm({
                id: '',
                parent: '',
                name: '',
            }),
            editForm :useForm({
                id: '',
                parent: '',
                name: '',
            }),
        }
    },
    methods:{
        refreshData(){
            axios.post('./categories/data',{
                currentPage : this.currentPage,
                }).then((response) => {
                    this.data = response.data
            });
        },
        categoryEditEvent(data){
            this.editForm.id = data.id
            this.editForm.name = data.name
            this.editForm.parent = data.parent
        },
        categoryAddEvent(data){
            this.addForm.parent = data.parent
        },
        editCategory(){

            this.editForm.put('./categories/' + this.editForm.id,{
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

                    // const targetEl = document.getElementById(this.editModalId);
                    // const modal = new Modal( targetEl );
                    // modal.hide();
                    // this.refreshData();
                    console.log(document.querySelector('[tokenid]'));

                },
                onError: (errors) => {
                    this.errors = errors;
                },
                onCancel: () => {},
            })
        },
        addCategory(){
            this.addForm.post('/admin/categories',{
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

                    const targetEl = document.getElementById(this.addModalId);
                    const modal = new Modal( targetEl );
                    modal.hide();

                    this.refreshData();

                    },
                onError: (errors) => {
                    this.errors = errors;
                },
                onCancel: () => {},
            })
        },
    },
    watch:{
        currentPage(){
            this.refreshData();
        }
    },
    mounted() {
        this.data = this.categories

        this.emitter.on('edit-event',  this.categoryEditEvent)
        this.emitter.on('add-event',  this.categoryAddEvent)
    }
}
</script>

<style scoped>

</style>
