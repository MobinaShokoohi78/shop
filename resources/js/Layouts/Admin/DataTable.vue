<template>
    <!--    tab     -->
    <div class="m-4 relative shadow-md sm:rounded-lg mt-6 overflow-visible">
        <div class="border-b border-gray-200 rounded">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation" v-show="columns.length >= 1">
                    <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="columns-tab" data-tabs-target="#columns" type="button" role="tab" aria-controls="columns" aria-selected="false">ستون ها</button>
                </li>
                <li class="mr-2" role="presentation" v-show="fieldsSearch.length >= 1">
                    <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="search-tab" data-tabs-target="#search" type="button" role="tab" aria-controls="search" aria-selected="false">جست و جو</button>
                </li>
                <li class="mr-2" role="presentation" v-show="Object.keys(filters).length  >= 1">
                    <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="filter-tab" data-tabs-target="#filter" type="button" role="tab" aria-controls="filter" aria-selected="false">فیلتر ها</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="pagination-tab" data-tabs-target="#pagination" type="button" role="tab" aria-controls="pagination" aria-selected="false">...</button>
                </li>
            </ul>
        </div>
        <div id="myTabContent">
            <div class="hidden p-4 bg-gray-50 rounded-lg" id="columns" role="tabpanel" aria-labelledby="columns-tab" v-show="columns.length >= 1">
                <div class="w-full">
                    <pro-select
                        select-id="select"
                        :items="columns"
                        placeholder="ستون ها"
                        v-model="columnsSelected"
                        :multiSelect="multiSelect"
                    ></pro-select>
                </div>
            </div>
            <div class="hidden p-4 bg-gray-50 rounded-lg" id="search" role="tabpanel" aria-labelledby="search-tab" v-show="fieldsSearch.length >= 1">
                <div class="flex flex-row">
                    <div class="relative w-full ml-2">
                        <div>
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass fa-lg text-gray-500"></i>
                            </div>
                            <input v-model="search" type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search" required>
                        </div>
                    </div>
                    <div class="w-full" v-if="columns.length >1">
                        <pro-select
                            placeholder="ستون ها"
                            :items="columns"
                            v-model="fieldsSearch"
                            :multiSelect="multiSelect"
                        ></pro-select>
                    </div>
                </div>
            </div>
            <div class="hidden p-4 bg-gray-50 rounded-lg" id="filter" role="tabpanel" aria-labelledby="filter-tab" v-show="Object.keys(filters).length  >= 1" >
                <div class="relative w-full ml-2 flex items-center mb-4" v-for="(filter, i) in filters">
                    <div class="w-2/12 m-2">
                        <div>{{filter.name}}</div>
                    </div>
                    <div class="w-10/12 m-2">
                        <input
                            v-if="filter.type == 'text'"
                               v-model="selectedFilters[filter.name]"
                               @keyup="getData"
                               type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <DatePicker
                            v-model="selectedFilters[filter.name]"
                            v-else-if="filter.type == 'date'"
                            :column="1"
                            color="gray"
                            mode="single"
                            clearable
                            @select="selectDate">
                        </DatePicker>
                        <select
                            @change="getData"
                            v-else
                            v-model="selectedFilters[filter.name]"
                            class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-right">
                            <option v-for="item in filter.value" :value="item.id" v-text="item.text"></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="hidden p-4 bg-gray-50 rounded-lg" id="pagination" role="tabpanel" aria-labelledby="pagination-tab">
                <div class="ml-2 flex items-center mb-4">
                    <div class="w-2/12">
                        <label> تعداد نمایش در صفحه</label>
                    </div>
                    <div class="w-10/12">
                        <select
                            class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-right"
                            v-model="perPage"
                            @change="changePagination"
                        >
                            <option>5</option>
                            <option>10</option>
                            <option>15</option>
                            <option>20</option>
                            <option>25</option>
                        </select>
                    </div>
                </div>
<!--                <div class="flex items-center m-4">
                    <div class="w-1/2">
                        <button class="bg-red-500 hover:bg-red-600 mx-2 rounded text-white text-center w-full"
                        @click="deleteChecked">
                            حذف
                            {{checked.length}}
                            مورد
                        </button>
                    </div>
                    <div class="w-1/2">

                    </div>
                </div>-->
            </div>
        </div>
    </div>

    <!--    end tab     -->

    <!--    table      -->
    <div class="m-4 relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
        <table class="w-full text-sm text-right text-gray-500 rounded ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="p-4">
                        <!--     nothing :)        -->
                    </th>
                    <th scope="col"
                        class="px-6 py-3 cursor-pointer"
                        :key="key"
                        @click="sortField(key)">
                        #
                        <div class="inline" v-if="sort['name'] == key">
                            <i v-if="sort['type'] == 'desc'" class="fa-solid fa-arrow-down-z-a fa-lg text-gray-500"></i>
                            <i v-else class="fa-solid fa-arrow-down-a-z fa-lg text-gray-500"></i>
                        </div>

                    </th>
                    <th scope="col"
                        class="px-6 py-3 cursor-pointer"
                        v-for="item in columnsSelected"
                        :key="item"
                        @click="sortField(item)">

                        {{getWord(item)}}
                        <div class="inline" v-if="sort['name'] == item">
                            <i v-if="sort['type'] == 'desc'" class="fa-solid fa-arrow-down-z-a fa-lg text-gray-500"></i>
                            <i v-else class="fa-solid fa-arrow-down-a-z fa-lg text-gray-500"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">عملیات </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(row,rowIndex) in data"
                    :key="rowIndex"
                    class="bg-white border-b hover:bg-gray-50"
                >
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-1" v-model="checked" :value="row[key]" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-table-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                        :key="key"
                        v-text="row[key]">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                        v-for="field in columnsSelected"
                        :key="field"
                        :title="row[field]">
                        <slot :name="field" :id="row[key]" :item="row[field]" :prem="permission">
                            {{row[field]}}

                        </slot>

                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex">
                            <slot name="action" :id="row[key]" :item="row" :prem="permission"/>
<!--                            :href="route(permission.update ,row[key])"-->
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!--    end table      -->

    <!--    pagination      -->
    <div class="text-center m-5 text-gray-400">
        نمایش از
        <span class="font-bold text-blue-400"> {{ from }}</span>
        تا
        <span class="font-bold text-blue-400"> {{ to }}</span>
        از
        <span class="font-bold text-blue-400"> {{ total }}</span>
    </div>

    <Pagination :pages="pages" v-model="currentPage" v-if="pages" ref="pagination"/>
    <!--    end pagination      -->


</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from "@/Layouts/Admin/Pagination";
import { Inertia } from '@inertiajs/inertia';
import SweetAlert from 'sweetalert2/dist/sweetalert2.js';
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import ProSelect from "@/Layouts/Admin/ProSelect";


export default {
    name: "DataTable",
    components: {
        ProSelect,
        Pagination,
        DatePicker,
    },
    props:{
        api :{
            type: String,
            required: true,
        },

    },
    data(){
        return{
            columns : [],
            columnsSelected : [],

            search:'',
            fieldsSearch:[],

            filters:[],
            selectedFilters: {},

            sort: {},

            key: "id",

            currentUrl: window.location.href,
            checked: [],
            from : null,
            to : null,
            total : null,
            perPage: 10,
            currentPage: 1,
            pages: null,
            permission: null,

            multiSelect: true,

            data: {},
            selectedList: [
                'email',
                'name',
                'is_admin',
                'created_at'
            ]
        }
    },
    computed:{},
    methods:{
        async getData(){
            await axios.post(this.api,{
                paginate : this.perPage,
                page : this.currentPage,
                search : this.search,
                fieldsSearch : this.fieldsSearch,
                sort : this.sort,
                filters : this.selectedFilters,
            }).then((response) => {
                this.data = response.data['data'].data;
                this.from = response.data['data'].from;
                this.to = response.data['data'].to;
                this.total = response.data['data'].total;
                this.currentPage = response.data['data'].current_page;
                this.pages = response.data['data'].last_page;

                this.permission = response.data['permission']

                if (! this.columns.length > 0){
                    this.columns = response.data['fields'];
                    this.columnsSelected = response.data['fields'].map((item)=> item['id'])
                }

                if (response.data['filters']){
                    this.filters = response.data['filters'];
                }

                if (response.data['search']){
                    console.log( response.data['search'])
                    this.fieldsSearch = response.data['search']
                }

                if (response.data['key']){
                    this.key = response.data['key'];
                }

                if (response.data['filters']){
                    this.filters = response.data['filters'];
                }
            });

        },
        sortField(field){
            this.sort = {
                name: field,
                type:
                    this.sort.name == field && this.sort.type == "desc" ? "asc" : "desc",
            };
            this.getData();
        },
        changePagination(){
            this.currentPage = 1;
            this.getData()
        },
        getWord(item){
            let v  = '';
            this.columns.forEach((value)=>{
                if (item == value.id){
                    v = value.text;
                }
            });
            return v;
        },
        makeUpdateUrl(id){
            return this.currentUrl+ '/'+ id + '/edit'
        },
        selectDate(){
            setTimeout(()=>{
                this.getData();
            },500);
        },
        deleteChecked(){
            let checked = this.checked;
            SweetAlert.fire({
                title: 'آیا مایل به حذف گزینه هستید؟',
                icon: 'question',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'بله',
                denyButtonText: `خیر`,
                confirmButtonColor:'#22c55e',
                denyButtonColor:'#ef4444',
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.delete(this.currentUrl + '/0',{
                        data:{
                            'ids' : checked
                        },
                        onBefore: (visit) => {},
                        onStart: (visit) => {},
                        onProgress: (progress) => {},
                        onSuccess: (page) => {
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
        }
    },
    watch:{
        search(){
            setTimeout(()=>{
                this.getData();
                },500);
        },
        currentPage(){
            this.getData();
        },
        selectedFilters(){
            console.log('select');
            this.getData();
        },
        // fieldsSearch(){
        //     this.getData();
        // }
    },
    mounted() {
        this.getData();
    }

}
</script>

<style scoped>

</style>
