<template lang="pug">
  div(class="ActivateMissionCustom")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllMissionCustom"
      first-sort="update_time"
      action-create
      action-one
      action-two
      action-three
      @create="createMission"
      @one="updateMission"
      @two="deleteMission"
      @three="updateMission"
      @open-one="openEdit"
      @open-three="openEdit"
    )
      template(#create)
        UInput(v-model="addVal.name" label-top="Tên nhiệm vụ")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="addVal.expires_time.date" label-top="Ngày hết hạn" type="date" width="49%" class="mb-0")
          UInput(v-model="addVal.expires_time.time" label-top="Thời gian hết hạn" type="time" width="49%")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")
        quill-editor(:content="addVal.info" :options="editorOption" @change="onEditorChangeCreate($event)")

      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Tên nhiệm vụ")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="select.expires_time.date" label-top="Ngày hết hạn" type="date" width="49%" class="mb-0")
          UInput(v-model="select.expires_time.time" label-top="Thời gian hết hạn" type="time" width="49%")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")
        quill-editor(:content="select.info" :options="editorOption" @change="onEditorChangeCreate($event)")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn xóa nhiệm vụ này
        
      template(#three v-if="select")
        UGiftAdmin(:gifts.sync="select.gifts")
</template>

<script>
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import { quillEditor } from 'vue-quill-editor'

export default {
  components: {
    quillEditor
  },

  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'display': 'Hiển thị',
        'expires_time': 'Thời hạn',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        name: null,
        info: null,
        gifts: [],
        expires_time: {
          date: null,
          time: null
        },
        display: 1
      },
      
      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ]
    }
  },

  methods: {
    onEditorChangeCreate({ quill, html, text }) {
      this.addVal.info = html
    },

    onEditorChangeEdit({ quill, html, text }) {
      this.select.info = html
    },

    async createMission () {
      const addVal = JSON.parse(JSON.stringify(this.addVal))
      addVal.gifts = JSON.stringify(addVal.gifts)
      const create = await this.API('createMissionCustom', addVal, true)
      if(!!create) return this.onReload()
    },

    async updateMission () {
      const select = JSON.parse(JSON.stringify(this.select))
      select.gifts = JSON.stringify(select.gifts)
      const update = await this.API('updateMissionCustom', select, true)
      if(!!update) return this.onReload()
    },

    async deleteMission () {
      const del = await this.API('deleteMissionCustom', {
        mission_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    openEdit () {
      if(!this.select) return
      const expires_time = this.select.expires_time
      const time = this.$utils.getTime(expires_time)

      this.select.expires_time = {
        date: expires_time != 0 ? time.dateInput : null,
        time: expires_time != 0 ? time.timeInput : null
      }

      this.select.gifts = JSON.parse(this.select.gifts)
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        name: null,
        info: null,
        gifts: [],
        expires_time: {
          date: null,
          time: null
        },
        display: 1
      }
    }
  },
}
</script>