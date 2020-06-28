<template>
    <div>
        <h1>Hi {{account.user.name}}!</h1>
        <p>You're logged in Scopic Auction Storefront</p>
        <p>
            <router-link to="/">Home</router-link>
            <router-link to="/login">Logout</router-link>
        </p>
        
        <!-- Bid Item -->
        <h3>Bid Items</h3>
        <em v-if="bid_item.loading">Loading bid items...</em>
        <span v-if="bid_item.error" class="text-danger">ERROR: {{bid_item.error}}</span>
        <table class="table table-striped" v-if="bid_item">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Closed Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in bid_item" :key="item.name">
                    <td v-if="item !=undefined"><router-link :to="{ name: 'item', params: { item_id: item.id }}">{{item.name}}</router-link></td>
                    <td v-if="item !=undefined"><img style="width:200px" v-bind:src="item.image" /></td>
                    <td v-if="item !=undefined">{{item.status}}</td>
                    <td v-if="item !=undefined">{{item.closed_date}}</td>
                    <td>
                        <div v-if="item.status == 'In Progress'">
                            <router-link :to="{ name: 'item', params: { item_id: item.id }}">Bid Now</router-link>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <!-- Awarded Item -->
        <h3>Awarded Items</h3>
        <em v-if="awarded_item.loading">Loading awarded items...</em>
        <span v-if="awarded_item.error" class="text-danger">ERROR: {{awarded_item.error}}</span>
        <table class="table table-striped" v-if="awarded_item">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Closed Date</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in awarded_item" :key="item.name">
                    <td v-if="item !=undefined"><router-link :to="{ name: 'item', params: { item_id: item.id }}">{{item.name}}</router-link></td>
                    <td v-if="item !=undefined"><img style="width:200px" v-bind:src="item.image" /></td>
                    <td v-if="item !=undefined">{{item.status}}</td>
                    <td v-if="item !=undefined">{{item.closed_date}}</td>
                    <td v-if="item !=undefined">{{item.price}}$</td>
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
            bid_item: state => state.item.all_bid_item,
            awarded_item: state => state.item.all_awarded_item,
        })
    },
    created () {
        this.listBidItem();
        this.listItemAwarded();
    },
    methods: {
        ...mapActions('item', {
            listBidItem: 'listBidItem',
            listItemAwarded: 'listItemAwarded'
        })
    }
};
</script>