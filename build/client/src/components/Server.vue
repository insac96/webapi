<template lang="pug">
  div(class="SelectServer")
    USelect(v-model="server" :list="list" value="server_id" label="server_name" icon="bxs-server" icon-color="primary" placeholder="Chọn máy chủ" v-if="list")
    UInput(class="mt-2" icon="user" icon-color="user" read-only :value="role.role_name" v-if="role")
</template>

<script>
export default {
  props: {
    model: { type: String }
  },

  model: {
    prop: 'model',
    event: 'change'
  },

  data() {
    return {
      list: null,
      server: null,
      role: null
    }
  },

  created () {
    this.getAllServer()
  },

  watch: {
    server (val) {
      if(!val) return this.role = null
      this.getRole()
    },

    role (val) {
      if(!val) return this.$emit('change', null)
      this.$emit('change', this.server)
    }
  },

  methods: {
    async getAllServer () {
      const list = await this.API('getAllServer')
      if(!!list) return this.list = list
    },

    async getRole () {
      const role = await this.API('getRole', {
        server_id: this.server
      })

      if(!!role) return this.role = role
      this.role = null
    }
  }
}
</script>