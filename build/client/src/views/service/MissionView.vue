
<template lang="pug">
  div(class="MissionView")
    UTab(:list="list" v-model="tab" color="shop" class="mb-2")

    transition(name="up" mode="out-in")
      MissionDefault(v-if="tab == 'default'")
      MissionCustom(v-if="tab == 'custom'")
</template>

<script>
import MissionDefault from '@/components/service/mission/Default'
import MissionCustom from '@/components/service/mission/Custom'

export default {
  components: {
    MissionDefault,
    MissionCustom
  },

  data() {
    return {
      tab: 'default',
      list: [
        { value: 'default', label: 'Mặc định' },
        { value: 'custom', label: 'Khác' },
      ]
    }
  },
}
</script>