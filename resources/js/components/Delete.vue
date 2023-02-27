<template>
    <div>
        <h2>{{title}}</h2>
        <p>{{subtitle}}</p>
        <b-button @click="confirm" variant="primary">Confirm</b-button>
        <b-button @click="cancel" variant="secondary">Cancel</b-button>
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
        title: {
            type: String
        },
        subtitle: {
            type: String
        }
    },
    methods: {
        confirm() {
            this.$emit('confirm')
        },

        cancel() {
            this.$emit('cancel')
        },

    }
}
</script>
