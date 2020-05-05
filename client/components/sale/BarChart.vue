<script>
  import { Bar } from 'vue-chartjs'

  export default {
    extends: Bar,
    props: {
      priceList: {
        type: Array,
        'default': () => []
      },
      priceAverage: {
        type: Number,
        'default': 0
      },
    },
    data() {
      return {
        chartData: {
          labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
          datasets: [
            {
              data: this.priceList,
              backgroundColor: this.getBackgroundColorList(),
              borderColor: this.getBorderColorList(),
              borderWidth: 1
            }
          ]
        },
        options: {
          legend: {
            display: false
          },
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            xAxes: [{
              scaleLabel: {
                display: true,
                labelString: 'Month'
              }
            }],
            yAxes: [{
              ticks: {
                beginAtZero: true,
                stepSize: 100000,
                callback: function (label, index, labels) {
                  if (Math.floor(label) === label) {
                    return label + ' 円';
                  }
                }
              }
            }],
          },
          tooltips: {
            callbacks: {
              label: function (tooltipItem, data) {
                return tooltipItem.yLabel + ' 円';
              }
            }
          }
        }
      }
    },
    methods: {
      getBackgroundColorList() {
        const backgroundColorList = [];
        const lowBackground = 'rgba(255, 99, 132, 0.2)';
        const highBackground = 'rgba(54, 162, 235, 0.2)';

        this.priceList.forEach((price) => {
          if (price < this.priceAverage) {
            backgroundColorList.push(lowBackground);
          } else {
            backgroundColorList.push(highBackground);
          }
        });

        return backgroundColorList;
      },
      getBorderColorList() {
        const borderColorList = [];
        const lowBorder = 'rgba(255, 99, 132, 1)';
        const highBorder = 'rgba(54, 162, 235, 1)';

        this.priceList.forEach((price) => {
          if (price < this.priceAverage) {
            borderColorList.push(lowBorder);
          } else {
            borderColorList.push(highBorder);
          }
        });

        return borderColorList;
      }
    },
    mounted () {
      this.renderChart(this.chartData, this.options)
    }
  }
</script>
