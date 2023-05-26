<template lang="pug">
  UCard(class="CompleteView" v-if="$route.params['type']" title="Xác nhận hoàn thành")
    UAlert(border color="warn" v-if="!status") Đang xử lý...
    UAlert(border color="success" v-if="status == 1") Cập nhật thành công, bạn có thể sang phần nhiệm vụ để nhận thưởng
    UAlert(border color="danger" v-if="status == 2") Cập nhật không thành công
</template>

<script>
export default {
  data() {
    return {
      status: null
    }
  },

  created () {
    this.updateUserMission()
  },

  methods: {
    async updateUserMission () {
      const type = this.$route.params['type']
      if(!type) return this.status = 2

      const update = await this.API('updateUserMission', {
        type: type
      })

      if(!!update) return this.status = 1
      this.status = 2
    }
  },
}
</script>
