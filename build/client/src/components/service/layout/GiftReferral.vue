<template lang="pug">
  div(class="LayoutGiftReferral" v-if="gifts")
    div(class="pointer" @click="dialog = true")
      img(class="jump-anim" :src="`${publicPath}images/icon/gift_box.png`" width="50px" height="50px")

    UDialog(v-model="dialog")
      UBox(title="Quà từ người giới thiệu" width="100%")
        SelectServer(v-model="server_id" class="mb-2")
        UCard
          UFlex(wrap="wrap" justify="center" align="center")
            UItem(v-for="(item, index) in gifts" :key="index" :item="item")
        template(#footer)
          UFlex(justify="flex-end")
            UButton(@click="getGiftReferraler") Nhận
</template>

<script>
export default {
  data() {
    return {
      dialog: false,

      server_id: null
    }
  },

  computed: {
    gifts () {
      if(!this.isLogin) return null
      if(!this.storeUser) return null
      if(!this.storeUser.referraler) return null
      if(this.storeUser.get_gifts_referral == 1) return null
      
      let gifts = this.storeUser.referraler.gifts
      gifts = JSON.parse(gifts)

      if(gifts.length == 0) return null
      return gifts
    }
  },

  methods: {
    async getGiftReferraler () {
      if(!this.server_id) return this.notify('Vui lòng chọn máy chủ')
      
      const get = await this.API('getGiftReferraler', {
        server_id: this.server_id
      })

      if(!get) return
      this.getUser()
      this.dialog = false
    }
  },
}
</script>

<style lang="sass">
.LayoutGiftReferral
  position: fixed
  bottom: var(--space)
  left: calc(var(--space) * 1.5)
  z-index: 10
</style>