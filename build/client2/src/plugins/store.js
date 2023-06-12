import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    config: null,

    user: {
      isLogin: false,
      profile: null 
    },

    notifies: [],

    notifiesSocket: [],

    loading: false,
  },

  mutations: {
    setLoading (state, data) {
      state.loading = data
    },

    setConfig (state, config) {
      state.config = config
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
    
    removeNotify (state, index){
      state.notifies.splice(index, 1);
    },

    addNotifySocket (state, notify) {
      state.notifiesSocket.push(notify)
    },

    removeNotifySocket (state, index){
      state.notifiesSocket.splice(index, 1);
    }
  }
})
