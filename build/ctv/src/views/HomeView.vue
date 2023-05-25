<template lang="pug">
  div(class="HomeView")
    UTab(:list="list" v-model="tab" color="shop" class="mb-2")

    transition(name="up" mode="out-in")
      StatisticalRevenue(v-if="tab == 'revenue'")
      StatisticalSignUp(v-if="tab == 'signup'")
      StatisticalSignIn(v-if="tab == 'signin'")
</template>

<script>
import StatisticalRevenue from '@/components/statistical/revenue/index.vue'
import StatisticalSignUp from '@/components/statistical/SignUp.vue'
import StatisticalSignIn from '@/components/statistical/SignIn.vue'

export default {
  components: {
    StatisticalRevenue,
    StatisticalSignUp,
    StatisticalSignIn
  },
  
  data() {
    return {
      tab: 'revenue',
      list: [
        { value: 'revenue', label: 'Doanh thu' },
        { value: 'signup', label: 'Đăng Ký' },
        { value: 'signin', label: 'Đăng Nhập' },
      ]
    }
  },
}
</script>