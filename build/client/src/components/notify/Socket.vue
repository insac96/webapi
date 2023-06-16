<template lang="pug">
  div(:class="`WebNotifySocket WebNotifySocket--${!!game ? 'game' : 'default'}`")
    transition(name="notify-socket")
      UFlex(
        v-if="notify"
        :class="classEffect"
        :style="styleEffect"
        align="center"
      ) 
        div(class="Notify__Content") 
          UText(weight="600" size="0.85rem") {{ notify.content }}
        img(:src="effectData.img" :width="effectData.w" :height="effectData.h")
</template>

<script>
export default {
  props: {
    game: { type: Boolean } 
  },

  data() {
    return {
      notify: null,

      config: {
        'car': { w: 'auto', h: '60px', tx: '75%', color: '178,13,22' },
        'plane': { w: 'auto', h: '70px', tx: '60%', color: '68,135,192' },
        'dragon': { w: 'auto', h: '110px', tx: '60%', color: '255,89,17' },
        'phoenix': { w: 'auto', h: '140px', tx: '65%', color: '190,49,11' },
        'unicorn': { w: 'auto', h: '120px', tx: '60%', color: '126,50,80' },
        'tiger': { w: 'auto', h: '100px', tx: '50%', color: '61,59,61' },
        'lion': { w: 'auto', h: '100px', tx: '60%', color: '232,174,69' },
        'wolf': { w: 'auto', h: '110px', tx: '60%', color: '71,85,155' },
      }
    }
  },

  computed: {
    effectData () {
      if(!this.notify) return null

      const effect = this.notify.effect
      const isVIP = effect.includes('vip')
      const isADMIN = effect.includes('admin')

      if(!!isVIP){
        const num = effect.split('-')[1]
        return {
          type: 'vip',
          img: `${this.publicPath}images/avatar/${num}.webp`,
          w: '45px',
          h: '45px',
          tx: '50%',
          color: `--ui-vip-${num}`,
        }
      }
      else if(!!isADMIN){
        return {
          type: 'admin',
          img: `${this.publicPath}images/effect/admin.png`,
          w: 'auto',
          h: '80px',
          tx: '60%',
          color: `--ui-type-2`,
        }
      }
      else {
        return {
          type: 'custom',
          img: `${this.publicPath}images/effect/${effect}.png`,
          ...this.config[effect]
        }
      }
    },

    styleEffect () {
      if(!this.effectData) return {}
      return {
        '--ui-notify-color': this.effectData.type == 'custom' ? this.effectData.color : `var(${this.effectData.color})`,
        '--ui-notify-img-x': this.effectData.tx
      }
    },

    classEffect () {
      if(!this.effectData) return {}
      return {
        'Notify': true,
        'Notify--VIP': this.effectData.type == 'vip',
        'Notify--ADMIN': this.effectData.type == 'admin',
        'Notify--CUSTOM': this.effectData.type == 'custom'
      }
    }
  },

  watch: {
    storeNotifySocket () {
      this.getNewNotify()
    },
  },

  methods: {
    getNewNotify () {
      if(!!this.notify) return
      if(this.storeNotifySocket.length == 0) return
      this.notify = this.storeNotifySocket[0]

      setTimeout(() => {
        const index = this.storeNotifySocket.findIndex((notify) => notify.id == this.notify.id)
        this.notify = null
        setTimeout(() => this.$store.commit('removeNotifySocket', index), 1000)
      }, this.notify.dup)
    }
  },
}
</script>

<style lang="sass">
.WebNotifySocket
  position: fixed
  left: var(--space)
  width: auto
  height: auto
  display: inline-flex
  align-items: center
  justify-content: center
  z-index: 999999
  &--game
    top: calc(var(--header) + var(--space))
  &--default
    top: calc(0 + var(--space))
    @media (max-width: 576px)
      top: calc(var(--header) + var(--space))

  .Notify
    position: relative
    &--VIP
      img
        border-radius: 50%
        box-shadow: 0px 0px 15px -5px rgba(0,0,0,0.4)
    img
      position: absolute
      right: 0
      z-index: 1
      transform: translateX(calc(var(--ui-notify-img-x) + var(--space)))
    &__Content
      display: flex
      align-items: center
      max-width: 280px
      min-height: 38px
      background-image: linear-gradient(0deg, rgb(var(--ui-notify-color)), rgba(var(--ui-notify-color), 0.8))
      color: rgb(var(--ui-light))
      padding: var(--space)
      padding-right: calc(var(--space) * 2)
      transform: skewX(-3deg)
      border-radius: var(--radius)
      box-shadow: 0px 0px 15px -5px rgba(0,0,0,0.4)

  @keyframes notify-socket 
    0%
      opacity: 0
      transform: translateX(-50%)
    100%
      opacity: 1
      transform: translateX(0)

  .notify-socket-enter-active 
    animation: notify-socket .25s ease forwards
  .notify-socket-leave-active 
    animation: notify-socket .25s reverse ease forwards
</style>