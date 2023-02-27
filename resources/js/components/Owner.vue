<template>
    <div>
        <div v-if="edit">
            
            <b-form @submit="submit">
                <b-form-group id="input-group-2" label="First Name:" label-for="owner-first-name">
                    <b-form-input
                    id="owner-first-name"
                    v-model="owner.first_name"
                    placeholder="Enter first name"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Last Name:" label-for="owner-last-name">
                    <b-form-input
                    id="owner-last-name"
                    v-model="owner.last_name"
                    placeholder="Enter last name"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-button type="submit" variant="primary">Save</b-button>
            </b-form>
        </div>
        <div v-if="!edit">
            <b-button @click="back()">Go Back</b-button>
            <p>First Name: {{ owner.first_name }}</p>
            <p>Last Name: {{ owner.last_name }}</p>
            
            <div v-if="cars.length > 0">
                <h2>Cars</h2>
                <p>Amount: {{ cars.length }}</p>

                <template v-for="car in cars">
                    <p>Make: {{ car.make }}</p>
                    <p>Model: {{ car.model }}</p>
                    <p>Year: {{ car.model }}</p>
                    </br>
                </template>
            </div> 

             <div v-if="addresses.length > 0">
                <h2>Addresses</h2>
                <p>Amount: {{ addresses.length }}</p>

                <template v-for="address in addresses">
                    <p>{{ address.address }}, {{ address.city }}, {{ address.postal_code }}, {{ address.country }}</p>
                    </br>
                </template>
            </div> 
        </div>
    </div>
</template>

<script>

export default {

    data() {
        return {
            cars: [],
            addresses: []
        }
    },

    props: { 
        owner: {
            type: Object
        },
        edit: {
            type: Boolean
        }
    },
    methods: {
        showAddresses: function () {
            axios.get('/address').then(function (res) {
                this.addresses = res.data.filter(address => address.owner_id == this.owner.id)
            }.bind(this))
        },
        showCars: function () {
            axios.get('/car').then(function (res) {
                this.cars = res.data.filter(car => car.owner_id == this.owner.id)
            }.bind(this))
        },
        submit() {
            this.$emit('save', this.owner)
        },
        back() {
            this.$emit('back')
        },
    },
    created: function () {
        this.showAddresses()
        this.showCars()
    }
}
</script>
