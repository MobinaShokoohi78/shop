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
                        <h3 class="">ویرایش محصول</h3>
                    </div>
                    <div class="border-b border-gray-200 rounded">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="product-tab" data-tabs-target="#product" type="button" role="tab" aria-controls="product" aria-selected="false">محصول</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="search-tab" data-tabs-target="#search" type="button" role="tab" aria-controls="search" aria-selected="false">جزیات محصول</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="attribute-tab" data-tabs-target="#attribute" type="button" role="tab" aria-controls="attribute" aria-selected="false">ویژگی محصول</button>
                            </li>
                        </ul>
                    </div>
                    <div id="myTabContent">
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="product" role="tabpanel" aria-labelledby="product-tab">
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
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="search" role="tabpanel" aria-labelledby="search-tab">
                            <div v-if="details.length > 0">
                                <div class="flex flex-row">
                                    <div class="basis-11/12">
                                        <div class="flex flex-row">
                                            <div class="mb-1 basis-1/4 ml-1">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">سایز</label>
                                            </div>
                                            <div class="mb-1 basis-1/4 ml-1">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">رنگ</label>
                                            </div>
                                            <div class="mb-1 basis-1/4 ml-1">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">تعداد</label>
                                            </div>
                                            <div class="mb-1 basis-1/4 ml-1">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">قیمت (تومان)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="basis-1/12">

                                    </div>

                                </div>
                                <div class="flex flex-row" v-for="(item, key) in details">
                                    <div class="basis-11/12">
                                        <div class="flex flex-row">
                                            <div class="mb-6 basis-1/4 ml-1">
                                                <pro-select
                                                    class="block mb-2 text-sm font-medium"
                                                    placeholder="سایز"
                                                    :items="sizes"
                                                    :searching="true"
                                                    v-model="item.size"
                                                ></pro-select>
                                                <div v-if="item.errors">
                                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{item.errors}}</p>
                                                </div>
                                            </div>
                                            <div class="mb-6 basis-1/4 ml-1">
                                                <pro-select
                                                    class="block mb-2 text-sm font-medium"
                                                    placeholder="رنگ"
                                                    :items="colors"
                                                    v-model="item.color"
                                                    :searching="true"
                                                ></pro-select>
                                                <div v-if="item.errors">
                                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{item.errors}}</p>
                                                </div>
                                            </div>
                                            <div class="mb-6 basis-1/4 ml-1">
                                                <input type="number" v-model="item.count" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.title ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="عنوان">
                                            </div>
                                            <div class="mb-6 basis-1/4 ml-1">
                                                <input type="number" v-model="item.price" class="text-sm rounded-lg block w-full p-2.5" :class="form.errors.title ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500' : 'bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500'" placeholder="عنوان">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="basis-1/12">
                                        <div class="flex flex-row">
                                            <button class="bg-red-500 py-2 px-5 mr-2 text-white rounded" @click="removeRow">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </div>

                                    </div>

                                </div>
                                <button class="bg-blue-500 py-2 px-5 mr-2 text-white rounded" @click="saveDetails">
                                    ثبت
                                </button>
                                <button class="bg-green-500 py-2 px-5 mr-2 text-white rounded" @click="addRow(key)" v-if="details[details.length -1 ].size != [] && details[details.length -1 ].color != [] && details[details.length -1 ].count != '' && details[0].price != ''">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
                            <div v-if="attributeProducts.length > 0">
                                <div class="flex flex-row">
                                    <div class="basis-11/12">
                                        <div class="flex flex-row">
                                            <div class="mb-1 basis-1/2 ml-1">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">ویژگی</label>
                                            </div>
                                            <div class="mb-1 basis-1/2 ml-1">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">مقدار</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="basis-1/12">

                                    </div>
                                </div>
                                <div class="flex flex-row" v-for="(item, key) in attributeProducts">
                                    <div class="basis-11/12">
                                        <div class="flex flex-row">
                                            <div class="mb-6 basis-1/2 ml-1">
                                                <pro-select
                                                    class="block mb-2 text-sm font-medium"
                                                    placeholder="ویژگی"
                                                    :items="attributes"
                                                    :searching="true"
                                                    v-model="item.attribute_id"
                                                    @change="getValues(item.attribute_id,key)"
                                                ></pro-select>
                                                <div v-if="item.errors">
                                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{item.errors}}</p>
                                                </div>
                                            </div>

                                            <div class="mb-6 basis-1/2 ml-1">
                                                <pro-select
                                                    ref="values"
                                                    v-if="item.values"
                                                    class="block mb-2 text-sm font-medium"
                                                    placeholder="مقدار ویژگی"
                                                    :items="item.values"
                                                    v-model="item.value_id"
                                                    :searching="true"
                                                ></pro-select>
                                                <div v-if="item.errors">
                                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"> {{item.errors}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="basis-1/12">
                                        <div class="flex flex-row">
                                            <button class="bg-red-500 py-2 px-5 mr-2 text-white rounded" @click="removeRowAttr">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button class="bg-blue-500 py-2 px-5 mr-2 text-white rounded" @click="saveAttr" v-if="attributeProducts[attributeProducts.length -1 ].attribute_id != [] && attributeProducts[attributeProducts.length -1 ].value_id != 0">
                                    ثبت
                                </button>
                                <button class="bg-green-500 py-2 px-5 mr-2 text-white rounded" @click="addRowAttr(key)" v-if="attributeProducts[attributeProducts.length -1 ].attribute_id != [] && attributeProducts[attributeProducts.length -1 ].value_id != 0">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
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
    props:['product', 'categories', 'colors', 'sizes', 'details', 'attributes', 'attributeProducts'],
    data(){
        return{
            form: useForm({
                title :'',
                category_id :[],
                description :'',
                // errors: []
            }),
            editor: ClassicEditor,
            // details: []

        }
    },
    mounted() {
        this.form.title = this.product.title;
        this.form.category_id = this.product.category_id;
        this.form.description = this.product.description;

        // this.details =JSON.parse(this.productDetails);
        // console.log(this.details)
    //

    },
    methods:{
        submit(e){
            e.preventDefault();

            this.form.put('/admin/products/'+ this.product.id,{
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
        addRow(){
            this.details.push({
                id: '',
                size: 0,
                color: 0,
                price: '',
                count: '',
            });
        },
        removeRow(key){
            this.details.splice(key, 1);
        },
        addRowAttr(){
            this.attributeProducts.push({
                attribute_id: 0,
                value_id: 0,
            });
        },
        removeRowAttr(key){
            this.attributeProducts.splice(key, 1);
        },
        saveDetails(){
            let hasError = false;
            this.details.forEach((item , key)=>{
                item["errors"] = '';
            })
            this.details.forEach((item , key)=>{
                item["errors"] = '';
                this.details.forEach((item2 , key2)=>{
                    if (key != key2 && item['id'] != item2['id'])
                        if(item['size'] == item2['size'] && item['color'] == item2['color']) {
                            item['errors'] = 'اطلاعات تکراری'
                            item2['errors'] = 'اطلاعات تکراری'
                            hasError = true;
                        }
                })
            })

            if (!hasError){
                let details = useForm(
                    this.details
                );
                details.post('/admin/products/details/update/'+ this.product.id,{
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
            }
        },
        getValues(id, key){
            axios.post('/admin/products/attributes/values/' + id).then((response) => {
                this.attributeProducts[key].values = []
                this.attributeProducts[key].values = response.data
                setTimeout(()=>{
                    this.$refs.values[key].refresh();
                },500);

            });
        },
        saveAttr(){
            let hasError = false;
            this.attributeProducts.forEach((item , key)=>{
                item["errors"] = '';
            })
            this.attributeProducts.forEach((item , key)=>{
                item["errors"] = '';
                this.attributeProducts.forEach((item2 , key2)=>{
                    if (key != key2)
                        if(item.attribute_id == item2.attribute_id && item.value_id == item2.value_id){
                            item['errors'] = 'اطلاعات تکراری'
                            item2['errors'] = 'اطلاعات تکراری'
                            hasError = true;
                        }


                })
            })
            alert(hasError);
            if (!hasError){
                let attributeProducts = useForm(
                    this.attributeProducts
                );
                attributeProducts.post('/admin/products/attributes/values/update/'+ this.product.id,{
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
            }
        },
    }

}
</script>
