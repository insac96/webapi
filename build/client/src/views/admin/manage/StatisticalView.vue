<template lang="pug">
  div(class="ManageStatisticalView")
    UTab(:list="list" v-model="tab" color="shop" class="mb-2")

    transition(name="up" mode="out-in")
      StatisticalRevenue(v-if="tab == 'revenue'")
      StatisticalUser(v-if="tab == 'user'")
</template>

<script>
import StatisticalRevenue from '@/components/admin/statistical/revenue/index.vue'
import StatisticalUser from '@/components/admin/statistical/User.vue'

export default {
  components: {
    StatisticalRevenue,
    StatisticalUser
  },
  
  data() {
    return {
      tab: 'revenue',
      list: [
        { value: 'revenue', label: 'Doanh thu' },
        { value: 'user', label: 'Tài khoản' },
      ]
    }
  },
}
</script>