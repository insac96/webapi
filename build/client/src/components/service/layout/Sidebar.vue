<template lang="pug">
  div(class="ServiceLayoutSidebar" ref="sidebar")
    UFlex(justify="center" align="center" class="ServiceLayoutSidebar__Top mb-2")
      img(:src="logo" height="60px" width="auto" alt="logo" v-if="logo")
      UText(v-if="!logo && !!storeConfig" size="1.2rem" weight="700") {{ storeConfig.game_name }}
    UFlex(
      class="Item" 
      align="center" 
      v-for="item in list" :key="item.icon" 
      @click="to(item.to)"
    )
      UButton(width="3rem" avatar :color="item.icon" class="mr-2")
        UIcon(:src="item.icon" size="1.3rem")
      UText(weight="500" no-wrap size="0.9rem") {{item.title}}
</template>

<script>
export default {
  props: {
    open: { type: Boolean }
  },

  data() {
    return {
      show: this.open,
      list: [
        { title: 'Trang chủ', icon: 'home', to: '/home' },
        { title: 'Chơi ngay', icon: 'game', to: '/game' },
        { title: 'Nạp Xu', icon: 'pay', to: '/pay' },
        { title: 'Cửa Hàng', icon: 'shop', to: '/shop' },
        { title: 'Sự Kiện', icon: 'event', to: '/event' },
        { title: 'Nhiệm Vụ', icon: 'mission', to: '/mission' },
        { title: 'Vòng Quay', icon: 'wheel', to: '/wheel' },
        { title: 'Xếp Hạng', icon: 'rank', to: '/rank' },
        { title: 'GiftCode', icon: 'giftcode', to: '/giftcode' }
      ]
    }
  },

  computed: {
    logo () {
      if(!this.storeConfig || !this.storeConfig.game_logo) return null
      return this.storeConfig.game_logo
    }
  },

  watch: {
    open (val) {
      if(!!val){
        this.show = true
        window.addEventListener('click', this.clickOutside)
      }

      if(!val){
        this.show = false
        window.removeEventListener('click', this.clickOutside)
      }
    }
  },

  methods: {
    close () {
      this.$emit('update:open', false)
    },

    to (link) {
      this.close()
      this.$router.push(link)
    },

    clickOutside (event) {
      const el = this.$refs['sidebar']
      if(!el) return
      if(
        el == event.target 
        || el.contains(event.target) 
        || event.target.classList.contains('bx-menu-alt-left')
      ) return
      return this.$emit('update:open', false)
    }
  },
}
</script>

<style lang="sass">
.ServiceLayoutSidebar
  display: flex
  flex-direction: column
  background: rgb(var(--ui-content))
  padding: var(--space)
  box-shadow: 3px 0 20px -10px rgba(0,0,0,0.3)
  transition: all 0.25s ease
  overflow: hidden
  z-index: 99
  &__Top
    min-height: var(--header)
  .Item
    background: rgba(var(--ui-gray-100))
    border-radius: var(--radius)
    padding: calc(var(--space) * 0.5)
    margin-bottom: calc(var(--space) * 0.5)
    cursor: pointer
</style>