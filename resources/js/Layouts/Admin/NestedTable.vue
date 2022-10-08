<template>
    <div v-for="item in data" class=" border border-gray-100 rounded p-2 my-2 mb-0.5 mt-2">

        <div class="flex flex-row space-x-1">
            <div class="pl-2"><b>{{ item.id }}</b> {{ item.name }}</div>
            <button @click="edit(item.id, item.name, item.parent)" :data-modal-toggle="editModalId" class="bg-green-700 rounded text-white text-xs p-1 w-" :data-id="item.id" :data-patent="item.parent">ویرایش</button>
            <button @click="deleteItem(item.id)" class="bg-red-700 rounded text-white text-xs p-1">حذف</button>
            <button @click="add(item.id)" :data-modal-toggle="addModalId" class="bg-purple-700 rounded text-white text-xs p-1" :data-id="item.id" :data-patent="item.parent">افزودن زیر مجموعه</button>
        </div>

        <div v-if="item.child" class="mr-4">
            <nested-table :data="item.child" :editModalId="editModalId" :addModalId="addModalId"></nested-table>
        </div>

    </div>

</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import SweetAlert from 'sweetalert2/dist/sweetalert2.js';
import Button from "@/Components/Button";

export default {
    name: "NestedTable",
    components: {Button},
    inject: ['emitter'],
    props: ['data','editModalId','addModalId'],
    data(){
        return{
            currentUrl: window.location.href,
        }
    },
    methods:{
        makeUpdateUrl(id,type){
            if (type == 'edit')
                return this.currentUrl+ '/'+ id + '/edit';
            else
                return this.currentUrl+ '/create?id='+ id;

        },
        deleteItem(id){
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
                        },
                        onError: (errors) => {

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
                }
            })
        },
        edit(id, name, parent){
            this.emitter.emit('edit-event', { id: id, name: name, parent: parent })
        },
        add(parent){
            this.emitter.emit('add-event', { parent: parent })
        },

    },
    mounted() {


    }
}
</script>

<style scoped>

</style>
