// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

var ctx1 = document.getElementById("statusChart1");
var statusChart1 = new Chart(ctx1, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
      {
        label: "Accepted",
        lineTension: 0.3,
        backgroundColor: "rgba(40, 167, 69, 0.05)",
        borderColor: "rgba(40, 167, 69, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(40, 167, 69, 1)",
        pointBorderColor: "rgba(40, 167, 69, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(40, 167, 69, 1)",
        pointHoverBorderColor: "rgba(40, 167, 69, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
      },
      {
        label: "Rejected",
        lineTension: 0.3,
        backgroundColor: "rgba(220, 53, 69, 0.05)",
        borderColor: "rgba(220, 53, 69, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(220, 53, 69, 1)",
        pointBorderColor: "rgba(220, 53, 69, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(220, 53, 69, 1)",
        pointHoverBorderColor: "rgba(220, 53, 69, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [20000, 15000, 25000, 18000, 22000, 30000, 28000, 32000, 25000, 35000, 32000, 40000],
      }
    ],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          callback: function (value, index, values) {
            return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function (tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});

var ctx2 = document.getElementById("statusChart2");
var statusChart2 = new Chart(ctx2, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
      {
        label: "Accepted",
        lineTension: 0.3,
        backgroundColor: "rgba(40, 167, 69, 0.05)",
        borderColor: "rgba(40, 167, 69, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(40, 167, 69, 1)",
        pointBorderColor: "rgba(40, 167, 69, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(40, 167, 69, 1)",
        pointHoverBorderColor: "rgba(40, 167, 69, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
      },
      {
        label: "Rejected",
        lineTension: 0.3,
        backgroundColor: "rgba(220, 53, 69, 0.05)",
        borderColor: "rgba(220, 53, 69, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(220, 53, 69, 1)",
        pointBorderColor: "rgba(220, 53, 69, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(220, 53, 69, 1)",
        pointHoverBorderColor: "rgba(220, 53, 69, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [20000, 15000, 25000, 18000, 22000, 30000, 28000, 32000, 25000, 35000, 32000, 40000],
      }
    ],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          callback: function (value, index, values) {
            return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function (tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});

var ctx3 = document.getElementById("statusChart3");
var statusChart3 = new Chart(ctx3, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
      {
        label: "Accepted",
        lineTension: 0.3,
        backgroundColor: "rgba(40, 167, 69, 0.05)",
        borderColor: "rgba(40, 167, 69, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(40, 167, 69, 1)",
        pointBorderColor: "rgba(40, 167, 69, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(40, 167, 69, 1)",
        pointHoverBorderColor: "rgba(40, 167, 69, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
      },
      {
        label: "Rejected",
        lineTension: 0.3,
        backgroundColor: "rgba(220, 53, 69, 0.05)",
        borderColor: "rgba(220, 53, 69, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(220, 53, 69, 1)",
        pointBorderColor: "rgba(220, 53, 69, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(220, 53, 69, 1)",
        pointHoverBorderColor: "rgba(220, 53, 69, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [20000, 15000, 25000, 18000, 22000, 30000, 28000, 32000, 25000, 35000, 32000, 40000],
      }
    ],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          callback: function (value, index, values) {
            return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function (tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});