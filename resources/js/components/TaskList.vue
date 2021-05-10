<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        Task List

                        Status :
                        <select v-model="filterStatus">
                            <option value="*">Default</option>
                            <option value="1">Completed</option>
                            <option value="0">New</option>
                        </select>
                        <button @click="getData()" class="btn btn-warning btn-sm"><i class="bi bi-search"></i>
                            Get Data</button>

                        <router-link :to="{name: 'addTask'}"> <button class="btn btn-success btn-sm float-right"><i class="bi bi-plus-circle-fill"></i> Task Add</button></router-link>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Type</th>
                                <th scope="col" class="text-center">Title</th>
                                <th scope="col" class="text-center">Currency</th>
                                <th scope="col" class="text-center">Quantity</th>
                                <th scope="col" class="text-center">Country</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Prerequisites</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="value in getTaskList">
                                <th scope="row" class="text-center">{{value.type}}</th>
                                <td class="text-center">{{value.title}}</td>
                                <td class="text-center" v-if="value.amount">{{value.amount.currency}}</td>
                                <td class="text-center" v-else>-</td>
                                <td class="text-center" v-if="value.amount">{{value.amount.quantity}}</td>
                                <td class="text-center" v-else>-</td>
                                <td class="text-center" v-if="value.country">{{value.country}}</td>
                                <td class="text-center" v-else>-</td>
                                <td class="text-center" v-if="value.status == 0">New</td>
                                <td class="text-center" v-if="value.status == 1">Completed</td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm" v-for="pre in value.get_prerequisites">{{ pre.task_name }}</button>
                                </td>
                                <td class="text-center">
                                    <button @click="finish(value._id)" v-if="value.status == 0" class="btn btn-primary btn-sm"><i class="bi bi-play-fill"></i>
                                        Finish</button>
<!--                                    <router-link :to="{name: 'editTask', params:{id:value._id} }"> <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-fill"></i>
                                        Edit</button></router-link>-->
                                    <button @click="deleteData(value._id)" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i>
                                        Delete</button>
                                </td>
                            </tr>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "TaskList",
    data(){
      return {
          filterStatus : '*'
      }
    },
    computed: {
        ...mapGetters([
            'getTaskList'
        ])
    },
    methods:{
      async finish(id){
          let response = await this.$store.dispatch('finishTask', {'data': id});
          if (response.data.operation == 1){
              this.$toastr.success(response.data.message, 'Success');
          }else if (response.data.operation == 0){
              this.$toastr.error(response.data.message, 'Error');
          }
      },
        async getData(){
           await this.$store.dispatch('getData', {'data': this.filterStatus});
        },

        async deleteData(id){
            await  swal({
                title: "Do you really want to do this?",
                text: "If there are conditions for this task, all of them are deleted",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                         this.$store.dispatch('deleteData', {'data':id});

                        swal("Data was deleted", {
                            icon: "success",
                        });
                    }
                });
        }
    },
    created() {
        document.title = 'Task List';


    },

}
</script>

<style scoped>

</style>
