import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: {
      isLogin: false,
      profile: null 
    },

    notifies: [],

    loading: false,
  },

  mutations: {
    setLoading (state, data) {
      state.loading = data
    },

    setUser (state, profile) {
      if(!!profile){
        state.user.isLogin = true
        state.user.profile = profile
      }
      else {
        state.user.isLogin = false
        state.user.profile = null
      }
    },

    addNotify (state, notify) {
      state.notifies.push(notify)
    },
    
    removeNotify(state, index){
      state.notifies.splice(index, 1);
    }
  }
})
