import { itemService } from '../_services';

const state = {
    all: {},
    detail: {},
    bid: {},
    status: {},
    all_bid_item: {},
    all_awarded_item: {},
};

const actions = {
    bid({ dispatch, commit }, { price, item_id }) {
        commit('bidRequest', { price, item_id });
    
        itemService.bid(price, item_id)
            .then(
                message => {
                    commit('bidSuccess', message);
                    setTimeout(() => {
                        // display success message after route change completes
                        dispatch({
                            type: 'detailItem',
                            item_id: item_id
                          });
                        dispatch('alert/success', 'Bid successful', { root: true });
                    })
                    // router.push('/');
                },
                error => {
                    commit('bidFailure', error);
                    // console.log(error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    listBidItem({ commit }) {
        commit('getAllBidItemRequest');
        itemService.listBidItem()
            .then(
                items => commit('getAllBidItemSuccess', items.data),
                error => commit('getAllBidItemFailure', error)
            );
    },
    listItemAwarded({ commit }) {
        commit('getAllItemAwardedRequest');
        itemService.listItemAwarded()
            .then(
                items => commit('getAllItemAwardedSuccess', items.data),
                error => commit('getAllItemAwardedFailure', error)
            );
    },
    listItem({ commit }) {
        commit('getAllItemRequest');
        itemService.listItem()
            .then(
                items => commit('getAllItemSuccess', items.data),
                error => commit('getAllItemFailure', error)
            );
    },
    detailItem({ commit }, item_id) {
        commit('getItemRequest');
        itemService.detailItem(item_id)
            .then(
                item => commit('getItemSuccess', item.data),
                error => commit('getItemFailure', error)
            );
    },
};

const mutations = {
    getAllItemAwardedRequest(state) {
        state.all_awarded_item = { loading: true };
    },
    getAllItemAwardedSuccess(state, items) {
        state.all_awarded_item = items;
    },
    getAllItemAwardedFailure(state, error) {
        state.all_awarded_item = { error };
    },
    getAllBidItemRequest(state) {
        state.all_bid_item = { loading: true };
    },
    getAllBidItemSuccess(state, items) {
        state.all_bid_item = items;
    },
    getAllBidItemFailure(state, error) {
        state.all_bid_item = { error };
    },
    bidRequest(state, message) {
        state.status = { bidding: true };
        state.bid = message;
    },
    bidSuccess(state, message) {
        state.status = { bidding: false };
        state.message = message;
    },
    bidFailure(state) {
        state.status = {};
        state.message = null;
    },
    getAllItemRequest(state) {
        state.all = { loading: true };
    },
    getAllItemSuccess(state, items) {
        state.all = items;
    },
    getAllItemFailure(state, error) {
        state.all = { error };
    },
    getItemRequest(state) {
        state.detail = { loading: true };
    },
    getItemSuccess(state, item) {
        state.detail = item;
    },
    getItemFailure(state, error) {
        state.detail = { error };
    },
};

export const item = {
    namespaced: true,
    state,
    actions,
    mutations
};