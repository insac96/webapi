<template lang="pug">
  div(class="GameLayoutIframe")
    iframe(:src="src")
</template>

<script>
export default {
  computed: {
    src () {
      return (process.env.NODE_ENV == 'production') ? '/game/jump.html' : 'http://127.0.0.1:3000/game/jump.html'
    }
  },
}
</script>

<style lang="sass">
.GameLayoutIframe
  width: 100%
  height: 100%
  iframe
    width: 100%
    height: 100%
    border: none
    outline: none
</style>