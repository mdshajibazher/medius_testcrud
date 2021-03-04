<template>
    <div class="card">
            <div class="card-header">
                Customers <router-link to="/create-customer" class="btn btn-success float-right">Add New</router-link>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-1">
                            <p>Show</p>
                        </div>
                        <div class="col-md-2">
                            <select v-model="pagnate_per_page" class="form-control" style="width: 100px" @change="PerPageData">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-1">
                            <p>Search Field</p>
                        </div>
                        <div class="col-md-2">
                            <select v-model="queryField"  class="form-control">
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div  style="margin-right: 20px">
                                <input type="text" class="form-control" v-model="query">
                            </div>
                        </div>
                    </div>
                </div>


<!--Check if total_data or customer collection  data  exist then show it   -->
                <table class="table" v-if="total_data > 0">
                    <thead class="thead-light">
                    <tr>
                        <th @click="sort('id')">Sl <div v-html="getsortIcon(orderByDir)"></div></th>
                        <th @click="sort('name')">Name <div v-html="getsortIcon(orderByDir)"></div></th>
                        <th @click="sort('email')">Email <div v-html="getsortIcon(orderByDir)"></div></th>
                        <th @click="sort('phone')">Phone <div v-html="getsortIcon(orderByDir)"></div></th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="(item,index) in customer_list.data" :key="item.id">
                            <td>{{customer_list.from+index}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.email}}</td>
                            <td>{{item.phone}}</td>
                            <td><router-link :to="'/edit-customer/'+item.id" class="btn btn-success btn-sm float-right">Edit</router-link></td>
                        </tr>
                    </tbody>


                </table>

                <!--Check if customer collection has no data then show this message -->



                <p v-else class="alert alert-danger">Sorry No Data Dound </p>
                <div class="row">
                    <div class="col-md-6">
                        Showing {{from}} to {{to}} of {{total_data}} entries
                    </div>


                           <!-- if  query variable has value then hit getData function otherwise hit searchData function basically  query varible is maintained a by VUE watcher-->



                    <div class="col-md-6">
                        <div class="float-right">
                            <pagination  :limit="4" :data="customer_list" v-if="query === ''" @pagination-change-page="getData"></pagination>
                            <pagination  :limit="4" :data="customer_list" v-else @pagination-change-page="searchData"></pagination>
                        </div>

                    </div>
                    </div>
                </div>

            </div>
        </div>

</template>

<script>
import pagination from 'laravel-vue-pagination';
export default {
name: "CustomerComponent",
    components: {pagination},
    created() {
        this.getData();
    },

    //here i use 9 variable
    // customerlist basically a collection of customer data,
    // query variable stores search input data,
    // queryField variable basically store which database column we wanna search ,
    // from vatiable is the loop first data
    // to variable is the loop last data
    // total vatiable is the number of database table total colimn
    // paginate per page basically how data will be show per page
    // paginate per page basically how data will be show per page
    // orderBy variable contains database column name for sorting purpose
    // orderByDir variable is the direction of sorting
    data(){
        return {
            customer_list: {},
            query: "",
            queryField: "name",
            from: 0,
            to: 0,
            total_data: 0,
            pagnate_per_page: 10,
            orderBy:'id',
            orderByDir:'desc',
        }
    },
    //this watcher always wait when a query variable is changed if changed then this function has two param newQ,oldQ if newQ is empty then it calls as usual getData function but if has data then call searchData function
    watch:{
        query: function (newQ,oldQ){
            if (newQ === "") {
                this.getData();
            } else {
                this.searchData();
            }
        }
    },
    methods:{

        //first start progressbar basically it is a functionality of VUE PROGRESSBAR plugin
        //then we send a axios request to get the customer data collection
        //when we get the response in promise we set necessery
        getData(page = 1){
            this.$Progress.start()
            axios.get('/customers/?page='+page+'&per_page='+this.pagnate_per_page+'&orderBy='+this.orderBy+'&orderByDir='+this.orderByDir)
            .then(res => {
                console.log(res);
                this.customer_list = res.data;
                this.total_data = res.data.total;
                this.from = res.data.from;
                this.to = res.data.to;
                this.$Progress.finish();
            })
            .catch(err => {
                console.log(err);
                this.$Progress.fail()
            })
        },

        //first start progressbar basically it is a functionality of VUE PROGRESSBAR plugin
        //then we send a axios request to get the customer data collection
        //when we get the response in promise we set necessery

        searchData(page = 1){
            this.$Progress.start()
            axios.get('/customers/'+this.queryField+'/'+this.query+'/?page='+page+'&per_page='+this.pagnate_per_page+'&orderBy='+this.orderBy+'&orderByDir='+this.orderByDir)
                .then(res => {
                    console.log(res);
                    this.customer_list = res.data;
                    this.total_data = res.data.total;
                    this.from = res.data.from;
                    this.to = res.data.to;
                    this.$Progress.finish()
                })
                .catch(err => {
                    console.log(err);
                    this.$Progress.fail()
                })
        },

        // this function calls when we change show at the top most here we check  if customer is in serch mode that means query variable has data then call searchData otherwise getData
        PerPageData(){
            if(this.query === ''){
                this.getData()
            }else{
                this.searchData()
            }
            console.log(this.pagnate_per_page);
        },

        // this function sort the whole by column name ascending or descending
        sort(argument){
            this.orderBy = argument;
            this.orderByDir == 'desc' ?  this.orderByDir = 'asc' : this.orderByDir = 'desc';
            if(this.query === ''){
                this.getData()
            }else{
                this.searchData()
            }
        },

        getsortIcon(orderByDir){
            if(orderByDir == 'asc'){
                return '<i class="fas  fa-sort-alpha-up"></i>';
            }else{
                return '<i class="fas  fa-sort-alpha-down-alt"></i>';
            }
        }
    }
}
</script>

<style scoped>

</style>
