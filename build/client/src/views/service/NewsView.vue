<template lang="pug">
  div(class="NewsView" v-if="news")
    div(class="News mb-2")
      img(:src="news.img ? news.img : `${publicPath}images/news.png`" alt="news")
      div(class="News__Content")
        UText(size="1rem" weight="700" mini) {{ news.title }}
        UText(size="0.8rem" color="gray-600" mini) {{ news.description }}
      UChip(class="News__Time") {{ $utils.getTime(news.update_time).from }}
    UCard(class="Content")
      div(v-html="news.content")
</template>

<script>
export default {
  data() {
    return {
      news: null
    }
  },

  created () {
    this.getNews()
  },

  methods: {
    async getNews () {
      const title_seo = String(this.$route.params.title)

      this.news = await this.API('getNews', {
        title_seo: title_seo
      })
    }
  },
}
</script>

<style lang="sass">
.NewsView
  .Content
    position: relative
    box-shadow: none !important
    border: none !important
    overflow: hidden
    img
      position: relative
      max-width: 90%
      margin: 0 auto
  .News
    position: relative
    display: flex
    justify-content: center
    align-items: center
    border-radius: var(--radius)
    overflow: hidden
    cursor: pointer
    box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
    img
      width: 100%
      aspect-ratio: 16 / 9
      object-fit: cover
    &__Content
      position: absolute
      bottom: 0
      left: 0
      width: 100%
      padding: var(--space)
      background: rgba(var(--ui-content), 0.8)
      z-index: 1
      .UiText:first-child
        text-transform: capitalize
        margin-bottom: 1px
    &__Time
      position: absolute
      top: var(--space)
      right: var(--space)
</style>