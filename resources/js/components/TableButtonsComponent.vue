<template>
    <div>
        <button class="btn btn-primary" @click="view()">View</button>
        <button class="btn btn-primary">Edit</button>
        <button class="btn btn-danger" @click="confirmDelete(row.id, row.type)">Delete</button>
    </div>
</template>


<script>


import Swal from 'sweetalert2'


export default {  

    props: {
        row: {
            type: Object
        }
    },
    methods: {



        view() {

            this.$emit('rowView', this.row)

        },
        confirmDelete(id, type) {

            console.log(type);
            
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms the deletion, call the delete API endpoint
                axios.delete(`/${type}/${id}`)
                .then(response => {
                    // Reload the page
                    //TODO: Remove the entry from the datatable without reloading the page
                    this.$router.go()
                })
                .catch(error => {
                    console.error(error)
                    Swal.fire(
                    'Error!',
                    `There was an error deleting the ${type}.`,
                    'error'
                    )
                })
            }
        })
    }
    },
}
</script>
