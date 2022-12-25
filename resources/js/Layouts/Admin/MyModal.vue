<template>
    <div :id="modalId" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full h-full md:h-auto" :class="getSize()">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 rounded-t border-b">
                    <button @click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" :data-modal-toggle="modalId">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                       <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <slot name="content"/>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 gap-4 rounded-b border-t border-gray-200">
                    <slot name="buttons"/>
                    <button :data-modal-toggle="modalId" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Decline</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MyModal",
    props: ['modalId', 'size'],
    methods:{
        getSize(){
            if (this.size == 'small')
                return 'max-w-md';
            else if (this.size == 'medium')
                return 'max-w-2xl';
            else if (this.size == 'large')
                return 'max-w-4xl';
            else if (this.size == 'xlarge')
                return 'max-w-7xl';
            else
                return 'max-w-lg';
        },
        closeModal(){
            // const targetEl = document.getElementById(this.modalId);
            // const modal = new Modal( targetEl );
            // modal.hide();
            // targetEl.setAttribute("aria-hidden", true);
            // targetEl.removeAttribute("role");
            // let tag = document.getElementsByClassName('bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40');
            // let len = tag.length;
            // if (len > 0) {
            //     for (let i = 0; i < len; i++) {
            //         tag[0].remove();
            //     }
            // }
        }
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
