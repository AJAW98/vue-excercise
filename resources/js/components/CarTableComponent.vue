<template>
    <div> 
        <div v-if="tableView">

            <b-table id="cars-table" striped :items="items" :fields="fields" :currentPage="page" :perPage="perPage" :filter="filter">
                
                <template #cell(actions)="data">
                    <TableButtonsComponent @edit="editRow(data.item)" @delete="confirmDelete(data.item)" @view="viewRow(data.item)"/>
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
        <car v-if="!tableView" @back="viewTable()" :car="selected" :edit="edit"></car>
    </div>
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";
import Car from './Car.vue';

export default {


    data() {
        return {
            // columns: [
            //     {
            //         label: 'ID',
            //         field: 'id',
            //         align: 'center'
            //     },
            //     {
            //         label: 'Make',
            //         field: 'make',
            //         headerAlign: 'left',
            //         align: 'left'
            //     },
            //     {
            //         label: 'Model',
            //         field: 'model',
            //         headerAlign: 'left',
            //         align: 'left'
            //     },
            //     {
            //         label: 'Year',
            //         field: 'year',
            //         headerAlign: 'left',
            //         align: 'left'
            //     },

            //     //Adds name column with owner's concatenated name
            //     {
            //         label: 'Owner',
            //         field: 'owner',
            //         headerAlign: 'left',
            //         align: 'left',
            //         interpolate: true,
            //         representedAs: function (r) {
            //             return r.owner.first_name + '<br>' + r.owner.last_name;
            //         }
            //     },

            //     //Adds address column from the address object in the response

            //     {
            //         label: 'Address',
            //         field: 'address',
            //         headerAlign: 'left',
            //         align: 'left',
            //         interpolate: true,
            //         representedAs: function (r) {
            //             return r.address.address + '<br>' + r.address.city + '<br>' + r.address.country + '<br>' + r.address.postal_code;
            //         }
            //     },
            //     {
            //         label: 'Actions',
            //         headerAlign: 'right',
            //         align: 'right',
            //         component: TableButtonsComponent
            //     }
            // ],
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
        showCars: function () {
            axios.get('/car').then(function (res) {
                console.log(res.data)
                this.items = res.data.map(o => ({...o, 'type': 'car'}));
            }.bind(this));
        },
        viewRow: function(row) {
            this.edit = false;
            this.selected = row;
            this.tableView = false;

        },
         editRow: function(row) {
            this.selected = row;
            this.edit = true;
            this.tableView = false;

        },
         confirmDelete: function(row) {
            //this.selected = row;
            //this.tableView = false;
            alert('delete');

        },
        viewTable: function() {
            this.selected = null;
            this.tableView = true;
        }
    },
    created: function () {
        this.showCars()
    }
}
</script>
