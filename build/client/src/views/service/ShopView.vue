<template lang="pug">
  div(class="ShopView")
    transition(name="up")
      UCard(class="mb-2" v-if="isLogin && routerPath != '/game'")
        UFlex(justify="center")
          UserCurrency

    UTab(:list="list" v-model="tab" color="shop" class="mb-2")

    transition(name="up" mode="out-in")
      ShopItem(v-if="tab == 'item'")
      ShopCurrency(v-if="tab == 'currency'")
</template>

<script>
import ShopItem from '@/components/service/shop/Item'
import ShopCurrency from '@/components/service/shop/Currency'

export default {
  components: {
    ShopItem,
    ShopCurrency
  },

  data() {
    return {
      tab: 'item',
      list: [
        { value: 'item', label: 'Vật phẩm' },
        { value: 'currency', label: 'Tiền tệ' },
      ]
    }
  },
}
</script>