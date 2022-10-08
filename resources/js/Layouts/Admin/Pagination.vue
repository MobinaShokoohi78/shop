<template>

    <div class="flex justify-around" v-if="pages != 1">
        <nav aria-label="Page navigation example" >
            <ul class="inline-flex -space-x-px">
                <li>
                    <div
                        class="py-2 px-3 ml-0 leading-tight bg-white rounded-r-lg border"
                        :class="modelValue == 1 ? 'text-gray-400 border-gray-200 cursor-default' : 'text-gray-500 border-gray-300 hover:bg-gray-100 hover:text-gray-700 cursor-pointer'"
                       @click="previousPage"
                    >قبل</div>
                </li>
                <li v-for="item in data">
                    <div
                        v-if="item[1]"
                        v-text=" item[0]"
                        :aria-current=" item[0] == modelValue ? 'page' : '' "
                        class="py-2 px-3 leading-tight cursor-pointer"
                        :class = "item[0] == modelValue ? 'text-blue-600 bg-blue-50 border border-gray-300 hover:bg-blue-100 hover:text-blue-700' : ' text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700'"
                        @click="this.$emit('update:modelValue', item[0])"
                    >
                    </div>
                    <div
                        v-else
                        class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 cursor-default"
                    >...
                    </div>
                </li>
                <li>
                    <div
                       class="py-2 px-3 ml-0 leading-tight bg-white rounded-l-lg border"
                       :class="modelValue == totalPages ? 'text-gray-400 border-gray-200 cursor-default' : 'text-gray-500 border-gray-300 hover:bg-gray-100 hover:text-gray-700 cursor-pointer'"
                       @click="nextPage"
                    >بعد</div>
                </li>
            </ul>
        </nav>
    </div>

</template>

<script>
export default {
    name: "Pagination",
    props:{
        modelValue:{
            required: true,
        },
        pages :{
            required: true,
        },

    },
    data(){
        return{
            data:[],
            totalPages : 0,
        }
    },
    mounted() {
        this.makeData();
    },
    watch:{
        modelValue(){
            this.makeData();
        }
    },
    methods:{
        makeData(){
            const data = [];
            this.totalPages =  parseInt(this.pages);
            if (this.modelValue && this.pages){
                if (this.totalPages <= 7){
                    for(var i = 1; i <= this.totalPages; i++){
                        data.push([i,true]);
                    }
                }
                else {
                    if (this.modelValue <= 3){
                        data.push([1, true]);
                        switch (this.modelValue){
                            case 1:
                                for(var i = 2; i <= this.modelValue + 2; i++){
                                    data.push([i, true]);
                                }
                                break;
                            case 2:
                                for(var i = 2; i <= this.modelValue + 2; i++) {
                                    data.push([i, true]);
                                }
                                break;
                            case 3:
                                for(var i = 2; i <= this.modelValue + 2; i++) {
                                    data.push([i, true]);
                                }
                                break;
                        }
                        data.push([this.modelValue+3, false]);
                        data.push([this.totalPages, true]);
                    }
                    else if (this.modelValue >= this.totalPages-2){
                        data.push([1, true]);
                        data.push([this.modelValue-3, false]);
                        switch (this.modelValue){
                            case this.totalPages-2:
                                console.log(this.totalPages-2)
                                for(var i = this.modelValue-2; i <= this.totalPages ; i++){
                                    data.push([i, true]);
                                }
                                break;
                            case this.totalPages-1:
                                console.log(this.totalPages-1)
                                for(var i = this.modelValue-2; i <= this.totalPages ; i++) {
                                    data.push([i, true]);
                                }
                                break;
                            case this.totalPages:
                                console.log(this.totalPages)

                                for(var i = this.modelValue-2; i <= this.totalPages; i++) {
                                    data.push([i, true]);
                                }
                                break;
                        }
                    }
                    else {
                        data.push([1, true]);
                        console.log(this.modelValue-3,this.modelValue-3 == 1 )
                        if (this.modelValue-3 != 1 )
                            data.push([this.modelValue-3, this.modelValue-3 == 2 ? true : false]);

                        for(var i = this.modelValue-2; i <= this.modelValue+2 ; i++){
                            data.push([i, true]);
                        }

                        if (this.totalPages != this.modelValue+3)
                            data.push([this.modelValue+3,  false]);
                        data.push([this.totalPages,  true]);

                    }

                }
                this.data = data;
            }

        },
        previousPage(){
            let active= this.modelValue;
            if (active != 1){
                active = active -1
                this.$emit('update:modelValue', active)
            }
        },
        nextPage(){
            let active= this.modelValue;
            if (active != this.totalPages){
                active = active +1
                this.$emit('update:modelValue', active)
            }
        },
    },


}
</script>

<style scoped>

</style>
