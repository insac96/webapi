<template lang="pug">
  div(class="ActivateMissionView")
    UTab(:list="list" v-model="tab")

    transition(name="up" mode="out-in")
      MissionDefault(v-if="tab == 'default'")
      MissionCustom(v-if="tab == 'custom'")
</template>

<script>
import MissionDefault from '@/components/admin/mission/Default.vue'
import MissionCustom from '@/components/admin/mission/Custom.vue'

export default {
  components: {
    MissionDefault,
    MissionCustom,
  },

  data() {
    return {
      tab: 'default',
      list: [
        { value: 'default', label: 'Mặc định' },
        { value: 'custom', label: 'Tùy chỉnh' },
      ]
    }
  }
}
</script>