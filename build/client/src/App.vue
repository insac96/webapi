<template lang="pug">
  router-view
</template>

<script>
export default {
  created() {
    this.getConfig()
  },

  sockets: {
    notify: function (data) {
      this.notifySocket(data)
    }
  }
}
</script>
