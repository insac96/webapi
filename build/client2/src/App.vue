<template lang="pug">
  router-view
</template>

<script>
export default {
  created() {
    this.getConfig()
  },

  sockets: {
    connect: function () {
      
    },
    notify: function (data) {
      this.notifySocket(data)
    }
  }
}
</script>
