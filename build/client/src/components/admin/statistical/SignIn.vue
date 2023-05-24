<template lang="pug">
  div(class="ManageStatisticalSignIn" v-if="list")
    UFlex(align="center")
      USelect(v-model="limit" :list="listLimit" width="50px" height="30px" class="mr-1 mb-0" center)
      UInput(v-model="date.start" type="date" icon="bxs-calendar" size="40px" icon-color="dark" placeholder="Bắt đầu" class="mb-0" width="180px")
      UInput(v-model="date.end" type="date" placeholder="Kết thúc" size="40px" class="mb-0" width="150px")
    
    UFlex(wrap="wrap" class="mb-2" v-if="!!loaderChart")
      UCard(class="box-resize-50")
        Bar(:options="chartOptions" :data="chartDataBar")
      UCard(class="box-resize-50")
        LineChartGenerator(:options="chartOptions" :data="chartDataLine")
</template>

<script>
import { Bar, Line as LineChartGenerator } from 'vue-chartjs'

import { 
  Chart as ChartJS, 
  Tooltip, Legend, 
  BarElement, LineElement, 
  CategoryScale, LinearScale, 
  PointElement,
} from 'chart.js'

ChartJS.register(
  Tooltip, Legend, 
  BarElement, LineElement, 
  CategoryScale, LinearScale, 
  PointElement
)

export default {
  components: {
    Bar,
    LineChartGenerator
  },

  data() {
    return {
      limit: 10,

      listLimit: [
        { value: 5, label: 5 },
        { value: 10, label: 10 },
        { value: 20, label: 20 },
        { value: 50, label: 50 },
        { value: 100, label: 100 },
      ],
      
      date: {
        start: null,
        end: this.$utils.getTime(new Date() / 1000).dateInput
      },

      list: null,
      
      loaderChart: false,
      chartDataBar: null,
      chartDataLine: null,
      chartOptions: {
        responsive: true
      }
    }
  },

  watch: {
    'date.start' () {
      this.getStatisticalSignIn()
    },
    'date.end' () {
      this.getStatisticalSignIn()
    },
    limit () {
      this.getStatisticalSignIn()
    },
    list () {
      this.makeChart()
    }
  },

  created() {
    this.getStatisticalSignIn()
  },

  methods: {
    async getStatisticalSignIn () {
      const get = await this.API('getStatisticalSignIn', {
        limit: this.limit,
        sort: {
          by: 'table_time',
          type: 'DESC'
        },
        ...this.date
      }, true)

      if(!get) return
      this.list = get.list
    },

    makeChart () {
      if(!this.list) return

      this.loaderChart = false
      const list = JSON.parse(JSON.stringify(this.list)).reverse()
      const labels = []
      const sign_in = []

      list.forEach(item => {
        labels.push(item.table_time)
        sign_in.push(item.sign_in)
      })

      this.chartDataBar = {
        labels,
        datasets: [
          { 
            label: 'Người truy cập',
            data: sign_in,
            backgroundColor: 'rgb(6,122,203)',
          }
        ]
      }

      this.chartDataLine = {
        labels,
        datasets: [
          { 
            label: 'Người truy cập',
            data: sign_in,
            fill: false,
            borderColor: 'rgb(6,122,203)',
            tension: 0.1
          }
        ]
      }

      this.loaderChart = true
    }
  },
}
</script>