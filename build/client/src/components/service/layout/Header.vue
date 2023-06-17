<template lang="pug">
  div(class="ServiceLayoutHeader")
    UFlex(class="Content" align="center")
      UIcon(src="bx-menu-alt-left" size="2rem" class="mr-2" @click="$emit('menu-left')")
      UText(class="Title" size="1rem" weight="700") {{$route.name}}

      UFlex(v-if="!isLogin" align="center" class="ml-auto")
        UButton(class="mr-1" @click="$router.push('/sign-in')") Đăng Nhập
        UButton(color="danger" @click="$router.push('/sign-up')") Đăng Ký
      UFlex(v-else align="center" class="ml-auto")
        UChip(icon="bx-bell" color="time" class="mr-1" @click="$router.push('/notify')" full) Thông báo {{storeUser.notify}}
        UChip(icon="user" color="primary" class="Account" @click="$router.push('/user')" full) {{storeUser.account}}
      
      UIcon(src="bx-chat" size="1.5rem" class="ml-2" @click="$emit('menu-right')")
</template>

<style lang="sass">
@import @/assets/reponsize.sass

.ServiceLayoutHeader
  position: sticky
  top: 0
  z-index: 100
  @include mobile
    z-index: 11
  .Content
    height: var(--header)
    max-height: var(--header)
    background: rgb(var(--ui-content))
    padding: var(--space)
    box-shadow: 0 5px 20px 0 #0000000d
    i
      cursor: pointer
    .Account
      text-transform: capitalize
    
    @include desktop
      .bx-chat
        display: none
    @include mobile
      .bx-chat
        display: inline-block
      .Title
        display: none
</style>