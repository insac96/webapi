<template lang="pug">
  form(@submit.prevent="sign")
    UCard(title="Đăng Ký")
      UInput(v-model="account" placeholder="Tài khoản" type="text" icon="user" icon-color="user")
      UInput(v-model="password" placeholder="Mật khẩu" type="password" icon="password" icon-color="password")
      UInput(v-model="phone" placeholder="Số điện thoại" type="text" icon="phone" icon-color="phone")
      UInput(v-model="referral_code" placeholder="Mã mời nếu có" type="text" icon="code" icon-color="referraler")
      template(#footer)
        UFlex(justify="space-between" align="center")
          UChip(@click="$router.push('/sign-in')") Đã có tài khoản?
          UButton(type="submit") Đăng Ký
</template>

<script>
export default {
  data() {
    return {
      account: null,
      password: null,
      phone: null,
      referral_code: null
    }
  },

  created () {
    this.$utils.deleteCookie('token')
    this.$store.commit('setUser', null)
  },

  methods: {
    async sign () {
      if(!this.account || !this.password || !this.phone) return this.notify('Vui lòng nhập đầy đủ thông tin')

      const user = await this.API('sign', {
        account: this.account,
        password: this.password,
        phone: this.phone,
        referral_code: this.referral_code,
        type: 'up',
      })

      if(!!user) return this.login(user)
    }
  },
}
</script>