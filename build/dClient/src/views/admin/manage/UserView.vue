<template lang="pug">
  div(class="ManageUserView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllUser"
      search-action="searchUser"
      first-sort="create_time"
      action-one
      action-three
      @one="updateUserAuth"
      @three="updateUserInfo"
      @open-three="openAdd"
      @select-data="openEditMission"
    )
      template(#one v-if="select")
        UInput(v-model="select.account" label-top="Tài khoản" disabled)
        UInput(v-model="password" label-top="Mật khẩu mới" type="password")
        UInput(v-model="select.phone" label-top="Số điện thoại")
        USelect(v-model="select.block" label-top="Khóa" :list="blockVal")
        USelect(v-model="select.type_user" label-top="Quyền" :list="typeVal")

      template(#three v-if="select")
        UInput(v-model="addVal.account" label-top="Tài khoản" disabled)
        UInput(v-model="addVal.coin" label-top="Thêm Xu" type="number")
        UInput(v-model="addVal.coin_lock" label-top="Thêm Xu Khóa" type="number")
        UInput(v-model="addVal.diamond" label-top="Thêm Kim Cương" type="number")
        UInput(v-model="addVal.wheel" label-top="Thêm Lượt Quay" type="number")
        UInput(v-model="addVal.reason" label-top="Lý do")

    UDialog(v-model="dialogEditMission" @hide="cancelEditMission")
      UBox(width="100%" title="Cập nhật nhiệm vụ" v-if="selectEditMission")
        UInput(v-model="selectEditMission.account" label-top="Tài khoản" disabled)
        USelect(v-model="selectEditMission.join_group" label-top="Group Facebook" :list="missionVal")
        USelect(v-model="selectEditMission.join_zalo" label-top="Group Zalo" :list="missionVal")
        USelect(v-model="selectEditMission.join_telegram" label-top="Group Telegram" :list="missionVal")
        USelect(v-model="selectEditMission.share_web" label-top="Share Website" :list="missionVal")
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="primary" class="mr-1" @click="updateUserMission") Thực Hiện
            UButton(color="dark" @click="cancelEditMission") Hủy Bỏ
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'account': 'Tên',
        'vip': 'VIP',
        'pay_all': 'Tổng nạp',
        'coin': 'Xu',
        'coin_lock': 'Xu khóa',
        'diamond': 'Kim cương',
        'wheel': 'Lượt quay',
        'referraler': 'Người giới thiệu',
        'referral_count': 'Mời',
        'block': 'Khóa',
        'type_user': 'Quyền',
        'create_time': 'Đăng ký'
      },
      select: null,
      
      reload: 0,

      blockVal: [
        { value: 0, label: 'Không' },
        { value: 1, label: 'Có' },
      ],

      typeVal: [
        { value: 0, label: 'MEMBER' },
        { value: 1, label: 'SMOD' },
        { value: 2, label: 'ADMIN' },
      ],

      password: null,

      addVal: {
        account: null,
        coin: 0,
        coin_lock: 0,
        diamond: 0,
        wheel: 0,
        reason: null
      },

      selectEditMission: null,
      dialogEditMission: false,
      missionVal: [
        { value: 0, label: 'Chưa hoàn thành' },
        { value: 1, label: 'Hoàn thành' },
      ]
    }
  },

  methods: {
    async updateUserAuth () {
      this.select.password = this.password
      const update = await this.API('updateUserAuth', this.select, true)
      if(!!update) return this.onReload()
    },

    async updateUserInfo () {
      const update = await this.API('updateUserInfo', this.addVal, true)
      if(!!update) return this.onReload()
    },

    async updateUserMission () {
      if(!this.selectEditMission) return this.notify('Vui lòng chọn tài khoản trước');
      const update = await this.API('updateUserMission', this.selectEditMission, true)

      if(!update) return 
      this.cancelEditMission()
      this.onReload()
    },

    openAdd () {
      if(!this.select) return
      this.addVal.account = this.select.account
    },

    openEditMission (data) {
      this.selectEditMission = data
      this.dialogEditMission = true
    },

    cancelEditMission () {
      this.dialogEditMission = false
      this.selectEditMission = null
    },

    onReload () {
      this.reload = this.reload + 1
      this.password = null
      this.addVal = {
        account: null,
        coin: 0,
        coin_lock: 0,
        diamond: 0,
        wheel: 0,
        reason: null
      }
    }
  },
}
</script>