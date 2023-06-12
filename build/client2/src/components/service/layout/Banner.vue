<template lang="pug">
  div(class="ServiceLayoutBanner")
    div(class="Banner")
      img(:src="banner" alt="banner")
    div(class="Play bounce-anim" @click="$router.push('/game')")
      img(:src="`${publicPath}images/play.png`" alt="banner")
</template>

<script>
export default {
  computed: {
    banner () {
      if(!this.storeConfig || !this.storeConfig.game_banner) return `${this.publicPath}images/banner.png`
      return this.storeConfig.game_banner
    }
  },
}
</script>

<style lang="sass">
.ServiceLayoutBanner
  position: relative
  display: flex
  flex-direction: column
  align-items: center
  justify-content: center
  width: 100%
  overflow: hidden
  aspect-ratio: 16 / 6
  .Banner
    width: 100%
    height: 100%
    img
      width: 100%
      height: 100%
      object-fit: fill
    &::after
      position: absolute
      content: ''
      top: 0
      left: 0
      width: 100%
      height: 100%
      background: rgba(0,0,0,0.1)
  .Play
    position: absolute
    border-radius: 50%
    width: 180px
    img
      width: 100%
</style>