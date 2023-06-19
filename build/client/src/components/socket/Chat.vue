<template lang="pug">
  div(class="SocketChat" ref="sidebar")
    UFlex(class="SocketChat__Top px-2" align="center" full)
      UIcon(src="bx-x" size="1.5rem" class="SocketChat__Close mr-2" @click="close")
      UText(weight="600" class="mr-auto") Online
      UChip(icon="bx-group" color="success" full) {{socketOnline}}
        
    div(class="SocketChat__Body" ref="box")
      transition(name="up")
        UAlert(v-if="socketChats && socketChats.length == 0" border) Chưa có tin nhắn nào

      transition-group(tag="div" name="chat")
        UFlex(class="Chat" v-for="item in socketChats" :key="item.id")
          div(class="Chat__Avatar mr-2")
            img(:src="`${publicPath}images/avatar/${item.vip}.webp`" :alt="item.account")
          UBox(class="Chat__Info")
            template(#header)
              UText(:color="`type-${item.type}`" size="0.8rem" weight="700" class="capitalize" mini) {{ item.account }}
            UText(class="Chat__Message" weight="500" size="0.9rem") {{ item.message }}


    form(class="SocketChat__Footer" @submit.prevent="onChat")
      UInput(v-model="message" placeholder="Nhập nội dung" icon="bxs-comment-dots" icon-color="primary")
</template>

<script>
export default {
  props: {
    open: { type: Boolean }
  },

  data() {
    return {
      show: this.open,
      socketOnline: 0,
      socketChats: null,
      message: null
    }
  },

  computed: {
    storeChatsSocket () {
      return this.$store.state.chatsSocket
    }
  },

  sockets: {
    online: function (data) {
      this.socketOnline = data
    },
    chat: function (data) {
      const count = this.storeChatsSocket + 1
      this.socketChats.push(data)
      this.$store.commit('setChatsSocket', count)
      setTimeout(() => this.toBottom(), 1)
    },
    chats: function (data) {
      this.socketChats = data
      setTimeout(() => this.toBottom(), 1)
    }
  },

  mounted () {
    this.$socket.emit('get-socket-data')
  },

  watch: {
    open (val) {
      if(!!val){
        this.$store.commit('setChatsSocket', 0)
        this.show = true
        window.addEventListener('click', this.clickOutside)
      }

      if(!val){
        this.show = false
        window.removeEventListener('click', this.clickOutside)
      }
    }
  },

  methods: {
    onChat () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!this.storeUser) return this.notify('Vui lòng tải lại trang')
      if(!this.message) return this.notify('Vui lòng nhập nội dung tin nhắn')

      this.$socket.emit('chat', {
        message: this.message,
        ...this.storeUser
      })

      this.message = null
    },

    toBottom () {
      const box = this.$refs.box
      box.scroll({ top: box.scrollHeight, behavior: 'smooth' });
    },

    close () {
      this.$emit('update:open', false)
    },

    clickOutside (event) {
      const el = this.$refs['sidebar']
      if(!el) return
      if(
        el == event.target 
        || el.contains(event.target) 
        || event.target.classList.contains('bx-chat')
      ) return
      return this.$emit('update:open', false)
    }
  },
}
</script>

<style lang="sass">
@import @/assets/reponsize.sass

.SocketChat
  display: flex
  flex-direction: column
  align-items: center
  background: rgb(var(--ui-content))
  box-shadow: -3px 0 20px -10px rgba(0,0,0,0.3)
  transition: all 0.25s ease
  overflow: hidden
  z-index: 99
  &__Close
    display: none
    @include mobile
      display: inline-block
  &__Top
    min-height: var(--header)
    max-height: var(--header)
    background: rgba(var(--ui-black), 0.05)
  &__Body
    width: 100%
    flex-grow: 1
    overflow-y: auto
    overflow-x: hidden
    padding: var(--space)
    .Chat
      margin-bottom: var(--space)
      &__Avatar
        img
          width: 40px
          height: 40px
          border-radius: var(--radius)
          box-shadow: 0px 0px 15px -5px rgba(0,0,0,0.4)
      &__Info
        @include mobile
          min-width: auto
        @include desktop
          flex-grow: 1
      &__Message
        word-break: break-word
    .chat-enter-active, .chat-leave-active
      transition: all 0.25s ease
    .chat-leave-active
      position: absolute
    .chat-enter
      opacity: 0
      transform: translateY(100%)
    .chat-leave-to
      opacity: 0
  &__Footer
    width: 100%
    padding: var(--space)
    background: rgba(var(--ui-black), 0.05)
</style>