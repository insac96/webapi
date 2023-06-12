<template lang="pug">
  div(class="ManageVipView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllVip"
      first-sort="number"
      action-one
      action-three
      @one="updateVip"
      @three="updateVip"
      @open-one="openEdit"
      @open-three="openEdit"
    )
      template(#one v-if="select")
        UInput(v-model="select.number" label-top="Cấp VIP" type="number" disabled)
        UInput(v-model="select.need_exp" label-top="Kinh nghiệm cần đạt (? EXP)" type="number")
        UInput(v-model="select.discount_shop" label-top="Giảm giá cửa hàng (% Giá)" type="number")
        UInput(v-model="select.pay_bonus" label-top="Nạp tặng thêm Xu (% Tiền)" type="number")
        UInput(v-model="select.referral_pay_bonus" label-top="Người được giới thiệu nạp tặng Kim Cương (% Tiền)" type="number")
        UInput(v-model="select.referral_bonus_coin" label-top="Giới thiệu tặng Xu (? Xu)" type="number")
        UInput(v-model="select.pay_to_wheel" label-top="Tiền Nạp thành Lượt Quay (? VNĐ = 1 Lượt)" type="number")
        UInput(v-model="select.diamond_to_money" label-top="Kim Cương thành Tiền (1 Kim Cương = ? VNĐ)" type="number")

      template(#three v-if="select")
        UAlert(border color="success" class="mb-2") Đây là phần thưởng người dùng mã giới thiệu sẽ nhận được
        UGiftAdmin(:gifts.sync="select.gifts")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'number': 'Level',
        'need_exp': 'EXP',
        'discount_shop': 'Discount Shop',
        'pay_bonus': 'Pay Bonus Coin',
        'referral_pay_bonus': 'Invitee Pay Bonus Diamond',
        'referral_bonus_coin': 'Referral Bonus Coin',
        'pay_to_wheel': 'Money To Wheel',
        'diamond_to_money': 'Diamond To Money'
      },

      select: null,

      reload: 0,
    }
  },

  methods: {
    async updateVip () {
      const select = JSON.parse(JSON.stringify(this.select))
      select.gifts = JSON.stringify(select.gifts)
      const update = await this.API('updateVip', select, true)
      if(!!update) return this.onReload()
    },

    openEdit () {
      if(!this.select) return
      this.select.gifts = JSON.parse(this.select.gifts)
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>