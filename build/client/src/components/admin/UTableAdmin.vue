<template lang="pug">
  transition(name="up")
    div(class="UiTableAdmin" v-if="list")
      //- Header
      UFlex(align="center" class="UiTableAdmin__Header mb-2")
        USelect(v-model="limit" :list="listLimit" width="50px" height="30px" class="mr-1 mb-0" center)
        form(@submit.prevent="searchAPI" v-if="searchAction")
          UInput(v-model="search" icon="bx-search" icon-color="dark" placeholder="Tìm kiếm")
        slot(name="header")
        UButton(class="ml-auto" v-if="actionCreate" @click="openActionCreate") Thêm mới

      //- Table
      div(class="Table")
        table(class="Table__Content")
          thead
            tr
              th(v-for="(value, key) in head" :key="key" @click="onSort(key)")
                UFlex(align="center")
                  UText() {{ value }}
                  UIcon(:src="sort.type == 'DESC' ? 'bx-chevron-down' : 'bx-chevron-up'" class="ml-1")
              th(v-if="!!actionOne || !!actionTwo || !!actionThree") Chức năng
          tbody
            tr(v-for="(item, index) in list" :key="index" :class="{'pointer': !!$listeners['select-data']}")
              td(v-for="(value, key) in head" :key="key" @click="selectData(item)")
                UChip(:full="!!convertColor(key, item[key])" :color="convertColor(key, item[key])" v-if="key != 'gifts'") {{ convertData(key, item[key]) }}
                UFlex(wrap="wrap" v-else)
                  UChip(v-if="convertData('gifts', item[key]).length == 0") Chưa cập nhật
                  UItem(v-for="(gift, iGift) in convertData('gifts', item[key])" :key="iGift" :item="gift")
              th(v-if="!!actionOne || !!actionTwo || !!actionThree")
                UFlex(align="center")
                  UChip(color="info" full class="mr-1" v-if="actionOne" @click="openActionOne(item)") {{textOne}}
                  UChip(color="success" full class="mr-1" v-if="actionThree" @click="openActionThree(item)") {{textThree}}
                  UChip(color="danger" full v-if="actionTwo" @click="openActionTwo(item)") {{textTwo}}

      //- No Data
      div(class="UiTableAdmin__NoData" v-if="list.length == 0") Không có dữ liệu

      //- Footer
      UFlex(align="center" class="UiTableAdmin__Footer" v-if="totalPage > 1 || !!$slots.footer")
        slot(name="footer")
        UPagination(:total="totalPage" :page.sync="page" class="ml-auto")

      //- Dialog Action Create
      UDialog(v-model="dialog.actionCreate" v-if="actionCreate" max="700px")
        UBox(width="100%" title="Thêm Mới" class="UiTableAdmin__Box")
          slot(name="create")
          template(#footer)
            UFlex(align="center" justify="flex-end")
              UButton(color="primary" @click="$emit('create')" class="mr-1") Thực Hiện
              UButton(color="dark" @click="cancel") Hủy Bỏ

      //- Dialog Action One
      UDialog(v-model="dialog.actionOne" v-if="actionOne" max="700px")
        UBox(width="100%" :title="textOne" class="UiTableAdmin__Box")
          slot(name="one")
          template(#footer)
            UFlex(align="center" justify="flex-end")
              UButton(color="info" @click="$emit('one')" class="mr-1") Thực Hiện
              UButton(color="dark" @click="cancel") Hủy Bỏ

      //- Dialog Action Two
      UDialog(v-model="dialog.actionTwo" v-if="actionTwo" max="700px")
        UBox(width="100%" :title="textTwo" class="UiTableAdmin__Box")
          slot(name="two")
          template(#footer)
            UFlex(align="center" justify="flex-end")
              UButton(color="danger" @click="$emit('two')" class="mr-1") Thực Hiện
              UButton(color="dark" @click="cancel") Hủy Bỏ

      //- Dialog Action Three
      UDialog(v-model="dialog.actionThree" v-if="actionThree" max="700px")
        UBox(width="100%" :title="textThree" class="UiTableAdmin__Box")
          slot(name="three")
          template(#footer)
            UFlex(align="center" justify="flex-end")
              UButton(color="success" @click="$emit('three')" class="mr-1") Thực Hiện
              UButton(color="dark" @click="cancel") Hủy Bỏ
</template>

<script>
export default {
  props: {
    head: { type: Object },
    firstSort: { type: String },
    getAction: { type: String },
    searchAction: { type: String },
    actionCreate: { type: Boolean },
    actionOne: { type: Boolean },
    actionTwo: { type: Boolean },
    actionThree: { type: Boolean },
    textOne: { type: String, default: 'Sửa' },
    textTwo: { type: String, default: 'Xóa' },
    textThree: { type: String, default: 'Thêm' },
    select: { type: Object },
    reload: { type: Number },
    plusGet: { type: Object },
    plusSearch: { type: Object },
    dataList: { type: Array }
  },

  data() {
    return {
      page: 1,
      totalPage: null,

      limit: 10,
      listLimit: [
        { value: 5, label: 5 },
        { value: 10, label: 10 },
        { value: 20, label: 20 },
        { value: 50, label: 50 },
        { value: 100, label: 100 },
      ],

      sort: {
        type: 'DESC',
        by: this.firstSort
      },

      search: null,

      list: null,

      dialog: {
        actionCreate: false,
        actionOne: false,
        actionTwo: false,
        actionThree: false
      },

      displayView : {
        0: 'Ẩn',
        1: 'Hiện'
      },

      shopTypeView : {
        'recharge': 'Gói nạp',
        'item': 'Vật phẩm',
        'currency': 'Tiền tệ'
      },

      statusView : {
        0: 'Chưa duyệt',
        1: 'Thành công',
        2: 'Từ chối'
      },

      blockView: {
        0: 'Không',
        1: 'Có'
      },

      typeUserView: {
        0: 'MEMBER',
        1: 'SMOD',
        2: 'ADMIN'
      },
    }
  },

  created () {
    this.getAPI()
  },

  watch: {
    page () {
      this.watchAPI()
    },

    limit () {
      this.watchAPI()
    },

    search (val) {
      if(!val) return this.getAPI()
    },

    reload () {
      this.cancel()
      this.watchAPI()
    }
  },

  methods: {
    // Get API
    async getAPI () {
      const plusGet = this.plusGet || {}
      const get = await this.API(this.getAction, {
        page: this.page,
        limit: this.limit,
        sort: this.sort,
        ...plusGet
      }, true)

      if(!get) return
      this.list = get.list
      this.totalPage = get.total_page
      this.$emit('update:dataList', get.list)
    },

    // Search API
    async searchAPI () {
      const plusSearch = this.plusSearch || {}
      const search = await this.API(this.searchAction, {
        page: this.page,
        limit: this.limit,
        sort: this.sort,
        search: this.search,
        ...plusSearch
      }, true)

      if(!search) return
      this.list = search.list
      this.totalPage = search.total_page
      this.$emit('update:dataList', get.list)
    },

    // Watch Get
    watchAPI () {
      if(!!this.search) return this.searchAPI()
      this.getAPI()
    },

    // Sort
    onSort (by) {
      if(this.sort.by == by){
        this.sort.type = (this.sort.type == 'DESC') ? 'ASC' : 'DESC'
      }
      else {
        this.sort.by = by
        this.sort.type = 'DESC'
      }

      this.watchAPI()
    },

    // Select
    selectData(item) {
      this.$emit('select-data', JSON.parse(JSON.stringify(item)))
    },

    // Open Create
    openActionCreate () {
      this.$emit('update:select', null)
      this.$emit('open-create')
      this.dialog.actionCreate = true
    },

    openActionOne (item) {
      this.$emit('update:select', JSON.parse(JSON.stringify(item)))
      this.$emit('open-one')
      this.dialog.actionOne = true
    },

    openActionTwo (item) {
      this.$emit('update:select', JSON.parse(JSON.stringify(item)))
      this.$emit('open-two')
      this.dialog.actionTwo = true
    },

    openActionThree (item) {
      this.$emit('update:select', JSON.parse(JSON.stringify(item)))
      this.$emit('open-three')
      this.dialog.actionThree = true
    },

    cancel () {
      this.$emit('update:select', null)
      this.dialog.actionCreate = false
      this.dialog.actionOne = false
      this.dialog.actionTwo = false
      this.dialog.actionThree = false
    },

    // Convert Data
    convertData (type, data) {
      const isCurrency = [
        'coin', 'coin_lock', 'money', 'pay', 'price', 'save_pay_ingame',
        'diamond', 'wheel', 'need_exp', 'referral_bonus_coin', 'pay_to_wheel', 
        'diamond_to_money', 'pay_all', 'pay_banking', 'pay_momo', 'pay_card',
        'amount'
      ]
      const isTime = ['create_time', 'verify_time']
      const isExpires = ['expires_bonus', 'expires_time']
      const isPercent = ['bonus', 'discount_shop', 'pay_bonus_coin', 'referral_pay_bonus_coin', 'bonus_default']

      if(isCurrency.includes(type)){
        return this.$utils.getMoney(data, false)
      }
      if(isTime.includes(type)){
        if(data == 0 || !data) return 'Chưa cập nhật'
        return this.$utils.getTime(data).full
      }
      if(isExpires.includes(type)){
        if(data == 0) return 'Vô thời hạn'
        return this.$utils.getTime(data).full
      }
      if(isPercent.includes(type)){
        return data+'%'
      }
      if(type == 'update_time'){
        if(data == 0 || !data) return 'Chưa cập nhật'
        return this.$utils.getTime(data).from
      }
      if(type == 'max'){
        return data == '0' ? 'Không giới hạn' : data
      }
      if(type == 'display'){
        return this.displayView[data]
      }
      if(type == 'status'){
        return this.statusView[data]
      }
      if(type == 'shop_type'){
        return this.shopTypeView[data]
      }
      if(type == 'gifts'){
        return JSON.parse(data)
      }
      if(type == 'block'){
        return this.blockView[data]
      }
      if(type == 'type_user'){
        return this.typeUserView[data]
      }
      if(type == 'referraler'){
        return data ? data : 'Không'
      }
      return data || 'Chưa cập nhật'
    },

    convertColor (type, data) {
      if(type == 'status'){
        return `status-${data}`
      }
      else if(type == 'type_user'){
        return `type-${data}`
      }
      return null
    },
  },
}
</script>

<style lang="sass">
.UiTableAdmin
  &__Box
    .UiBox__Body
      max-height: 70vh
      overflow-y: auto
  &__NoData
    padding: var(--space)
    font-size: 0.8rem
    text-align: center
    background: rgba(var(--ui-black), 0.05)
    border-radius: 0 0 var(--radius) var(--radius)
    
  &__Footer
    padding: calc(var(--space) / 2)
    background: rgba(var(--ui-black), 0.05)
    border-radius: 0 0 var(--radius) var(--radius)

  .Table
    width: 100%
    border-radius: var(--radius)
    background: rgba(var(--ui-content))
    border-radius: var(--radius) var(--radius)  0 0
    box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
    border: 1px solid rgba(var(--ui-dark), 0.1)
    overflow-x: auto
    &__Content
      position: relative
      width: 100%
      border-collapse: collapse
      border-radius: inherit
      overflow: hidden
      thead, tbody
        width: 100%
      tr
        text-align: left
      thead
        th
          padding: var(--space)
          font-weight: 600
          font-size: 0.8rem
          text-transform: capitalize
          white-space: nowrap
          background: rgba(var(--ui-black), 0.05)
          text-align: start
          cursor: pointer
      tbody
        td
          padding: calc(var(--space) * 0.8) var(--space)
          background: rgba(var(--ui-content),0.4)
          white-space: normal
</style>