<template>

    <div class="card">
        <div class="card-header">
            Add New Customers  <router-link class="btn btn-dark float-right" to="/customerlist">Back</router-link>
        </div>
        <div class="card-body">
            <form action="" method="post"  @submit.prevent="storeCustomer" @keydown="form.onKeydown($event)">
                <div class="form-group">
                    <label for="name">Customer Name</label>
                    <input type="text" name="name" class="form-control"
                           :class="{ 'is-invalid': form.errors.has('name') }" id="name" v-model="form.name">
                    <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control"
                           :class="{ 'is-invalid': form.errors.has('email') }" id="email" v-model="form.email">
                    <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control"
                           :class="{ 'is-invalid': form.errors.has('phone') }" id="phone" v-model="form.phone">
                    <has-error :form="form" field="phone"></has-error>
                </div>

                <div class="form-group">
                    <button :disabled="form.busy" type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
    </div>

</template>

<script>
export default {
    name: "CustomerComponent",
    created() {

    },
    data() {
        return {
            form: new Form({
                name: '',
                email: '',
                phone: '',
            }),
        }
    },

    methods:{
        storeCustomer(){
            this.$Progress.start()
            this.form.busy = true
            this.form.post('/customers')
                .then(response => {
                    if (this.form.successful) {
                        this.$Progress.finish()
                        Toast.fire({
                            icon: 'success',
                            title: 'Customer Saved Successfully'
                        })

                        //sleep(1);
                        this.$router.push({ path:'customerlist' })
                    } else {
                        this.$Progress.fail()
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong'
                        })
                    }
                })

                .catch(e => {
                    console.log(e)
                    this.$Progress.fail()
                })

        }
    }


}
</script>

