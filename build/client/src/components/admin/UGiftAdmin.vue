<template lang="pug">
  div(class="UGiftAdmin")
    UFlex(justify="space-between" align="center" class="mb-2")
      UChip Phần thưởng
      UButton(@click="dialog.add = true") Thêm

    UTable(v-if="list" :no-data="list.length == 0")
      template(#head)
        tr
          th ID
          th Tên
          th Số lượng
          th Chức năng
      template(#default)
        tr(v-for="(item, index) in list" :key="index")
          td
            UChip() {{ item.id }}
          td
            UChip(large) {{ item.name }}
          td
            UChip() {{ $utils.getMoney(item.amount) }}
          td
            UFlex(align="center")
              UChip(full color="info" class="mr-1" @click="selectEdit(item)") Sửa
              UChip(full color="danger" @click="removeGift(index)") Xóa

    UDialog(v-model="dialog.add" max="500px")
      UBox(title="Thêm phần thưởng" width="100%")
        UInput(v-model="addVal.id" label-top="ID Vật phẩm")
        UInput(v-model="addVal.name" label-top="Tên vật phẩm")
        UInput(v-model="addVal.amount" label-top="Số lượng")
        UInput(v-model="addVal.icon" label-top="Mã Icon nếu có")
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="danger" @click="addGift") Thực Hiện
            UButton(color="dark" @click="cancel") Hủy Bỏ

    UDialog(v-model="dialog.edit" max="500px")
      UBox(title="Sửa phần thưởng" v-if="select" width="100%")
        UInput(v-model="select.id" label-top="ID Vật phẩm")
        UInput(v-model="select.name" label-top="Tên vật phẩm")
        UInput(v-model="select.amount" label-top="Số lượng")
        UInput(v-model="select.icon" label-top="Mã Icon nếu có")
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="danger" @click="editGift") Thực Hiện
            UButton(color="dark" @click="cancel") Hủy Bỏ
</template>

<script>
export default {
  props: {
    gifts: { type: Array },
  },

  data() {
    return {
      select: null,

      list: null,

      addVal: {
        id: null,
        name: null,
        amount: null,
        icon: null
      },

      dialog: {
        add: false,
        edit: false
      }
    }
  },

  created() {
    this.list = JSON.parse(JSON.stringify(this.gifts))
  },

  methods: {
    selectEdit (gift) {
      this.select = gift
      this.dialog.edit = true
    },

    addGift () {
      if(!this.addVal.id || !this.addVal.name || !this.addVal.amount) return this.notify('Vui lòng nhập đầy đủ')

      this.list.push(this.addVal)
      this.done()
    },

    editGift () {
      if(!this.select.id || !this.select.name || !this.select.amount) return this.notify('Vui lòng nhập đầy đủ')

      const index = this.list.findIndex(i => i.id == this.select.id)
      if(index == -1) return this.notify('Lỗi dữ liệu')

      this.list[index] = this.select
      this.done()
    },

    removeGift (index) {
      this.$delete(this.list, index)
      this.done()
    },

    done () {
      this.$emit('update:gifts', this.list)
      this.cancel()
    },

    cancel () {
      this.select = null

      this.dialog.add = false
      this.dialog.edit = false
      
      this.addVal = {
        id: null,
        name: null,
        amount: null,
        icon: null
      }
    }
  },
}
</script>