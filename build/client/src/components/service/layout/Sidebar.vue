<template lang="pug">
  div(:class="classSidebar" ref="sidebar")
    UFlex(justify="center" class="mb-2")
      img(:src="logo" height="60px" width="auto" alt="logo" v-if="logo")
      UText(v-if="!logo && !!storeConfig" size="1.2rem" weight="700") {{ storeConfig.game_name }}
    UFlex(
      class="Item" 
      align="center" 
      v-for="item in listMenu" :key="item.icon" 
      @click="to(item.to)"
    )
      UButton(width="3rem" avatar :color="item.icon" class="mr-2")
        UIcon(:src="item.icon" size="1.3rem")
      UText(weight="500" no-wrap size="0.9rem") {{item.title}}
</template>

<script>
export default {
  props: {
    list: { type: Array },
    open: { type: Boolean }
  },

  data() {
    return {
      show: this.open
    }
  },

  computed: {
    classSidebar () {
      return {
        'ServiceLayoutSidebar': true,
        'ServiceLayoutSidebar--open': this.show,
      }
    },

    listMenu () {
      const list = this.list ? JSON.parse(JSON.stringify(this.list)) : []
      list.unshift({ title: 'Chơi ngay', icon: 'game', to: '/game' })
      list.unshift({ title: 'Trang chủ', icon: 'home', to: '/home' })
      list.push({ title: 'GiftCode', icon: 'giftcode', to: '/giftcode' })
      return list
    },

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
  position: fixed
  top: 0
  left: -300px
  width: 300px
  height: 100%
  background: rgba(var(--ui-content))
  padding: var(--space)
  box-shadow: 0 20px 27px #0000000d
  opacity: 0
  transition: all 0.5s ease
  z-index: 99
  .Item
    background: rgba(var(--ui-gray-100))
    border-radius: var(--radius)
    padding: calc(var(--space) * 0.5)
    margin-bottom: calc(var(--space) * 0.5)
    cursor: pointer
  &--open
    left: 0
    opacity: 1
</style>