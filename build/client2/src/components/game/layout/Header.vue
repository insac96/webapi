<template lang="pug">
  UFlex(class="GameLayoutHeader" align="center")
    UIcon(src="bx-menu-alt-left" size="1.5rem" color="dark" class="mr-auto" @click="$emit('menu')")
    UserCurrency(:diamond="false")
    UButton(color="danger" @click="$router.push('/')" size="33px" avatar class="ml-1")
      UIcon(src="bx-x" size="1.5rem")
</template>

<style lang="sass">
.GameLayoutHeader
  position: relative
  width: 100%
  height: 45px
  max-height: 45px
  background: rgb(var(--ui-content))
  padding: var(--space)
  box-shadow: 0 5px 20px 0 #0000000d
  i
    cursor: pointer
</style>