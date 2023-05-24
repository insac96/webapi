<template lang="pug">
  transition(name="up")
    UCard(class="NotifyView" title="Trung tâm thông báo" v-if="list")
      UAlert(border color="time" v-if="list.length == 0") Bạn chưa có thông báo nào
      
      UFlex(class="Notify" v-for="notify in list" :key="notify.id")
        UButton(color="time" avatar size="50px" class="mr-2")
          UIcon(src="bx-bell" size="1.5rem")
        div(class="Notify__Content")
          UFlex(justify="space-between")
            UChip(class="mb-1") Hệ thống
            UText(full color="time" size="0.75rem" weight="700") {{ $utils.getTime(notify.create_time).from }}
          UText(weight="500" size="0.9rem") {{ notify.content }}

      template(#footer)
        UFlex(justify="flex-end")
          UPagination(:total="total" :page.sync="page" color="time")
</template>

<script>
export default {
  data() {
    return {
      list: null,
      page: 1,
      total: null
    }
  },

  created () {
    this.getAllNotify()
  },

  watch: {
    page () {
      this.getAllNotify()
    }
  },

  methods: {
    async getAllNotify () {
      const get = await this.API('getAllNotify', {
        limit: 5,
        page: this.page,
        sort: {
          by: 'create_time',
          type: 'DESC'
        }
      })

      if(!get) return

      this.list = get.list
      this.total = get.total_page
    }
  },
}
</script>

<style lang="sass">
.NotifyView
  .Notify
    margin-bottom: calc(var(--space) * 2)
    &__Content
      flex-grow: 1
      border-bottom: 1px solid rgba(var(--ui-dark), 0.2)
      padding-bottom: var(--space)
    &:last-child
      margin-bottom: 0
      .Notify__Content
        border: none
        padding-bottom: 0
</style>
