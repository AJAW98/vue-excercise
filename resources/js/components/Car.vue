<template>
    <div>
        <b-button @click="back()">Go Back</b-button>
        <div v-if="edit">
            
            <b-form @submit="onSubmit">
                <b-form-group id="input-group-2" label="Make:" label-for="car-make">
                    <b-form-input
                    id="car-make"
                    v-model="car.make"
                    placeholder="Enter car name"
                    required
                    ></b-form-input>
                </b-form-group>

                <b-button type="submit" variant="primary">Submit</b-button>
            </b-form>
        </div>
        <div v-if="!edit">
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
        address() {
            return `${this.car.address.address}, ${this.car.address.city}, ${this.car.address.country}, ${this.car.address.postal_code}`
        },
        owner() {
            return `${this.car.owner.first_name} ${this.car.owner.last_name}`
        }
    },
    methods: {

        onSubmit(event) {
            event.preventDefault();
            alert(JSON.stringify(this.car))
        },

        back() {
            this.$emit('back')
        },

    }
}
</script>
