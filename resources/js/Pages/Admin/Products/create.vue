<template>

    <DashboardAdmin>

        <template #content>

            <div class="rounded shadow-lg p-3 m-3 px-6 pb-6 min-h-screen">

                <!--                breadcrumb                -->
                <breadcrumb></breadcrumb>
                <!--                breadcrumb                -->

                <!--                main content                   -->
                <div class="p-7 relative overflow-x-auto shadow-md sm:rounded-lg mt-6 min-h-screen">

                    <div class="mb-5">
                        <h3 class="">محصول جدید</h3>
                    </div>

                        <form>
                            <div class="flex flex-row">
                                <div class="mb-6 basis-1/2 ml-1">
                                    <label for="title" class="block mb-2 text-sm font-medium" :class="form.errors.title ? 'text-red-700' : 'text-gray-900'">عنوان</label>
                                    <input type="text" id="title" v-model="form.title" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.title ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="عنوان">
                                    <div v-if="form.errors.title">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{form.errors.title}}</p>
                                    </div>
                                </div>
                                <div class="mb-6 basis-1/2 ml-1">
                                    <label class="block mb-2 text-sm font-medium" :class="form.errors.category_id ? 'text-red-700' : 'text-gray-900'">دسته بندی</label>
                                    <pro-select
                                        select-id="category_id"
                                        class="block mb-2 text-sm font-medium"
                                        placeholder="دسته بندی"
                                        :items="categories"
                                        v-model="form.category_id"
                                        :searching="true"
                                    ></pro-select>
                                    <div v-if="form.errors.category_id">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{form.errors.category_id}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6 basis-full ml-1">
                                <label for="title" class="block mb-2 text-sm font-medium" :class="form.errors.description ? 'text-red-700' : 'text-gray-900'">توضیحات</label>
                                <ckeditor
                                    tag-name="textarea"
                                    ref="cktext"
                                    :editor="editor"
                                    v-model="form.description"
                                ></ckeditor>
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
import ProSelect from "@/Layouts/Admin/ProSelect";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";


export default {
    name: "edit",
    components: {Button, Breadcrumb, DashboardAdmin, ProSelect},
    props:[ 'categories'],
    data(){
        return{
            form: useForm({
                title :'',
                category_id :[],
                description :'',
                // errors: []
            }),
            editor: ClassicEditor,
            details: []

        }
    },
    mounted() {
        // this.form.title = this.product.title;
        // this.form.category_id[0] = this.product.category_id;
        // this.form.description = this.product.description;

    },
    methods:{
        submit(e){
            e.preventDefault();
            this.form.post('/admin/products',{
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
                        title: 'اطلاعات با موفقیت ویرایش شد!'
                    });
                },
                onError: (errors) => {},
                onCancel: () => {},
            })
        },

    }

}
</script>
