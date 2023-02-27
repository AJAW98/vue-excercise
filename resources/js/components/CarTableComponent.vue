<template>
    <div> 

        <Delete v-if="state === 'delete'" title="Confirm delete" subtitle="Are you sure you want to delete the car?" @confirm="confirmDelete" @cancel="viewTable"/>

        <div v-if="state === 'table'">

            <b-table id="cars-table" striped :items="items" :fields="fields" :currentPage="page" :perPage="perPage" :filter="filter">
                
                <template #cell(actions)="data">
                    <TableButtonsComponent @edit="editRow(data.item)" @delete="deleteCar(data.item)" @view="viewRow(data.item)"/>
                </template>

                <template #cell(owner)="data">
                    {{ data.item.owner.first_name }} {{data.item.owner.last_name}}
                </template>

                <template #cell(address)="data">
                    {{ data.item.address.address }} <br> {{ data.item.address.city }} <br> {{ data.item.address.country }} <br> {{ data.item.address.postal_code }}
                </template>
            
            </b-table>

            <b-pagination
                v-model="page"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="cars-table"
            ></b-pagination>
            

        </div>
        <car v-if="state === 'view'" @back="viewTable()" @save="saveCar" :car="selected" :edit="edit"/>
    </div>
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";
import Car from './Car.vue';
import Delete from './Delete.vue';

//import Swal from 'sweetalert2'


export default {


    data() {
        return {

            fields: [
                { key: 'id', label: "ID"},
                { key: 'make', label: "Make"},
                { key: 'model', label: "Model"},
                { key: 'year', label: "Year"},
                { key: 'owner', label: "Owner Name"},
                { key: 'address', label: "Owner Address"},
                { key: 'actions', label: "Actions"},
            ],
            items: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true,
            state: 'table',
            edit: true,
            selected: null
        }
    
    },
    computed: {
      rows() {
        return this.items.length
      }
    },
    
    methods: {
        showCars: function () {
            axios.get('/car').then(function (res) {
                console.log(res.data)
                this.items = res.data.map(o => ({...o, 'type': 'car'}));
            }.bind(this));
        },
        //Updates edit flag, stores current row and switches to view state
        viewRow: function(row) {
            this.edit = false;
            this.selected = row;
            this.state = 'view'

        },
        //Updates edit flag, stores current row and switches to view state
        editRow: function(row) {
            this.selected = row;
            this.edit = true;
            this.state = 'view'

        },
        //After clicking save, switches to table view and sends a request to update the car
        saveCar: function(car) {
            this.viewTable();
            //THIS SEEMS TO CAUSE: Call to undefined relationship [addresses] on model [App\\Models\\Car].   --- not quite what to do about it
            axios.put(`/car/${car.id}`, car);

        },

        //Stores owner in 'seleted' and updates the state to show the delete confirmation
        deleteCar: function(car) {
            this.selected = car
            this.state = 'delete'
        },
        // confirmDelete: function(car) {

        //     Swal.fire({
        //         title: 'Are you sure you want to delete this car?',
        //         showDenyButton: true,
        //         confirmButtonText: 'Yes',
        //         denyButtonText: 'No',
        //         customClass: {
        //             actions: 'my-actions',
        //             confirmButton: 'order-2',
        //             denyButton: 'order-3',
        //         }
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             axios.delete(`/car/${car.id}`).then(function (res) {
        //                 if (res.status === 204) {
        //                     this.items = this.items.filter(x => x.id != car.id);
        //                     Swal.fire('Car deleted', '', 'success');
        //                 }
        //                 else Swal.fire('Something went wrong...', '', 'error');
        //             }.bind(this));
                    
        //         }
        //     })
            

        // },
        confirmDelete: function() {
            
            axios.delete(`/car/${this.selected.id}`).then(function (res) {
                this.items = this.items.filter(x => x.id != this.selected.id);
                this.selected = null
            }.bind(this));

            this.state = 'table'

        },
        viewTable: function() {
            this.selected = null;
            this.state = 'table'
        }
    },
    created: function () {
        this.showCars()
    }
}
</script>
