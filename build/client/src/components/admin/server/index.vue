<template lang="pug">
  div(class="ManageUserInfo" v-if="server")
    UFlex(align="center" class="mb-2")
      UButton(class="mr-auto") {{ server.server_name }}
      UTab(:list="list" v-model="tab")

    transition(name="up" mode="out-in")
      ServerLogin(v-if="tab == 'login'" :server="server")
      ServerSpend(v-if="tab == 'spend'" :server="server")
      ServerRank(v-if="tab == 'rank'" :server="server")
</template>

<script>
import ServerLogin from '@/components/admin/server/Login.vue'
import ServerSpend from '@/components/admin/server/Spend.vue'
import ServerRank from '@/components/admin/server/Rank.vue'

export default {
  components: {
    ServerLogin,
    ServerSpend,
    ServerRank
  },

  props: {
    server: { type: Object }
  },

  data() {
    return {
      tab: 'login',
      list: [
        { value: 'login', label: 'Truy cập' },
        { value: 'spend', label: 'Tiêu phí' },
        { value: 'rank', label: 'Xếp hạng' }
      ]
    }
  }
}
</script>