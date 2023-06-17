<template lang="pug">
  div(class="ServiceLayoutHeader")
    UFlex(class="Content" align="center")
      UIcon(src="bx-menu-alt-left" size="2rem" class="mr-2" @click="$emit('menu')")
      UText(class="Title" size="1rem" weight="700") {{$route.name}}
      div(v-if="!isLogin" class="ml-auto")
        UButton(class="mr-1" @click="$router.push('/sign-in')") Đăng Nhập
        UButton(color="danger" @click="$router.push('/sign-up')") Đăng Ký
      UFlex(v-else align="center" class="ml-auto")
        UChip(icon="bx-bell" color="time" class="mr-1" @click="$router.push('/notify')" full) Thông báo {{storeUser.notify}}
        UChip(icon="user" color="primary" class="Account" @click="$router.push('/user')" full) {{storeUser.account}}
</template>

<style lang="sass">
.ServiceLayoutHeader
  position: sticky
  top: 0
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
    .Title
      @media (max-width: 576px)  
        display: none
</style>