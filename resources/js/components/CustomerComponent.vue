<template>
    <div class="card">
            <div class="card-header">
                Customers <router-link to="/createcustomer" class="btn btn-success float-right">Add New</router-link>
            </div>
            <div class="card-body">
                <table class="table ">
                    <thead class="thead-dark">
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="(item,index) in customersdata" :key="item.id">
                            <td>{{item.name}}</td>
                            <td>{{item.email}}</td>
                            <td>{{item.phone}}</td>
                            <td><router-link :to="'/editcustomer/'+item.id" class="btn btn-success btn-sm float-right">Edit</router-link></td>
                        </tr>
                    </tbody>


                </table>
            </div>
        </div>

</template>

<script>
export default {
name: "CustomerComponent",
    created() {
        this.getData();

    },
    data(){
        return {
            customersdata: [],
        }
    },
    methods:{
        getData(){
            axios.get('/customers')
            .then(res => {
                this.customersdata = res.data;
            })
            .catch(err => {
                console.log(err);
            })
        }
    }
}
</script>

<style scoped>

</style>
