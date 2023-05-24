<template lang="pug">
  div(class="ServiceLayoutFooter")
    UFlex(justify="flex-end" align="center")
      div(@click="openLink(storeConfig.fanpage_link)" class="Link")
        img(:src="`${publicPath}images/social/facebook.png`" alt="facebook")
      div(@click="openLink(storeConfig.messenger_link)" class="Link")
        img(:src="`${publicPath}images/social/messenger.png`" alt="messenger")
      div(@click="openLink(storeConfig.zalo_link)" class="Link")
        img(:src="`${publicPath}images/social/zalo.png`" alt="zalo")
</template>

<script>
export default {
  methods: {
    openLink (link) {
      if(!link) return
      window.open(link, '_blank')
    },
  },
}
</script>

<style lang="sass">
.ServiceLayoutFooter
  position: absolute
  bottom: 3px
  right: var(--space)
  .Link
    cursor: pointer
    margin: 0 3px
    &:last-child
      margin-right: 0
    img
      width: 35px
      height: 35px
  @media (min-width: 769px)
    position: fixed
</style>