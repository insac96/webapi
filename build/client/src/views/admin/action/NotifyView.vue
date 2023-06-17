<template lang="pug">
  UCard(class="ActionNotifyView" title="Thông báo thời gian thực")
    form(@submit.prevent="send")
      UInput(v-model="message" icon="notify" icon-color="primary" placeholder="Nhập nội dung")
</template>

<script>
export default {
  data() {
    return {
      message: null
    }
  },

  methods: {
    send () {
      if(!this.message) return this.notify('Vui lòng nhập nội dung')
      this.$socket.emit('notify-admin', this.message)
      this.message = null
    }
  },
}
</script>