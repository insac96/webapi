<template lang="pug">
  div(class="WebNotifySocket")
    transition(name="zoom")
      div(class="Content" v-if="anim") 
        UText(no-wrap size="0.9rem" weight="700" :class="{'Anim' : !!anim}" ref="text") {{ text }}
</template>

<script>
export default {
  data() {
    return {
      text: null,
      anim: null
    }
  },

  watch: {
    storeNotifySocket () {
      this.getText()
    }
  },

  methods: {
    getText () {
      if(!!this.anim) return
      if(this.storeNotifySocket.length == 0) return this.close()

      this.text = this.storeNotifySocket[0]['text']
      this.anim = setTimeout(() => {
        this.close()
        setTimeout(() => this.$store.commit('removeNotifySocket', 0), 100)
      }, 10000)
    },

    close () {
      if(!!this.anim){
        clearTimeout(this.anim)
        this.anim = null
      }
    }
  },
}
</script>

<style lang="sass">
.WebNotifySocket
  position: fixed
  top: calc(var(--header) - var(--space))
  left: 0
  width: 100%
  height: auto
  z-index: 999999
  display: flex
  align-items: center
  justify-content: center
  .Content
    min-width: 200px
    max-width: 600px
    background: rgba(var(--ui-primary), 0.5)
    color: rgba(var(--ui-white), 1)
    backdrop-filter: blur(15px)
    padding: var(--space)
    border-radius: var(--radius)
    text-align: center
    overflow: hidden
    white-space: nowrap
    .UiText
      transform: translateX(calc(100% + var(--space)))
  .Anim
    animation: text-notify 10s linear forwards
  @keyframes text-notify
    from
      transform: translateX(calc(100% + var(--space)))
    to
      transform: translateX(calc(-100% - var(--space)))
</style>