<script>
  import { Pie } from 'vue-chartjs'
  import * as palette from 'google-palette'

  export default {
    extends: Pie,
    props: {
      salesByClient: {
        type: Object | Array,
        'default': () => null
      },
    },
    data() {
      const clients = Object.keys(this.salesByClient);
      const priceList = Object.values(this.salesByClient);
      return {
        chartData: {
          labels: clients,
          datasets: [
            {
              label: 'Pattern1',
              data: priceList,
              backgroundColor: palette('cb-Pastel1', clients.length).map(
                function(hex) {
                  return '#' + hex
                }
              ),
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          tooltips: {
            callbacks: {
              label: function (tooltipItem, data) {
                return data.datasets[0].data[tooltipItem.index] + ' 円';
              }
            }
          }
        }
      }
    },
    mounted () {
      this.renderChart(this.chartData, this.options)
    }
  }
</script>
