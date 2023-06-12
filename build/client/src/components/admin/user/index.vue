<template lang="pug">
  div(class="ManageUserInfo" v-if="user")
    UFlex(align="center" class="mb-2")
      UButton(class="mr-auto") {{ user.account }}
      UTab(:list="list" v-model="tab")

    transition(name="up" mode="out-in")
      UserIP(v-if="tab == 'ip'" :user="user")
      UserReferral(v-if="tab == 'referral'" :user="user")
      UserMission(v-if="tab == 'mission'" :user="user" @reload="onReload")
</template>

<script>
import UserIP from '@/components/admin/user/IP.vue'
import UserReferral from '@/components/admin/user/Referral.vue'
import UserMission from '@/components/admin/user/Mission.vue'

export default {
  components: {
    UserIP,
    UserReferral,
    UserMission
  },

  props: {
    user: { type: Object },
    reload: { type: Number }
  },

  data() {
    return {
      tab: 'ip',
      list: [
        { value: 'ip', label: 'Địa chỉ IP' },
        { value: 'referral', label: 'Giới thiệu' },
        { value: 'mission', label: 'Nhiệm vụ' }
      ]
    }
  },

  methods: {
    onReload () {
      this.$emit('reload')
    }
  },
}
</script>