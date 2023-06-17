<template lang="pug">
  UFlex(justify="center" class="ActionSocketView")
    div(class="box-resize-50")
      UCard( title="Thông báo thời gian thực" class="mb-2")
        form(@submit.prevent="sendNotifyAdmin")
          UInput(v-model="message" icon="notify" icon-color="primary" placeholder="Nhập nội dung")

      UCard(title="Cài đặt Chat")
        UFlex(align="center" justify="space-between")
          UText(size="0.85rem") Xóa toàn bộ tin nhắn
          UChip(@click="resetChats" color="danger" full) Bấm để xóa
</template>

<script>
export default {
  data() {
    return {
      message: null
    }
  },

  methods: {
    sendNotifyAdmin () {
      if(!this.message) return this.notify('Vui lòng nhập nội dung')
      this.$socket.emit('notify-admin', this.message)
      this.message = null
    },

    resetChats () {
      this.$socket.emit('reset-chats')
    }
  },
}
</script>