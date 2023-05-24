<template lang="pug">
  UFlex(class="UserCurrency" align="center" justify="flex-end" v-if="!!isLogin && !!storeUser")
    UChip(icon="coin" color="coin") {{ $utils.getMoney(storeUser.coin) }}
    UChip(icon="coin_lock" color="coin_lock") {{ $utils.getMoney(storeUser.coin_lock) }}
    UChip(icon="diamond" color="diamond") {{ $utils.getMoney(storeUser.diamond) }}
    UChip(icon="wheel" color="wheel") {{ $utils.getMoney(storeUser.wheel) }}
</template>

<style lang="sass">
.UserCurrency
  .UiChip
    margin-right: 6px
    &:last-child
      margin-right: 0
</style>