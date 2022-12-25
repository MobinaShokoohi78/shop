<template>
    <div :id="selectId">
        <div type="text" id="name" class="text-sm rounded-lg block w-full p-2.5 bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 cursor-pointer" @click="showDropdown = !showDropdown">
            <div class="flex justify-between">
            <span class="text-gray-700 ">
                {{placeholderText}}
            </span>
            <i v-if="showDropdown" class="fa-solid fa-chevron-up"></i>
            <i v-else class="fa-solid fa-chevron-down"></i>
            </div>
        </div>
        <div class="relative">
            <div v-if="showDropdown" id="dropdown" class="absolute z-50 mt-3 block w-full bg-white rounded divide-y divide-gray-100 shadow max-h-60 overflow-auto">
                <div class="w-full p-3 relative" v-if="searching">
                    <div class="flex absolute inset-y-0 left-3 items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass fa-lg text-gray-500"></i>
                    </div>
                    <input v-model="search" type="text" id="simple-search" class="text-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="جست و جو" required>
                </div>
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                    <li v-for="(item,key) in dataItems" class="cursor-pointer" :class="selected.includes(item) ? 'hover:bg-gray-300 bg-gray-200' : 'hover:bg-gray-100'">
                        <div class="flex flex-row" @click="select(key,item)">
                            <div class="w-3 m-2.5 w-3 h-3"><i class="fa-solid fa-check" v-if="selected.includes(item)"></i></div>
                            <div class="w-full block py-2 px-4">{{ item.text }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <select class="form-control hidden" id="" name="" data-select2-id="1" :multiple="multiSelect" v-model="selectedHide">
            <option v-for="(item,key) in items" :value="item.id" :id="key" >{{ item.text }}</option>
        </select>
    </div>

</template>

<script>
export default {
    name: "ProSelect",
    props:{
        selectId:{
            type: String,
            require: true,
        },
        items:{
            type: Array,
            require: true,
        },
        multiSelect :{
            type: Boolean,
            require: false,
            default: false
        },
        placeholder :{
            type: String,
            require: false,
            default: ""
        },
        searching :{
            type: Boolean,
            require: false,
            default: false
        },
        modelValue :{
            type: [Number, Array],
            require: true
        }

    },
    data(){
        return{
            showDropdown: false,
            selected:[],
            selectedHide: [],
            search: '',
            dataItems: this.items,
        }
    },
    methods:{
        select(key,item){
            if (this.multiSelect){
                if (this.selected.includes(item)){

                    let index = this.selected.indexOf(item)
                    this.selected.splice(index, 1);

                    index = this.modelValue.indexOf(item.id);
                    this.selectedHide.splice(index, 1);
                    // this.modelValue = this.selectedHide;
                    this.updateValue(this.selectedHide);
                }else{
                    this.selected.push(item)
                    this.selectedHide.push(item.id)
                    // this.modelValue = this.selectedHide;
                    this.updateValue(this.selectedHide);
                }
            }
            else{
                this.showDropdown = false;

                this.selected = [];
                this.selectedHide = '';

                this.selected[0] = item
                this.selectedHide = item.id
                this.updateValue(this.selectedHide);
                this.$emit('change')

            }
        },
        searchData(){
            let datas = this.items.filter((item)=>{
                let text = item.text;
                if (text.indexOf(this.search) > -1){
                    return item;
                }
            })
            this.dataItems = datas;
        },
        selectData(){
            if (this.multiSelect){
                this.selectedHide = this.items.map((item)=>{
                    return this.modelValue.includes(item.id) ? item.id : null;
                })
                this.updateValue(this.selectedHide);

                this.selected = this.items.filter((item)=>{
                    return this.modelValue.includes(item.id) ;
                })
            }
            else{
                 this.items.forEach((item)=> {
                     if (this.modelValue == (item.id))
                         this.selectedHide = item.id ;
                })
                this.updateValue(this.selectedHide);

                this.selected = this.items.filter((item)=>{
                    return this.modelValue == item.id ;
                })
            }


        },
        updateValue(value) {
            this.$emit('update:modelValue', value);
        },
        refresh(){
            this.showDropdown= false;
            this.selected= [];
            this.selectedHide=  [];
            this.search=  '';
            this.dataItems = '';
            this.dataItems = this.items;
        }

    },
    watch:{
        search(){
            setTimeout(()=>{
                this.searchData();
            },500);
        },
    },
    mounted() {
        setTimeout(()=>{
            this.selectData();
        },1000);
    },
    computed:{
        placeholderText(){
            if (this.dataItems){
                if (this.selected.length > 0 && this.modelValue) {
                    let arr = this.selected.map((item) => {
                        return item.text;
                    });
                    return arr.join("، ");
                } else
                    return this.placeholder;
            }

        }
    },
}
</script>

<style scoped>

</style>
