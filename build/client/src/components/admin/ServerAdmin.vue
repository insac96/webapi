<template lang="pug">
  div(class="SelectServer" class="mb-2")
    USelect(v-model="server" :list="list" value="server_id" label="server_name" label-top="Chọn máy chủ")
</template>

<script>
export default {
  props: {
    model: { type: String },
    noRole: { type: Boolean }
  },

  model: {
    prop: 'model',
    event: 'change'
  },

  data() {
    return {
      list: [
        { server_name: 'Tất cả máy chủ', server_id: 'all' }
      ],
      server: null,
    }
  },

  created () {
    this.getAllServer()
  },

  watch: {
    server (val) {
      this.$emit('change', val)
    },
  },

  methods: {
    async getAllServer () {
      const list = await this.API('getAllServer')
      if(!!list) return this.list = this.list.concat(list);
    }
  }
}
</script>