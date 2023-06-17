<template lang="pug">
  div(class="MissionCustom" v-if="list")
    UAlert(border color="mission" v-if="list.length == 0") Chưa có nhiệm vụ nào khả dụng, vui lòng quay lại sau
    UBox(
      class="Mission"
      v-for="mission in list"
      :key="mission.id" 
      :title="mission.name"
    )
      div(v-html="mission.info" class="Info mb-2")

      UFlex(align="center")
        div(class="mr-auto" class="ListGift")
          UChip(v-if="$utils.getGifts(mission.gifts).length == 0") Chưa cập nhật phần thưởng
          UFlex(v-else wrap="wrap")
            UItem(v-for="(gift, index) in $utils.getGifts(mission.gifts)" :key="index" :item="gift")
        UChip(class="ml-2" full color="time") {{ $utils.getExpires(mission.expires_time).text }}
</template>

<script>
export default {
  data() {
    return {
      list: null,
    }
  },

  created () {
    this.getAllMissionCustom()
  },

  methods: {
    async getAllMissionCustom () {
			const list = await this.API('getAllMissionCustom')
      if(!list) return
      this.list = list
		},
  },
}
</script>

<style lang="sass">
.MissionCustom
  .Mission
    margin-bottom: var(--space)
    &:last-child
      margin-bottom: 0
    .Info
      line-height: 1.2rem
      font-size: 0.9rem
      background: rgb(var(--ui-gray-200))
      border-radius: var(--radius)
      border: 1px dashed rgba(var(--ui-dark), 0.1)
      padding: var(--space)
    .ListGift
      width: 100%
      flex-grow: 1
      margin-right: var(--space)
</style>