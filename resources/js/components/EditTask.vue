<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        Task Add
                        <button type="submit" class="btn btn-success float-right" @click="editTask"><i class="bi bi-save-fill"></i> Save</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prerequisites</label>
                                    <select class="form-control" v-model="post.prerequisites" multiple>
                                        <option :key="value._id" v-for="value in getTaskList" :value="{_id:value._id, title:value.title}">{{ value.title }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" type="text" v-model="post.title">
                                    <div v-if="!$v.post.title.required && submitStatus" class="alert alert-danger" role="alert">
                                        * Field is required
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" v-model="post.type">
                                        <option value="invoice_ops">Invoice</option>
                                        <option value="custom_ops">Custom</option>
                                        <option value="common_ops">Common</option>
                                    </select>
                                    <div v-if="!$v.post.type.required && submitStatus" class="alert alert-danger" role="alert">
                                        * Field is required
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" v-if="post.type == 'invoice_ops'">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select class="form-control" v-model="post.amount.currency">
                                        <option value="try">Turkish Lira</option>
                                        <option value="euro">Euro</option>
                                        <option value="dollar">Dollar</option>
                                        <option value="sterlin">Pound</option>
                                    </select>
                                    <div v-if="!$v.post.amount.currency.required && submitStatus" class="alert alert-danger" role="alert">
                                        * Field is required
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" v-if="post.type == 'invoice_ops'">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control" type="text" v-model="post.amount.quantity">
                                    <div v-if="!$v.post.amount.quantity.required && submitStatus" class="alert alert-danger" role="alert">
                                        * Field is required
                                    </div>
                                    <div v-if="!$v.post.amount.quantity.numeric && submitStatus" class="alert alert-danger" role="alert">
                                        * The amount should only consist of numbers
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" v-if="post.type == 'custom_ops'">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input class="form-control" type="text" v-model="post.country">
                                    <div v-if="!$v.post.country.required && submitStatus" class="alert alert-danger" role="alert">
                                        * Field is required
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

import { required, numeric } from "vuelidate/lib/validators";
export default {
    data() {
        return {
            post:{
                prerequisites: [],
                title: null,
                type: null,
                amount:{
                    currency:null,
                    quantity:null
                },
                country: null,
            },
            submitStatus: false
        }
    },
    validations() {
        const validations = {
            post:{
                title:{ required },
                type:{ required },
                amount:{
                    currency: {},
                    quantity: {}
                },
                country:{}
            }
        };

        if (this.type == 'invoice_ops') {
            validations.post.amount.currency = { required };
            validations.post.amount.quantity = { required,numeric };
        }

        else if (this.type == 'custom_ops') {
            validations.post.country = { required };
        }

        return validations;
    },
    methods: {
        async editTask() {
        }
    },
    computed: {
        ...mapGetters([
            'getTaskList'
        ]),


    },
   async created() {
        document.title = 'Edit Task';
        let id = this.$route.params.id;
        let response = await this.$store.dispatch('getTask', {'data': id});
        if (response.data._id){
            this.post.title = response.data.title;
            this.post.type = response.data.type;
            this.post.amount.currency = response.data.amount.currency;
            this.post.amount.quantity = response.data.amount.quantity;
            this.post.country = response.data.country;
            var array = [];
            response.data.get_prerequisites.forEach(function (item,index){
                var object = {'_id' :item._id,'title':item.task_name}
                array.push(object);
            })
            this.post.prerequisites = array;
        }else{
            this.$router.push({name: 'taskList'})
        }
    },
}

</script>
<style scoped>
.alert{
    padding: 0;
    text-align: center;
    color: black;
}
</style>
