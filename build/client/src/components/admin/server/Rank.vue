<template lang="pug">
  div(class="ManageServerLogin")
    UTableAdmin(
      :head="head"
      get-action="getLogServerRank"
      :plus-get="plus"
      :reload="reload"
      :data-list.sync="dataList"
      first-sort="spend_all"
    )
      template(#header)
        UFlex(align="center")
          UInput(v-model="plus.start" type="date" icon="bxs-calendar" size="40px" icon-color="dark" placeholder="Bắt đầu" class="mb-0" width="180px")
          UInput(v-model="plus.end" type="date" placeholder="Kết thúc" size="40px" class="mb-0" width="150px")
</template>

<script>
export default {
  props: {
    server: { type: Object }
  },
  
  data() {
    return {
      head: {
        'account': 'Tài khoản',
        'spend_all': 'Tổng tiêu phí',
        'spend_recharge': 'Tiêu phí trong game',
        'spend_item': 'Tiêu phí trên web',
      },

      reload: 0,

      plus: {
        start: this.$utils.getTime(new Date() / 1000).dateInput,
        end: this.$utils.getTime(new Date() / 1000).dateInput,
        server_id: this.server.server_id
      },

      dataList: null,
    }
  },

  watch: {
    'plus.start' () {
      this.onReload()
    },
    'plus.end' () {
      this.onReload()
    }
  },

  methods: {
    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>