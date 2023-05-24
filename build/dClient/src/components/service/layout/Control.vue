<template lang="pug">
  div(class="ServiceLayoutControl")
    UFlex(class="Content" align="center")
      UFlex(
        class="mx-1" 
        type="column" 
        align="center" 
        v-for="item in list" :key="item.icon" 
        @click="$router.push(item.to)"
      )
        UButton(size="3rem" avatar :color="item.icon" class="mb-1")
          UIcon(:src="item.icon" size="1.3rem")
        UText(size="0.8rem" weight="500" color="gray-600" no-wrap) {{item.title}}
</template>

<script>
export default {
  props: [ 'list' ]
}
</script>

<style lang="sass">
.ServiceLayoutControl
  z-index: 1
  .Content
    background: rgb(var(--ui-content))
    padding: var(--space)
    padding-top: calc(var(--space) + 3px)
    justify-content: space-between
    box-shadow: 0 0 20px -5px rgba(0,0,0,0.1), 0 -12px 15px -10px rgba(0,0,0,0.3)
</style>