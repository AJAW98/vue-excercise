<template>
    <div>
        
        <div v-if="edit">
            
            <b-form @submit="submit">
                <b-form-group id="input-group-2" label="Address:" label-for="address-address">
                    <b-form-input
                    id="address-address"
                    v-model="address.address"
                    placeholder="Enter first line address"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Postal Code:" label-for="address-postal">
                    <b-form-input
                    id="address-postal"
                    v-model="address.postal_code"
                    placeholder="Enter postal code"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="City:" label-for="address-city">
                    <b-form-input
                    id="address-city"
                    v-model="address.city"
                    placeholder="Enter city"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Country:" label-for="address-country">
                    <b-form-input
                    id="address-country"
                    v-model="address.country"
                    placeholder="Enter country"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-button type="submit" variant="primary">Save</b-button>
            </b-form>
        </div>
        <div v-if="!edit">
            <b-button @click="back()">Go Back</b-button>
            <p>Address: {{ address.address }}</p>
            <p>Owner Name: {{ owner }}</p>
            
            <div v-if="cars.length > 0">
                <h2>Cars</h2>
                <p>Amount: {{ address.cars_count }}</p>

                <template v-for="car in cars">
                    <p>Make: {{ car.make }}</p>
                    <p>Model: {{ car.model }}</p>
                    <p>Year: {{ car.model }}</p>
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
            cars: []
        }
    },

    props: {
        address: {
            type: Object
        },
        edit: {
            type: Boolean
        }
    },
    computed: {
        fullAddress: {
            get() {
                return `${this.address.address}, ${this.car.address.city}, ${this.car.address.country}, ${this.car.address.postal_code}`
            },
            set(address) {
                [this.car.address.address, this.car.address.city, this.car.address.country, this.car.address.postal_code] = address.split(', ')
            }
        },
        owner: {
            get() {
                return `${this.address.owner.first_name} ${this.address.owner.last_name}`
            },
            set(name) {
                [this.address.owner.first_name, this.address.owner.last_name] = name.split(' ');
            }
        }
    },
    methods: {
        showCars: function () {
            axios.get('/car').then(function (res) {
                console.log(`address id: ${this.address.id}`)
                console.log(res)
                this.cars = res.data.filter(car => car.address_id == this.address.id)
                console.log(this.cars)
            }.bind(this));
        },
        submit() {
            this.$emit('save', this.address)
        },

        back() {
            this.$emit('back')
        },

    },
    created: function () {
        this.showCars()
    }
}
</script>
