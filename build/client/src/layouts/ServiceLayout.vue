<template lang="pug">
  div(class="ServiceLayout")
    LayoutHeader(@menu="open = !open")
    LayoutSidebar(:list="menu" :open.sync="open")
    LayoutBanner
    LayoutControl(:list="menu")

    div(class="ServiceLayoutView")
      transition(name="up" mode="out-in")
        router-view
      LayoutFooter

    WebNotify
</template>

<script>
import LayoutHeader from '@/components/service/layout/Header.vue'
import LayoutSidebar from '@/components/service/layout/Sidebar.vue'
import LayoutBanner from '@/components/service/layout/Banner.vue'
import LayoutControl from '@/components/service/layout/Control.vue'
import LayoutFooter from '@/components/service/layout/Footer.vue'
import WebNotify from '@/components/Notify.vue'

export default {
  components: {
    LayoutHeader,
    LayoutSidebar,
    LayoutBanner,
    LayoutControl,
    LayoutFooter,
    WebNotify
  },
  
  data() {
    return {
      menu: [
        { title: 'Nạp Xu', icon: 'pay', to: '/pay' },
        { title: 'Cửa Hàng', icon: 'shop', to: '/shop' },
        { title: 'Sự Kiện', icon: 'event', to: '/event' },
        { title: 'Nhiệm Vụ', icon: 'mission', to: '/mission' },
        { title: 'Vòng Quay', icon: 'wheel', to: '/wheel' },
        { title: 'GiftCode', icon: 'giftcode', to: '/giftcode' },
      ],

      open: false
    }
  },

  created() {
    this.checkAuth()
  },

  methods: {
    checkAuth () {
      const noCheck = ["/sign-in", "/sign-up", "/forgot"]
      const token = this.$utils.getCookie('token')
      if(noCheck.includes(this.$route.path)) return
      if(!token) return this.$store.commit('setUser', null)
      this.getUser()
    }
  },
}
</script>

<style lang="sass">
.ServiceLayout
  position: relative
  width: 750px
  max-width: 100%
  min-height: 100%
  margin: 0 auto
  background: rgb(var(--ui-background))
  //box-shadow: 0 20px 27px #0000000d
  .ServiceLayoutView
    padding: var(--space)
    padding-bottom: 60px
    @media (min-width: 769px)
      padding-bottom: var(--space)
</style>