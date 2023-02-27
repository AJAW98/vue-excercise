<template>
    <div>


        <Delete v-if="state === 'delete'" title="Confirm delete" subtitle="Are you sure you want to delete the owner?" @confirm="confirmDelete" @cancel="viewTable"/>


        <div v-if="state === 'table'">
            <b-table id="owners-table" striped :items="items" :fields="fields" :currentPage="page" :perPage="perPage" :filter="filter">
        
                <template #cell(actions)="data">
                    <TableButtonsComponent @edit="editRow(data.item)" @delete="deleteOwner(data.item)" @view="viewRow(data.item)"/>
                </template>

                <template #cell(owner)="data">
                    {{ data.item.owner.first_name }} {{data.item.owner.last_name}}
                </template>

                <template #cell(address)="data">
                    {{ data.item.address }} <br> {{ data.item.city }} <br> {{ data.item.country }} <br> {{ data.item.postal_code }}
                </template>
            
            </b-table>

            <b-pagination
                v-model="page"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="owners-table"
            ></b-pagination>
            

        </div>



        <Owner v-if="state === 'view'" @back="viewTable()" @save="saveOwner" :owner="selected" :edit="edit"/>
    </div>
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";
import Owner from './Owner.vue';
import Delete from './Delete.vue';

//Used this library for popups, not needed
//import Swal from 'sweetalert2'


export default {
    data() {
        return {

            //Table headers
            fields: [
                { key: 'id', label: "ID"},
                { key: 'first_name', label: "First Name"},
                { key: 'last_name', label: "Last Name"},
                { key: 'addresses_count', label: "Addresses"},
                { key: 'cars_count', label: "Cars"},
                { key: 'actions', label: "Actions"}
            ],
            items: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true,
            selected: null,
            state: 'table',
            edit: false
            
        }
    },
    computed: {
        //Calculates length of items
        rows() {
            return this.items.length
        }
    },
    methods: {
        showOwners: function () {
            axios.get('/owner').then(function (res) {
                this.items = res.data.map(o => ({...o, 'type': 'owner'}));
            }.bind(this));
        },

        //Updates edit flag, stores current row and switches to view state
        viewRow: function(row) {
            console.log(row)
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

        //After clicking save, switches to table view and sends a request to update the owner
        saveOwner: function(owner) {
            this.viewTable();
            axios.put(`/owner/${owner.id}`, owner);
        },

        //Stores owner in 'seleted' and updates the state to show the delete confirmation
        deleteOwner: function(owner) {
            this.selected = owner
            this.state = 'delete'
        },

        confirmDelete: function() {
            
            axios.delete(`/owner/${this.selected.id}`).then(function (res) {
                this.items = this.items.filter(x => x.id != this.selected.id);
                this.selected = null
            }.bind(this));

            this.state = 'table'

        },
        // confirmDelete: function(owner) {

        //     Swal.fire({
        //         title: 'Are you sure you want to delete this owner?',
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
        //             axios.delete(`/owner/${owner.id}`).then(function (res) {
        //                 if (res.status === 204) {
        //                     this.items = this.items.filter(x => x.id != owner.id);
        //                     Swal.fire('Owner deleted', '', 'success');
        //                 }
        //                 else Swal.fire('Something went wrong...', '', 'error');
        //             }.bind(this));
                    
        //         }
        //     })
            

        // },
        viewTable: function() {
            this.selected = null
            this.state = 'table'
        }
    },
    
    created: function () {
        this.showOwners()
    }
}
</script>
