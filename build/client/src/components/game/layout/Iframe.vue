<template lang="pug">
  iframe(class="GameLayoutIframe" :src="src")
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
  flex-grow: 1
  border: none
  outline: none
</style>