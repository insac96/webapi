<template lang="pug">
  div(class="ServerListView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllServer"
      first-sort="id"
      action-one
      action-two
      action-three
      @one="updateServer"
      @three="startServer"
      @two="stopServer"
      text-one="Sửa"
      text-two="Stop"
      text-three="Start"
      @select-data="openServerInfo"
    )
      template(#header)
        UButton(class="ml-auto" color="dark" @click="syncServer") Đồng bộ

      template(#one v-if="select")
        UInput(v-model="select.server_id" label-top="ID Máy Chủ" read-only)
        UInput(v-model="select.db_name" label-top="Cơ sở dữ Liệu")
        UInput(v-model="select.path" label-top="Đường dẫn thư mục")
        UInput(v-model="select.file_start" label-top="Lệnh chạy")
        UInput(v-model="select.file_stop" label-top="Lệnh dừng")

      template(#three v-if="select")
        UAlert(color="success" border class="mb-2") Bạn chắc chắn bật máy chủ này
        UInput(v-model="select.server_id" label-top="ID Máy Chủ" read-only)
        UInput(v-model="select.server_name" label-top="Tên Máy Chủ" read-only)

      template(#two v-if="select")
        UAlert(color="danger" border class="mb-2") Bạn chắc chắn muốn tắt máy chủ này
        UInput(v-model="select.server_id" label-top="ID Máy Chủ" read-only)
        UInput(v-model="select.server_name" label-top="Tên Máy Chủ" read-only)

    transition(name="up")
      ServerInfo(:server="selectServerInfo" v-if="selectServerInfo" class="mt-2")
</template>

<script>
import ServerInfo from  '@/components/admin/server/index.vue'

export default {
  components: {
    ServerInfo
  },

  data() {
    return {
      head: {
        'server_id': 'ID',
        'server_name': 'Tên máy chủ',
        'db_name': 'Dữ liệu',
        'running': 'Trạng thái',
        'update_time': 'Cập nhật'
      },

      select: null,

      selectServerInfo: null,

      reload: 0
    }
  },

  methods: {
    async syncServer () {
      const sync = await this.API('syncServer', null, true)
      if(!!sync) return this.onReload()
    },

    async updateServer () {
      const update = await this.API('updateServer', this.select, true)
      if(!!update) return this.onReload()
    },

    async startServer () {
      const start = await this.API('startServer', {
        server_id: this.select.server_id
      }, true)
      if(!!start) return this.onReload()
    },

    async stopServer () {
      const stop = await this.API('stopServer', {
        server_id: this.select.server_id
      }, true)
      if(!!stop) return this.onReload()
    },

    openServerInfo (data) {
      this.selectServerInfo = null
      setTimeout(() => this.selectServerInfo = data, 1)
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>