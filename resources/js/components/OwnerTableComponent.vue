<template>
    <div>

         <div v-if="tableView">

            <b-table id="owners-table" striped :items="items" :fields="fields" :currentPage="page" :perPage="perPage" :filter="filter">
                
                <template #cell(actions)="data">
                    <TableButtonsComponent @edit="editRow(data.item)" @delete="confirmDelete(data.item)" @view="viewRow(data.item)"/>
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
        <Owner v-if="!tableView" @back="viewTable()" @save="saveOwner" :owner="selected" :edit="edit"/>
    </div>
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";
import Owner from './Owner.vue';
import Swal from 'sweetalert2'

export default {
    data() {
        return {

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
            tableView: true,
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
        showOwners: function () {
            axios.get('/owner').then(function (res) {
                
                this.items = res.data.map(o => ({...o, 'type': 'owner'}));
                console.log(this.items)
            }.bind(this));
        },
        viewRow: function(row) {
            console.log(row)
            this.edit = false;
            this.selected = row;
            this.tableView = false;
        },
        editRow: function(row) {
            this.selected = row;
            this.edit = true;
            this.tableView = false;
        },
        saveOwner: function(owner) {
            this.viewTable();
            axios.put(`/owner/${owner.id}`, owner);
        },
        confirmDelete: function(owner) {

            Swal.fire({
                title: 'Are you sure you want to delete this owner?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                customClass: {
                    actions: 'my-actions',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/owner/${owner.id}`).then(function (res) {
                        if (res.status === 204) {
                            this.items = this.items.filter(x => x.id != owner.id);
                            Swal.fire('Owner deleted', '', 'success');
                        }
                        else Swal.fire('Something went wrong...', '', 'error');
                    }.bind(this));
                    
                }
            })
            

        },
        viewTable: function() {
            this.selected = null;
            this.tableView = true;
        },
    },
    
    created: function () {
        this.showOwners()
    }
}
</script>
