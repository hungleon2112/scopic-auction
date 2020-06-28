<template>
    <div>
        <h1>Hi {{account.user.name}}!</h1>
        <p>You're logged in Scopic Auction Storefront</p>
        <p>
            <router-link to="/profile">Profile</router-link>
            <router-link to="/login">Logout</router-link>
        </p>
        <h3>Items</h3>
        <em v-if="items.loading">Loading items...</em>
        <span v-if="items.error" class="text-danger">ERROR: {{items.error}}</span>
        <table class="table table-striped" v-if="items">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Current Bid</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.name">
                    <td v-if="item.item !=undefined"><router-link :to="{ name: 'item', params: { item_id: item.item.id }}">{{item.item.name}}</router-link></td>
                    <td v-if="item.item !=undefined"><img style="width:200px" v-bind:src="item.item.image" /></td>
                    <td v-if="item.item !=undefined">{{item.bid != undefined ? item.bid.status : ''}}</td>
                    <td v-if="item.item !=undefined">{{item.bid_detail != undefined ? (item.bid_detail[0].price + '$' ) : ''}}</td>
                    <td>
                        <div v-if="item.item !=undefined && item.bid != undefined && item.bid.status == 'In Progress'">
                            <router-link :to="{ name: 'item', params: { item_id: item.item.id }}">Bid Now</router-link>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
    computed: {
        ...mapState({
            account: state => state.account,
            items: state => state.item.all
        })
    },
    created () {
        this.listItem();
    },
    methods: {
        ...mapActions('item', {
            listItem: 'listItem'
        })
    }
};
</script>