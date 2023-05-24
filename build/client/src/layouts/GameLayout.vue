<template lang="pug">
  div(class="GameLayout")
    LayoutHeader(@menu="open = !open")
    LayoutMenu(:open.sync="open")
    LayoutIframe
    GameRecharge
    WebNotify
</template>

<script>
import LayoutHeader from '@/components/game/layout/Header.vue'
import LayoutMenu from '@/components/game/layout/Menu.vue'
import LayoutIframe from '@/components/game/layout/Iframe.vue'
import GameRecharge from '@/components/game/Recharge.vue'
import WebNotify from '@/components/Notify.vue'

export default {
  components: {
    LayoutHeader,
    LayoutMenu,
    LayoutIframe,
    GameRecharge,
    WebNotify
  },
  
  data() {
    return {
      open: false
    }
  },

  created() {
    this.checkAuth()
  },

  methods: {
    checkAuth () {
      const token = this.$utils.getCookie('token')
      if(!token) return this.$router.push('/sign-in')
      this.getUser()
    }
  },
}
</script>

<style lang="sass">
.GameLayout
  position: fixed
  display: flex
  align-items: center
  justify-content: center
  flex-direction: column
  top: 0
  left: 0
  width: 100%
  height: 100%
  overflow: hidden
</style>