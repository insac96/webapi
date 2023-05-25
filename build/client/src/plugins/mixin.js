import Vue from 'vue'
import axios from 'axios'

const mixin = Vue.extend({
  computed: {
    isLoading () {
      return this.$store.state.loading
    },
    isLogin () {
      return this.$store.state.user.isLogin
    },
    storeConfig () {
      return this.$store.state.config
    },
    storeUser () {
      return this.$store.state.user.profile
    },
    storeNotify () {
      return this.$store.state.notifies
    },
    publicPath () {
      return process.env.BASE_URL
    },
    routerPath () {
      return this.$route.path
    }
  },

  methods: {
    notify (text, type = 'danger') {
      if(!text) return
      const id = (new Date()).getTime();
      this.$store.commit('addNotify', { id, text, type })
      setTimeout(() => {
        const index = this.storeNotify.findIndex((item) => item.id == id)
        this.$store.commit('removeNotify', index)
      }, 2500)
    },

    login (user) {
      this.$utils.setCookie('token', user.token)
      this.$store.commit('setUser', user)
      this.$router.push('/home')
    },

    logout () {
      this.$utils.deleteCookie('token')
      this.$store.commit('setUser', null)
      if(this.$route.path != '/sign-in') return this.$router.push('/sign-in')
    },

    goToGame () {
      if(!!this.isLogin) return this.$router.push('/game')
      this.notify('Vui lòng đăng nhập trước')
      if(this.routerPath != '/sign-in') return this.$router.push('/sign-in')
    },

    async getUser () {
      const user = await this.API('getUser')
      if(user) return this.$store.commit('setUser', user)
    },

    async getConfig () {
      const config = await this.API('getConfig')
      if(config) return this.$store.commit('setConfig', config)
    },

    API (action, obj, admin = false) {
      return new Promise(async (resolve) => {
        try {
          // Start Loading
          this.$store.commit('setLoading', true)

          // Set Data Post
          const url = process.env.NODE_ENV === 'production' ? '/api/index.php' : 'http://127.0.0.1:3000/api/index.php'
          const token = this.$utils.getCookie('token')
          
          // Post API
          const post = await axios.post(url, {
            token, 
            action, 
            data: obj || {},
            controller: !!admin ? 'admin' : 'service'
          })
          
          // End Loading
          this.$store.commit('setLoading', false)

          // Get Var
          const { code, msg, data } = post.data
          const type = (code == 200 ? 'success' : 'danger')
          this.notify(msg, type)
          
          // Check and Return
          if(code == 405) return this.logout()
          if(code == 401) return this.logout()
          if(code == 200) return resolve(data || true)
          if(code != 200) return resolve(null)
        }
        catch (e){
          this.$store.commit('setLoading', false)
          this.notify('Có lỗi xảy ra, vui lòng thử lại sau')
          resolve(null)
        }
      })
    }
  }
})

Vue.mixin(mixin)