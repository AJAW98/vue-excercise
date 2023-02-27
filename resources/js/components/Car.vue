<template>
    <div>
        
        <div v-if="edit">
            
            <b-form @submit="submit">
                <b-form-group id="input-group-2" label="Make:" label-for="car-make">
                    <b-form-input
                    id="car-make"
                    v-model="car.make"
                    placeholder="Enter car name"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Model:" label-for="car-model">
                    <b-form-input
                    id="car-model"
                    v-model="car.model"
                    placeholder="Enter car name"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Year:" label-for="car-year">
                    <b-form-input
                    id="car-year"
                    v-model="car.year"
                    placeholder="Enter car year"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Owner First Name:" label-for="car-owner-name">
                    <b-form-input
                    id="car-owner-name"
                    v-model="owner"
                    placeholder="Enter car owner's full name"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Owner Address:" label-for="car-address">
                    <b-form-input
                    id="car-owner-last-name"
                    v-model="address"
                    placeholder="Enter car owner's address"
                    required
                    ></b-form-input>
                </b-form-group>
                <b-button type="submit" variant="primary">Save</b-button>
            </b-form>
        </div>
        <div v-if="!edit">
            <b-button @click="back()">Go Back</b-button>
            <p>Make: {{ car.make }}</p>
            <p>Model: {{ car.model }}</p>
            <p>Year: {{ car.model }}</p>
            <p>Owner Name: {{ owner }}</p>
            <p>Owner Address: {{ address }}</p>
        </div>
    </div>
</template>

<script>
export default {

    props: {
        car: {
            type: Object
        },
        edit: {
            type: Boolean
        }
    },
    computed: {
        address: {
            get() {
                return `${this.car.address.address}, ${this.car.address.city}, ${this.car.address.country}, ${this.car.address.postal_code}`
            },
            set(address) {
                [this.car.address.address, this.car.address.city, this.car.address.country, this.car.address.postal_code] = address.split(', ')
            }
        },
        owner: {
            get() {
                return `${this.car.owner.first_name} ${this.car.owner.last_name}`
            },
            set(name) {
                [this.car.owner.first_name, this.car.owner.last_name] = name.split(' ');
            }
        }
    },
    methods: {

        submit() {
            this.$emit('save', this.car)
        },

        back() {
            this.$emit('back')
        },

    }
}
</script>
