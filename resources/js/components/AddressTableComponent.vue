<template>
    <div>

        <Delete v-if="state === 'delete'" title="Confirm delete" subtitle="Are you sure you want to delete the address?" @confirm="confirmDelete" @cancel="viewTable"/>
        <div v-if="state === 'table'">

            <b-table id="addresses-table" striped :items="items" :fields="fields" :currentPage="page" :perPage="perPage" :filter="filter">
                
                <template #cell(actions)="data">
                    <TableButtonsComponent @edit="editRow(data.item)" @delete="deleteAddress(data.item)" @view="viewRow(data.item)"/>
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
                aria-controls="addresses-table"
            ></b-pagination>
            

        </div>
        <Address v-if="state === 'view'" @back="viewTable()" @save="saveAddress" :address="selected" :edit="edit"/>


    </div>
    
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";
import Address from './Address.vue';
import Delete from './Delete.vue';

//import Swal from 'sweetalert2'

export default {
    data() {
        return {
            fields: [
                { key: 'id', label: "ID"},
                { key: 'owner', label: "Name"},
                { key: 'cars_count', label: "Cars"},
                { key: 'address', label: "Address"},
                { key: 'actions', label: "Actions"}
            ],
            items: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true,
            state: 'table',
            edit: false,
            selected: null
        }
    },
    computed: {
      rows() {
        return this.items.length
      }
    },
    methods: {
        showAddresses: function () {
            axios.get('/address').then(function (res) {
                this.items = res.data.map(o => ({...o, 'type': 'address'}));
                console.log(this.items)
            }.bind(this));
        },
        viewRow: function(row) {
            console.log(row)
            this.edit = false;
            this.selected = row;
            this.state = 'view';
        },
        editRow: function(row) {
            this.selected = row;
            this.edit = true;
            this.state = 'view';
        },
        saveAddress: function(address) {
            this.viewTable();
            axios.put(`/address/${address.id}`, address);
        },

        //Stores address in 'seleted' and updates the state to show the delete confirmation
        deleteAddress: function(address) {
            this.selected = address
            this.state = 'delete'
        },

        //Is called when confirmed the deletion
        confirmDelete: function() {
            
            axios.delete(`/address/${this.selected.id}`).then(function (res) {
                this.items = this.items.filter(x => x.id != this.selected.id);
                this.selected = null
            }.bind(this));

            this.state = 'table'

        },
        
        
        
        // confirmDelete: function(address) {

        //     Swal.fire({
        //         title: 'Are you sure you want to delete this address?',
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
        //             axios.delete(`/address/${address.id}`).then(function (res) {
        //                 if (res.status === 204) {
        //                     this.items = this.items.filter(x => x.id != address.id);
        //                     Swal.fire('Address deleted', '', 'success');
        //                 }
        //                 else Swal.fire('Something went wrong...', '', 'error');
        //             }.bind(this));
                    
        //         }
        //     })
            

        // },
        viewTable: function() {
            this.selected = null;
            this.state = 'table';
        },
    },
    
    created: function () {
        this.showAddresses()
    }
}
</script>
