<template>
    <div>
        <h1>Hi {{account.user.name}}!</h1>
        <p>You're logged in Scopic Auction Storefront</p>
        <p>
            <router-link to="/">Home</router-link>
            <router-link to="/profile">Profile</router-link>
            <router-link to="/login">Logout</router-link>
        </p>
        <h3>Item {{item.item != null ? item.item.name : ''}}</h3>
        <em v-if="item.loading">Loading item...</em>
        <span v-if="item.error" class="text-danger">ERROR: {{item.error}}</span>
        <img style="width:200px" v-if="item.item != undefined" v-bind:src="item.item.image" />
        <br/>
        <span>{{item.item != null ? item.item.desc : ''}}</span>
        <div class="" v-if="item.bid != undefined">
            <span 
            v-bind:class="{ 'text-success': item.bid.status == 'In Progress', 'text-danger': item.bid.status == 'Completed' }" >
            Auction Status: {{item.bid.status}} - 
            Closed Date: {{item.bid.closed_date}}
            </span>
            <!--<span v-if="item.bid.status == 'In Progress'"> - 
            Count Down:
            </span>
            <input v-model="org_second" />-->
            <hr/>
            <!-- Section Winner -->
            <span v-if="item.bid.status == 'Completed' && item.bid_detail != undefined">
                Winner: {{item.bid_detail[0].user}} - {{item.bid_detail[0].price}}$ - {{item.bid_detail[0].created_at}}
            </span>
            <!-- Section Winner -->
        </div>

        <hr/>
        <!--  Section Bid -->
        <div v-if="item.bid != undefined && item.bid.status == 'In Progress'">
            <form @submit.prevent="handleSubmit">
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" v-model="price" name="price" class="form-control" :class="{ 'is-invalid': submitted && !price }" />
                    <div v-show="submitted && !price" class="invalid-feedback">Price is required</div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" :disabled="status.bidding">Bid</button>
                    <img v-show="status.bidding" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
                </div>
            </form>
        </div>
        <!--  Section Bid -->
        <!--  Section Bid History -->
        <table class="table table-striped" v-if="item.bid_detail != undefined && item.bid != undefined && item.bid.status =='In Progress'">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr
                 v-bind:class="{ 'table-success': bd.user_id == account.user.id}"
                 v-for="bd in item.bid_detail" :key="bd.price">
                    <td>{{bd.user}}</td>
                    <td>{{bd.price}}$</td>
                    <td>{{bd.created_at}}</td>
                </tr>
            </tbody>
        </table>
        <!--  Section Bid History -->
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
    data () {
        return {
            price: '',
            item_id: this.$route.params.item_id,
            submitted: false,
        }
    },
    computed: {
        ...mapState({
            account: state => state.account,
            item: state => state.item.detail,
            status: state => state.item.status,
        })
    },
    created () {
        this.detailItem(this.$route.params.item_id);
    },
    methods: {
        ...mapActions('item', {
            detailItem: 'detailItem',
            bid: 'bid'
        }),
        handleSubmit (e) {
            this.submitted = true;
            const { price, item_id} = this;
            if (price && item_id) {
                this.bid({ price, item_id })
            }
        }
    }
};
</script>