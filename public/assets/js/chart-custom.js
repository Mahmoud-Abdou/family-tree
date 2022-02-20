(function(jQuery) {

  "use strict";
  jQuery(document).ready(function() {
      var rightSideBarMini = false;
      checkRightSideBar(rightSideBarMini);
      jQuery(document).on('click', '.right-sidebar-toggle', function() {
          if (rightSideBarMini) {
              rightSideBarMini = false;
          } else {
              rightSideBarMini = true;
          }
          checkRightSideBar(rightSideBarMini);
      })
  });

  function checkRightSideBar(rightSideBarMini) {
      if (rightSideBarMini) {
          rightSideBarShow();
      } else {
          rightSideBarHide()
      }
  }

  function rightSideBarShow() {
      jQuery('.right-sidebar-mini').addClass('right-sidebar')
  }

  function rightSideBarHide() {
      jQuery('.right-sidebar-mini').removeClass('right-sidebar')
  }

})(jQuery);


/*--------------Chart 1----------------*/

var options = {
  chart: {
      height: 80,
      type: 'area',
      sparkline: {
          enabled: true
      },
      group: 'sparklines',

  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: 3,
      curve: 'smooth'
  },
  fill: {
      type: 'gradient',
      gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0,
      }
  },

  series: [{
      name: 'المستخدمين',
      data: [60, 15, 50, 30, 70]
  }, ],
  colors: ['#0084ff'],

  xaxis: {
      type: 'datetime',
      categories: ["2018-08-19T00:00:00", "2018-09-19T01:30:00", "2018-10-19T02:30:00", "2018-11-19T01:30:00", "2018-12-19T01:30:00"],
  },
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  }
};

if(jQuery('#chart-1').length){
  var chart = new ApexCharts(
      document.querySelector("#chart-1"),
      options
  );
  chart.render();
}


/*--------------Chart 2----------------*/
var options = {
  chart: {
      height: 80,
      type: 'area',
      sparkline: {
          enabled: true
      },
      group: 'sparklines',

  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: 3,
      curve: 'smooth'
  },
  fill: {
      type: 'gradient',
      gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0,
      }
  },
  series: [{
      name: 'المستخدمين',
      data: [70, 40, 60, 30, 60]
  }, ],
  colors: ['#ffd400'],

  xaxis: {
      type: 'datetime',
      categories: ["2018-08-19T00:00:00", "2018-09-19T01:30:00", "2018-10-19T02:30:00", "2018-11-19T01:30:00", "2018-12-19T01:30:00"],
  },
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  }
};

if(jQuery('#chart-2').length){
  var chart = new ApexCharts(
      document.querySelector("#chart-2"),
      options
  );

  chart.render();
}

/*--------------Chart 3----------------*/
var options = {
  chart: {
      height: 80,
      type: 'area',
      sparkline: {
          enabled: true
      },
      group: 'sparklines',

  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: 3,
      curve: 'smooth'
  },
  fill: {
      type: 'gradient',
      gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0,
      }
  },
  series: [{
      name: 'المستخدمين',
      data: [60, 40, 60, 40, 70]
  }, ],
  colors: ['#00ca00'],

  xaxis: {
      type: 'datetime',
      categories: ["2018-08-19T00:00:00", "2018-09-19T01:30:00", "2018-10-19T02:30:00", "2018-11-19T01:30:00", "2018-12-19T01:30:00"],
  },
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  }
};
if(jQuery('#chart-3').length){
  var chart = new ApexCharts(
      document.querySelector("#chart-3"),
      options
  );
  chart.render();
}

/*--------------Chart 4----------------*/
var options = {
  chart: {
      height: 80,
      type: 'area',
      sparkline: {
          enabled: true
      },
      group: 'sparklines',

  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: 3,
      curve: 'smooth'
  },
  fill: {
      type: 'gradient',
      gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0,
      }
  },
  series: [{
      name: 'المستخدمين',
      data: [75, 30, 60, 35, 60]
  }, ],
  colors: ['#e64141'],

  xaxis: {
      type: 'datetime',
      categories: ["2018-08-19T00:00:00", "2018-09-19T01:30:00", "2018-10-19T02:30:00", "2018-11-19T01:30:00", "2018-12-19T01:30:00"],
  },
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  }
};

if(jQuery('#chart-4').length){
  var chart = new ApexCharts(
      document.querySelector("#chart-4"),
      options
  );

  chart.render();
}

/*--------------Chart 5----------------*/
var options = {
  chart: {
      height: 200,
      type: 'line',
      sparkline: {
          enabled: true
      },
      stacked: false,
  },
  stroke: {
      width: [2, 3],
      curve: 'smooth',
      dashArray: [0, 5]
  },
  plotOptions: {
      bar: {
          columnWidth: '50%'
      }
  },
  colors: ['#00ca00', '#007bff'],
  series: [{
      name: 'Vine',
      type: 'area',
      data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
  }, {
      name: 'Dribbble',
      type: 'line',
      data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
  }],
  fill: {
      opacity: [0.2, 1],
      gradient: {
          inverseColors: false,
          shade: 'light',
          type: "vertical",
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100, 100, 100]
      }
  },
  labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003', '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'],
  markers: {
      size: 0
  },
  xaxis: {
      type: 'datetime'
  },
  yaxis: {
      min: 0
  },
  tooltip: {
      shared: true,
      intersect: false,
      y: {
          formatter: function(y) {
              if (typeof y !== "undefined") {
                  return y.toFixed(0) + " views";
              }
              return y;

          }
      }
  },
  legend: {
      labels: {
          useSeriesColors: true
      },
      markers: {
          customHTML: [
              function() {
                  return ''
              },
              function() {
                  return ''
              },
              function() {
                  return ''
              }
          ]
      }
  }
};

if(jQuery('#chart-5').length) {
  var chart = new ApexCharts(
      document.querySelector("#chart-5"),
      options
  );

  chart.render();
}


/*--------------Chart 6----------------*/
var options = {
  chart: {
      height: 400,
      type: 'bar',
      sparkline: {
          show: false

      },
      toolbar: {
          show: false
      },
  },
  colors: ['#0084ff', '#ffd400'],
  plotOptions: {
      bar: {
          horizontal: false,
          columnWidth: '30%',
          endingShape: 'rounded'
      },
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      show: false,
      width: 5,
      colors: ['#ffffff'],
  },
  series: [{
      name: 'Mobile',
      enabled: 'true',
      data: [44, 90, 90, 60, 115]
  }, {
      name: 'Desktop',
      data: [35, 80, 100, 70, 95]
  }],


  fill: {
      opacity: 1

  },
  tooltip: {
      y: {
          formatter: function(val) {
              return "$ " + val + " thousands"
          }
      }
  }
};

if(jQuery('#bar-chart-6').length){
  var chart = new ApexCharts(
      document.querySelector("#bar-chart-6"),
      options
  );

  chart.render();
}
if(jQuery('#chart-6').length){
  var chart = new ApexCharts(
      document.querySelector("#chart-6"),
      options
  );

  chart.render();
}


/*---------------- Chart - 7, Chart - 8 --------------------*/
var lastDate = 0;
var data = [];
var TICKINTERVAL = 86400000;
let XAXISRANGE = 777600000;

function getDayWiseTimeSeries(baseval, count, yrange) {
  var i = 0;
  while (i < count) {
      var x = baseval;
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

      data.push({
          x,
          y
      });
      lastDate = baseval;
      baseval += TICKINTERVAL;
      i++;
  }
}

getDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 10, {
  min: 10,
  max: 90
});

function getNewSeries(baseval, yrange) {
  var newDate = baseval + TICKINTERVAL;
  lastDate = newDate;
  for (var i = 0; i < data.length - 10; i++) {
      data[i].x = newDate - XAXISRANGE - TICKINTERVAL;
      data[i].y = 0;
  }
  data.push({
      x: newDate,
      y: Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
  })

}

function resetData() {
  // Alternatively, you can also reset the data at certain intervals to prevent creating a huge series
  data = data.slice(data.length - 10, data.length);
}


var options = {
  chart: {
      height: 150,
      type: 'area',
      animations: {
          enabled: true,
          easing: 'linear',
          dynamicAnimation: {
              speed: 1000
          }
      },
      toolbar: {
          show: false
      },
      sparkline: {
          enabled: true
      },
      group: 'sparklines',
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      curve: 'straight',
      width: 3
  },
  series: [{
      data: data
  }],
  markers: {
      size: 4
  },
  xaxis: {
      type: 'datetime',
      range: XAXISRANGE,
  },
  yaxis: {
      max: 100
  },
  fill: {
      type: 'gradient',
      gradient: {
          shadeIntensity: 1,
          inverseColors: false,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [0, 90, 100]
      },
  },
  legend: {
      show: false
  },
};
options.colors = ['#0084ff'];

if(jQuery('#wave-chart-7').length){
  options.markers.size=0;
  options.chart.type='area';
  options.stroke.curve="smooth";
  options.chart.height=70;
  var wave_chart_7 = new ApexCharts(
      document.querySelector("#wave-chart-7"),
      options
  );
  wave_chart_7.render();
}
if(jQuery('#chart-7').length){
  var chart_7 = new ApexCharts(
      document.querySelector("#chart-7"),
      options
  );
  chart_7.render();
}


options.colors = ['#00ca00'];
if(jQuery('#wave-chart-8').length){
  options.markers.size=0;
  options.chart.height=70;
  options.stroke.curve="smooth";
  options.chart.type='area';
  var wave_chart_8 = new ApexCharts(
      document.querySelector("#wave-chart-8"),
      options
  );
  wave_chart_8.render();
}
if(jQuery('#chart-8').length){
  var chart_8 = new ApexCharts(
      document.querySelector("#chart-8"),
      options
  );
  chart_8.render();
}
if(jQuery('#wave-chart-7').length || jQuery('#wave-chart-8').length) {
  window.setInterval(function () {
      getNewSeries(lastDate, {
          min: 10,
          max: 90
      });
      if(jQuery('#wave-chart-7').length){
          wave_chart_7.updateSeries([{
              data: data
          }]);
      }
      if(jQuery('#wave-chart-8').length) {
          wave_chart_8.updateSeries([{
              data: data
          }])
      }
  }, 1000);
}

/*--------------- Chart-9 --------------*/
var options = {
  chart: {
      height: 112,
      type: 'area',
      animations: {
          enabled: true,
          easing: 'linear',
          dynamicAnimation: {
              speed: 1000
          }
      },
      toolbar: {
          show: false
      },
      sparkline: {
          enabled: true
      },
      group: 'sparklines',
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      curve: 'smooth',
      width: 3
  },
  fill: {
      type: 'gradient',
      gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0,
      }
  },
  series: [{
      data: data
  }],
  markers: {
      size: 0
  },
  xaxis: {
      type: 'datetime',
      range: XAXISRANGE,
  },
  yaxis: {
      max: 100
  },
  legend: {
      show: false
  },
};
options.colors = ['#0084ff'];

if(jQuery('#chart-9').length){
  var chart9 = new ApexCharts(
      document.querySelector("#chart-9"),
      options
  );
  chart9.render();
  window.setInterval(function () {
      getNewSeries(lastDate, {
          min: 10,
          max: 90
      });
      if (jQuery('#chart-9').length) {
          chart9.updateSeries([{
              data: data
          }]);
      }
  },1000);
}

/*----------------- Chart-10 ----------------*/

function generateData(baseval, count, yrange) {
  var i = 0;
  var series = [];
  while (i < count) {
      var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
      var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

      series.push([x, y, z]);
      baseval += 86400000;
      i++;
  }
  return series;
}

var options = {
  chart: {
      height: 440,
      type: 'bubble',
      stacked: false,
      toolbar: {
          show: false
      },
      animations: {
          enabled: true,
          easing: 'linear',
          dynamicAnimation: {
              speed: 1000
          }
      },
      sparkline: {
          enabled: true
      },
      group: 'sparklines',
  },
  dataLabels: {
      enabled: false
  },
  series: [
      {
          name: 'Bubble1',
          data: generateData(new Date('11 Feb 2017 GMT').getTime(), 10, {
              min: 10,
              max: 60
          })
      },
      {
          name: 'Bubble2',
          data: generateData(new Date('11 Feb 2017 GMT').getTime(), 10, {
              min: 10,
              max: 60
          })
      },
      {
          name: 'Bubble3',
          data: generateData(new Date('11 Feb 2017 GMT').getTime(), 10, {
              min: 10,
              max: 60
          })
      },
      {
          name: 'Bubble4',
          data: generateData(new Date('11 Feb 2017 GMT').getTime(), 10, {
              min: 10,
              max: 60
          })
      }
  ],
  fill: {
      opacity: 0.8
  },
  title: {
      show: false
  },
  xaxis: {
      tickAmount: 8,
      type: 'category',
      labels: {
          show:false
      }
  },
  yaxis: {
      max: 70,
      labels: {
          show:false
      }
  },
  legend:{
      show:false
  }
};

if(jQuery('#chart-10').length) {
  var chart_2 = new ApexCharts(
      document.querySelector("#chart-10"),
      options
  );

  chart_2.render();
}

/*----------------- Chart-11 ----------------*/
var chart11 = {
  chart: {
      height: 407,
      type: 'line',
      zoom: {
          enabled: false
      },
      toolbar:{
          show:false
      },
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: [5, 7, 5],
      curve: 'straight',
      dashArray: [0, 8, 5]
  },
  series: [{
      name: "Session Duration",
      data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
  },
      {
          name: "Page Views",
          data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
      },
      {
          name: 'Total Visits',
          data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
      }
  ],
  legend: {
      show:false
  },
  markers: {
      size: 0,

      hover: {
          sizeOffset: 6
      }
  },
  xaxis: {
      categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
          '10 Jan', '11 Jan', '12 Jan'
      ]
  },
  yaxis:{
      labels:{
          show:false
      }
  },
  tooltip: {
      y: [{
          title: {
              formatter: function (val) {
                  return val + " (mins)"
              }
          }
      }, {
          title: {
              formatter: function (val) {
                  return val + " per session"
              }
          }
      }, {
          title: {
              formatter: function (val) {
                  return val;
              }
          }
      }]
  },
  grid: {
      borderColor: '#f1f1f1',
  }
}
if(jQuery('#chart-11').length) {
  var chart_3 = new ApexCharts(
      document.querySelector("#chart-11"),
      chart11
  );
  chart_3.render();
}

/*--------------Chart 12----------------*/
var options12 = {
  chart: {
      height: 140,
      type: 'area',
      sparkline: {
          enabled: true
      },
      group: 'sparklines',

  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: 5,
      curve: 'smooth'
  },
  fill: {
      type: 'gradient',
      gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0,
      }
  },
  series: [{
      name: 'المستخدمين',
      data: [70, 40, 60, 30, 60]
  }, ],
  colors: ['#ffd400'],

  xaxis: {
      type: 'datetime',
      categories: ["2018-08-19T00:00:00", "2018-09-19T01:30:00", "2018-10-19T02:30:00", "2018-11-19T01:30:00", "2018-12-19T01:30:00"],
  },
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  }
};
if(jQuery('#chart-12').length) {
  var chart12 = new ApexCharts(
      document.querySelector("#chart-12"),
      options12
  );

  chart12.render();
}

var barOptions12 = {
  chart: {
      height: 150,
      type: 'bar',
      sparkline: {
          enabled: true
      },
      group: 'sparklines',
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      curve: 'smooth',
      width: 15
  },
  series: [{
      name: 'المستخدمين',
      data: [70, 40, 60, 30, 60, ]
  }, ],
  colors: ['#e5f2ff'],
  xaxis: {
      type: 'datetime',
      categories: ["2019-08-19T00:00:00", "2019-09-19T00:00:00", "2019-10-19T00:00:00", "2019-11-19T00:00:00"],
  },
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  }
};
if(jQuery('#bar-chart-12').length) {
  var chart12 = new ApexCharts(
      document.querySelector("#bar-chart-12"),
      barOptions12
  );

  chart12.render();
  window.setInterval(function () {
      getNewSeries(lastDate, {
          min: 10,
          max: 90
      });
      if (jQuery('#bar-chart-12').length) {
          chart12.updateSeries([{
              data: data
          }]);
      }
  },1000);
}



/*--------------Chart 13----------------*/
var option13 = {
  chart: {
      height: 420,
      type: 'radialBar',
      stroke: {
          show: true,
          curve: 'smooth',
          lineCap: 'butt',
          colors: undefined,
          width: 3,
          dashArray: 0,
      },
  },
  plotOptions: {
      radialBar: {
          hollow: {
              margin: 10,
              size: '30%',
              background: 'transparent',
              image: undefined,
              imageWidth: 64,
              imageHeight: 64,
          },
          dataLabels: {
              name: {
                  fontSize: '22px',
              },
              value: {
                  fontSize: '16px',
              },
              total: {
                  show: true,
                  label: 'Total',
                  formatter: function (w) {
                      // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                      return 249
                  }
              }
          }
      }
  },
  fill: {
      type: 'gradient',
  },
  colors: ['#0084ff','#00ca00','#ffd400' ],
  series: [44, 55, 67],
  stroke: {
      lineCap: 'round'
  },
  labels: [' Mobile', 'Desktop', 'Tablet', 'Watch'],
};

if(jQuery('#chart-13').length) {
  var chart13 = new ApexCharts(
      document.querySelector("#chart-13"),
      option13
  );
  chart13.render();

}

/*--------------Chart 13----------------*/

var option14 = {
  chart: {
      height: 350,
      type: 'radialBar',
  },
  plotOptions: {
      hollow: {
          margin: 10,
          size: '30%',
          background: 'transparent',
          image: undefined,
          imageWidth: 64,
          imageHeight: 64,
      },
      radialBar: {
          startAngle: -135,
          endAngle: 135,
          dataLabels: {
              name: {
                  fontSize: '16px',
                  color: undefined,
                  offsetY: 120
              },
              value: {
                  offsetY: 76,
                  fontSize: '22px',
                  color: undefined,
                  formatter: function (val) {
                      return val + "%";
                  }
              }
          }
      }
  },
  fill: {
  },
  stroke: {
      dashArray: 5,
  },
  series: [67],
  labels: ['User traffic'],
  colors: ['#0084ff'],

};

if(jQuery('#chart-14').length) {
  var chart14 = new ApexCharts(
      document.querySelector("#chart-14"),
      option14
  );

  chart14.render();
}



/*--------------Chart 15----------------*/
var option15 = {
  chart: {
      height: 310,
      type: 'line',
      stacked: false,
      toolbar: {
          show: false
      }
  },
  dataLabels: {
      enabled: false
  },
  colors: ['#00ca00' ,'#0084ff','#e64141'],
  series: [{
      name: 'Income',
      type: 'column',
      data: [14, 2, 25, 15, 25, 28, 38, 46]
  }, {
      name: 'Cashflow',
      type: 'column',
      data: [11, 3, 31, 4, 41, 49, 65, 85]
  }, {
      name: 'Revenue',
      type: 'line',
      data: [20, 29, 37, 36, 44, 45, 50, 58]
  }],
  stroke: {
      width: [1, 1, 4]
  },
  xaxis: {
      categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
      labels:{
          show:false
      }
  },
  yaxis: {
      show: false
  },
  tooltip: {
      theme: 'dark',
      fixed: {
          enabled: true,
          position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
          offsetY: 30,
          offsetX: 60
      },
  },
  legend: {
      show: false,
  }
};

if(jQuery('#chart-15').length) {
  var chart15 = new ApexCharts(
      document.querySelector("#chart-15"),
      option15
  );

  chart15.render();
}

/*--------------Chart 16----------------*/

var option16 = {
  chart: {
      height: 350,
      type: 'area',
      sparkline: {
          enabled: true
      },
      group: 'sparklines',

  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      curve: 'smooth'
  },
  series: [{
      name: 'المستخدمين',
      data: [3, 30, 15, 25, 35]
  }, ],
  colors:['#6f32ff'],

  xaxis: {
      type: 'datetime',
      categories: ["2018-08-19T00:00:00", "2018-09-19T01:30:00", "2018-10-19T02:30:00", "2018-11-19T01:30:00", "2018-12-19T01:30:00"],
  },
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  }
};

if(jQuery('#chart-16').length) {
  var chart16 = new ApexCharts(
      document.querySelector("#chart-16"),
      option16
  );

  chart16.render();
}

/*--------------Chart 17----------------*/

var option17 = {
  chart: {
      height: 268,
      type: 'area',
      zoom: {
          enabled: false
      },
      toolbar:{
          show:false
      },
      sparkline: {
          enabled: true
      },
      group: 'sparklines',
  },
  colors: ['#0084ff','#00ca00','#ffd400' ],
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: [3,2,3],
      curve: 'straight',
  },
  series: [{
      name: "Session Duration",
      data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
  },
      {
          name: "Page Views",
          data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
      },
      {
          name: 'Total Visits',
          data: [87, 57, 74, 30, 75, 38, 62, 47, 82, 56, 45, 47]
      }
  ],
  legend: {
      show:false
  },
  markers: {
      size: 0,

      hover: {
          sizeOffset: 6
      }
  },
  xaxis: {
      categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
          '10 Jan', '11 Jan', '12 Jan'
      ],
      labels:{
          show:false
      }
  },
  yaxis:{
      labels:{
          show:false
      }
  },
  tooltip: {
      y: [{
          title: {
              formatter: function (val) {
                  return val + " (mins)"
              }
          }
      }, {
          title: {
              formatter: function (val) {
                  return val + " per session"
              }
          }
      }, {
          title: {
              formatter: function (val) {
                  return val;
              }
          }
      }]
  },
  grid: {
      borderColor: '#f1f1f1',
  }
}

if(jQuery('#Dash1MultiBarChart').length) {
  var chart17 = new ApexCharts(
      document.querySelector("#Dash1MultiBarChart"),
      option17
  );

  chart17.render();
}

/*--------------Chart 18----------------*/


var option18 = {
  chart: {
      height: 235,
      type: 'donut',
  },
  plotOptions: {
      pie: {
          donut: {
              size: '55%'
          }
      }
  },
  series: [44, 55, 41],
  colors: ['#00ca00','#e64141' ,'#0084ff'],
  labels:['Server1','Server2','Server3'],
  legend: {
      position: 'bottom'
  }
};

if(jQuery('#Dash1DonetChart').length) {
  var chart18 = new ApexCharts(
      document.querySelector("#Dash1DonetChart"),
      option18
  );

  chart18.render();
}


var option19 =  {
  chart: {
      height: 308,
      type: 'line',
      toolbar: {
          show: false
      }
  },
  series: [{
      name: 'Website Blog',
      type: 'column',
      data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
  }, {
      name: 'Social Media',
      type: 'line',
      data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
  }],
  stroke: {
      width: [0, 4]
  },
  title: {
      show: false
  },
  legend: {
      show: false
  },
  // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
  labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
  colors: ['#0084ff','#00ca00' ],
  xaxis: {
      labels: {
          show: false,
      },
      type: 'datetime'
  },
  yaxis: [{
      labels: {
          show: false,
      }
  },{
      labels: {
          show: false,
      }
  }],
};

if(jQuery('#chart-19').length) {

  var chart19 = new ApexCharts(
      document.querySelector("#chart-19"),
      option19
  );

  chart19.render();
}

var option20 = {
  chart: {
      height: 387,
      type: 'line',
      stacked: false,
      toolbar: {
          show: false
      },
      sparkline: {
          enabled: true
      },
      group: 'sparklines',
  },
  stroke: {
      width: [ 2, 3],
      curve: 'smooth'
  },
  plotOptions: {
      bar: {
          columnWidth: '20%'
      }
  },
  colors: ['#00ca00', '#0084ff' ],
  series: [ {
      name: 'Vine',
      type: 'area',
      data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
  }, {
      name: 'Dribbble',
      type: 'line',
      data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
  }],
  fill: {
      opacity: [0.25,1],
      gradient: {
          inverseColors: false,
          shade: 'light',
          type: "vertical",
          opacityFrom: 0.85,
          opacityTo: 0.55,
          stops: [0, 100, 100, 100]
      }
  },
  labels: ['01/01/2003', '02/01/2003','03/01/2003','04/01/2003','05/01/2003','06/01/2003','07/01/2003','08/01/2003','09/01/2003','10/01/2003','11/01/2003'],

  xaxis: {
      type:'datetime',
      labels:{
          show:false
      }
  },
  yaxis: {
      min: 0,
      labels:{
          show:false
      }
  },
  tooltip: {
      shared: true,
      intersect: false,
      y: {
          formatter: function (y) {
              if(typeof y !== "undefined") {
                  return  y.toFixed(0) + " views";
              }
              return y;

          }
      }
  },
  legend: {
      show: false
  }
};


if(jQuery('#chart-20').length) {

  var chart20 = new ApexCharts(
      document.querySelector("#chart-20"),
      option20
  );

  chart20.render();
}






/**
* ---------------------------------------
* This demo was created using amCharts 4.
*
* For more information visit:
* https://www.amcharts.com/
*
* Documentation is available at:
* https://www.amcharts.com/docs/v4/
* ---------------------------------------
*/
if(jQuery('#amChartWorldMap').length) {
// Themes begin
  am4core.useTheme(am4themes_animated);
// Themes end

// Create map instance
  var chart = am4core.create("amChartWorldMap", am4maps.MapChart);

// Set map definition
  chart.geodata = am4geodata_worldLow;

// Set projection
  chart.projection = new am4maps.projections.Miller();

// Series for World map
  var worldSeries = chart.series.push(new am4maps.MapPolygonSeries());
  worldSeries.exclude = ["AQ"];
  worldSeries.useGeodata = true;

  var polygonTemplate = worldSeries.mapPolygons.template;
  polygonTemplate.tooltipText = "{name}";
  polygonTemplate.fill = chart.colors.getIndex(0);
  polygonTemplate.nonScalingStroke = true;

// Hover state
  var hs = polygonTemplate.states.create("hover");
  hs.properties.fill = am4core.color("#367B25");

// Series for United States map
  var usaSeries = chart.series.push(new am4maps.MapPolygonSeries());
  usaSeries.geodata = am4geodata_usaLow;

  var usPolygonTemplate = usaSeries.mapPolygons.template;
  usPolygonTemplate.tooltipText = "{name}";
  usPolygonTemplate.fill = chart.colors.getIndex(1);
  usPolygonTemplate.nonScalingStroke = true;

// Hover state
  var hs = usPolygonTemplate.states.create("hover");
  hs.properties.fill = am4core.color("#367B25");
}
// Web Analytics Chart
if(jQuery('#chartdiv').length){
  jQuery(document).ready(function(){
          am4core.ready(function() {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Define country data
            var countries = {
              "AD": {
                "country": "Andorra",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "andorraLow", "andorraHigh" ]
              },
              "AE": {
                "country": "United Arab Emirates",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "uaeLow", "uaeHigh" ]
              },
              "AF": {
                "country": "Afghanistan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "AG": {
                "country": "Antigua and Barbuda",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "antiguaBarbudaLow", "antiguaBarbudaHigh" ]
              },
              "AI": {
                "country": "Anguilla",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "anguillaLow", "anguillaHigh" ]
              },
              "AL": {
                "country": "Albania",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "albaniaLow", "albaniaHigh" ]
              },
              "AM": {
                "country": "Armenia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "armeniaLow", "armeniaHigh" ]
              },
              "AO": {
                "country": "Angola",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "angolaLow", "angolaHigh" ]
              },
              "AQ": {
                "country": "Antarctica",
                "continent_code": "AN",
                "continent": "Antarctica",
                "maps": []
              },
              "AR": {
                "country": "Argentina",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "argentinaLow", "argentinaHigh" ]
              },
              "AS": {
                "country": "American Samoa",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": [ "americanSamoaLow", "americanSamoaHigh" ]
              },
              "AT": {
                "country": "Austria",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "austriaLow", "austriaHigh" ]
              },
              "AU": {
                "country": "Australia",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": [ "australiaLow", "australiaHigh" ]
              },
              "AW": {
                "country": "Aruba",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "arubaLow", "arubaHigh" ]
              },
              "AX": {
                "country": "Aland Islands",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "AZ": {
                "country": "Azerbaijan",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "azerbaijanLow", "azerbaijanHigh" ]
              },
              "BA": {
                "country": "Bosnia and Herzegovina",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "bosniaHerzegovinaLow", "bosniaHerzegovinaHigh", "bosniaHerzegovinaCantonsLow", "bosniaHerzegovinaCantonsHigh" ]
              },
              "BB": {
                "country": "Barbados",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "barbadosLow", "barbadosHigh" ]
              },
              "BD": {
                "country": "Bangladesh",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "bangladeshLow", "bangladeshHigh" ]
              },
              "BE": {
                "country": "Belgium",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "belgiumLow", "belgiumHigh" ]
              },
              "BF": {
                "country": "Burkina Faso",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "burkinaFasoLow", "burkinaFasoHigh" ]
              },
              "BG": {
                "country": "Bulgaria",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "bulgariaLow", "bulgariaHigh" ]
              },
              "BH": {
                "country": "Bahrain",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "bahrainLow", "bahrainHigh" ]
              },
              "BI": {
                "country": "Burundi",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "burundiLow", "burundiHigh" ]
              },
              "BJ": {
                "country": "Benin",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "beninLow", "beninHigh" ]
              },
              "BL": {
                "country": "Saint Barthelemy",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "BM": {
                "country": "Bermuda",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "bermudaLow", "bermudaHigh" ]
              },
              "BN": {
                "country": "Brunei Darussalam",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "bruneiDarussalamLow", "bruneiDarussalamHigh" ]
              },
              "BO": {
                "country": "Bolivia, Plurinational State of",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "boliviaLow", "boliviaHigh" ]
              },
              "BQ": {
                "country": "Bonaire, Sint Eustatius and Saba",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "bonaireSintEustatiusSabaLow", "bonaireSintEustatiusSabaHigh" ]
              },
              "BR": {
                "country": "Brazil",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "brazilLow", "brazilHigh" ]
              },
              "BS": {
                "country": "Bahamas",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "BT": {
                "country": "Bhutan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "bhutanLow", "bhutanHigh" ]
              },
              "BV": {
                "country": "Bouvet Island",
                "continent_code": "AN",
                "continent": "Antarctica",
                "maps": []
              },
              "BW": {
                "country": "Botswana",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "botswanaLow", "botswanaHigh" ]
              },
              "BY": {
                "country": "Belarus",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "belarusLow", "belarusHigh" ]
              },
              "BZ": {
                "country": "Belize",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "belizeLow", "belizeHigh" ]
              },
              "CA": {
                "country": "Canada",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "canadaLow", "canadaHigh" ]
              },
              "CC": {
                "country": "Cocos (Keeling) Islands",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "CD": {
                "country": "Congo, the Democratic Republic of the",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "congoDRLow", "congoDRHigh" ]
              },
              "CF": {
                "country": "Central African Republic",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "centralAfricanRepublicLow", "centralAfricanRepublicHigh" ]
              },
              "CG": {
                "country": "Congo",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "congoLow", "congoHigh" ]
              },
              "CH": {
                "country": "Switzerland",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "switzerlandLow", "switzerlandHigh" ]
              },
              "CI": {
                "country": "Cote d'Ivoire",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "CK": {
                "country": "Cook Islands",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "CL": {
                "country": "Chile",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "chileLow", "chileHigh" ]
              },
              "CM": {
                "country": "Cameroon",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "cameroonLow", "cameroonHigh" ]
              },
              "CN": {
                "country": "China",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "chinaLow", "chinaHigh" ]
              },
              "CO": {
                "country": "Colombia",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "colombiaLow", "colombiaHigh", "colombiaMuniLow", "colombiaMuniHigh" ]
              },
              "CR": {
                "country": "Costa Rica",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "costaRicaLow", "costaRicaHigh" ]
              },
              "CU": {
                "country": "Cuba",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "CV": {
                "country": "Cape Verde",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "capeVerdeLow", "capeVerdeHigh" ]
              },
              "CW": {
                "country": "Curacao",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "curacaoLow", "curacaoHigh" ]
              },
              "CX": {
                "country": "Christmas Island",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "CY": {
                "country": "Cyprus",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "cyprusLow", "cyprusHigh", "cyprusNorthCyprusLow", "cyprusNorthCyprusHigh" ]
              },
              "CZ": {
                "country": "Czech Republic",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "czechiaLow", "czechiaHigh" ]
              },
              "DE": {
                "country": "Germany",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "germanyLow", "germanyHigh" ]
              },
              "DJ": {
                "country": "Djibouti",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "djiboutiLow", "djiboutiHigh" ]
              },
              "DK": {
                "country": "Denmark",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "denmarkLow", "denmarkHigh" ]
              },
              "DM": {
                "country": "Dominica",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "dominicaLow", "dominicaHigh" ]
              },
              "DO": {
                "country": "Dominican Republic",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "dominicanRepublicLow", "dominicanRepublicHigh", "dominicanRepublicMuniLow", "dominicanRepublicMuniHigh" ]
              },
              "DZ": {
                "country": "Algeria",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "algeriaLow", "algeriaHigh" ]
              },
              "EC": {
                "country": "Ecuador",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "ecuadorLow", "ecuadorHigh" ]
              },
              "EE": {
                "country": "Estonia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "estoniaLow", "estoniaHigh" ]
              },
              "EG": {
                "country": "Egypt",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "egyptLow", "egyptHigh" ]
              },
              "EH": {
                "country": "Western Sahara",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "ER": {
                "country": "Eritrea",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "ES": {
                "country": "Spain",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "spainLow", "spainHigh", "spainProvincesLow", "spainProvincesHigh" ]
              },
              "ET": {
                "country": "Ethiopia",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "FI": {
                "country": "Finland",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "finlandLow", "finlandHigh" ]
              },
              "FJ": {
                "country": "Fiji",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": [ "fijiEastLow", "fijiEastHigh", "fijiWestLow", "fijiWestHigh" ]
              },
              "FK": {
                "country": "Falkland Islands (Malvinas)",
                "continent_code": "SA",
                "continent": "South America",
                "maps": []
              },
              "FM": {
                "country": "Micronesia, Federated States of",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "FO": {
                "country": "Faroe Islands",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "faroeIslandsLow", "faroeIslandsHigh" ]
              },
              "FR": {
                "country": "France",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "franceLow", "franceHigh", "franceDepartmentsLow", "franceDepartmentsHigh" ]
              },
              "GA": {
                "country": "Gabon",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "gabonLow", "gabonHigh" ]
              },
              "GB": {
                "country": "United Kingdom",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "ukLow", "ukHigh", "ukCountiesLow", "ukCountiesHigh" ]
              },
              "GB-CHA": {
                "country": "Channel Islands",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "channelIslandsLow", "channelIslandsHigh" ]
              },
              "GD": {
                "country": "Grenada",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "GE": {
                "country": "Georgia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "georgiaLow", "georgiaHigh", "georgiaSouthOssetiaLow", "georgiaSouthOssetiaHigh" ]
              },
              "GF": {
                "country": "French Guiana",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "frenchGuianaLow", "frenchGuianaHigh" ]
              },
              "GG": {
                "country": "Guernsey",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "GH": {
                "country": "Ghana",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "GI": {
                "country": "Gibraltar",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "GL": {
                "country": "Greenland",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "greenlandLow", "greenlandHigh" ]
              },
              "GM": {
                "country": "Gambia",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "GN": {
                "country": "Guinea",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "guineaLow", "guineaHigh" ]
              },
              "GP": {
                "country": "Guadeloupe",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "GQ": {
                "country": "Equatorial Guinea",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "equatorialGuineaLow", "equatorialGuineaHigh" ]
              },
              "GR": {
                "country": "Greece",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "greeceLow", "greeceHigh" ]
              },
              "GS": {
                "country": "South Georgia and the South Sandwich Islands",
                "continent_code": "AN",
                "continent": "Antarctica",
                "maps": []
              },
              "GT": {
                "country": "Guatemala",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "GU": {
                "country": "Guam",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "GW": {
                "country": "Guinea-Bissau",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "GY": {
                "country": "Guyana",
                "continent_code": "SA",
                "continent": "South America",
                "maps": []
              },
              "HK": {
                "country": "Hong Kong",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "hongKongLow", "hongKongHigh" ]
              },
              "HM": {
                "country": "Heard Island and McDonald Islands",
                "continent_code": "AN",
                "continent": "Antarctica",
                "maps": []
              },
              "HN": {
                "country": "Honduras",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "hondurasLow", "hondurasHigh" ]
              },
              "HR": {
                "country": "Croatia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "croatiaLow", "croatiaHigh" ]
              },
              "HT": {
                "country": "Haiti",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "HU": {
                "country": "Hungary",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "hungaryLow", "hungaryHigh" ]
              },
              "ID": {
                "country": "Indonesia",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "indonesiaLow", "indonesiaHigh" ]
              },
              "IE": {
                "country": "Ireland",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "irelandLow", "irelandHigh" ]
              },
              "IL": {
                "country": "Israel",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "israelLow", "israelHigh", "israelPalestineLow", "israelPalestineHigh" ]
              },
              "IM": {
                "country": "Isle of Man",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "IN": {
                "country": "India",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "indiaLow", "indiaHigh" ]
              },
              "IO": {
                "country": "British Indian Ocean Territory",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "IQ": {
                "country": "Iraq",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "IR": {
                "country": "Iran, Islamic Republic of",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "IS": {
                "country": "Iceland",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "icelandLow", "icelandHigh" ]
              },
              "IT": {
                "country": "Italy",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "italyLow", "italyHigh" ]
              },
              "JE": {
                "country": "Jersey",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "JM": {
                "country": "Jamaica",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "JO": {
                "country": "Jordan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "JP": {
                "country": "Japan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "japanLow", "japanHigh" ]
              },
              "KE": {
                "country": "Kenya",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "kenyaLow", "kenyaHigh" ]
              },
              "KG": {
                "country": "Kyrgyzstan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "kyrgyzstanLow", "kyrgyzstanHigh" ]
              },
              "KH": {
                "country": "Cambodia",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "cambodiaLow", "cambodiaHigh" ]
              },
              "KI": {
                "country": "Kiribati",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "KM": {
                "country": "Comoros",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "KN": {
                "country": "Saint Kitts and Nevis",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "KP": {
                "country": "Korea, Democratic People's Republic of",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "northKoreaLow", "northKoreaHigh" ]
              },
              "KR": {
                "country": "Korea, Republic of",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "southKoreaLow", "southKoreaHigh" ]
              },
              "KT": {
                "country": "Saint Kitts and Nevis",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "stKittsNevisLow", "stKittsNevisHigh" ]
              },
              "KW": {
                "country": "Kuwait",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "KY": {
                "country": "Cayman Islands",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "KZ": {
                "country": "Kazakhstan",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "kazakhstanLow", "kazakhstanHigh" ]
              },
              "LA": {
                "country": "Lao People's Democratic Republic",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "LB": {
                "country": "Lebanon",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "LC": {
                "country": "Saint Lucia",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "saintLuciaLow", "saintLuciaHigh" ]
              },
              "LI": {
                "country": "Liechtenstein",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "liechtensteinLow", "liechtensteinHigh" ]
              },
              "LK": {
                "country": "Sri Lanka",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "sriLankaLow", "sriLankaHigh" ]
              },
              "LR": {
                "country": "Liberia",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "LS": {
                "country": "Lesotho",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "LT": {
                "country": "Lithuania",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "lithuaniaLow", "lithuaniaHigh" ]
              },
              "LU": {
                "country": "Luxembourg",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "LV": {
                "country": "Latvia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "latviaLow", "latviaHigh" ]
              },
              "LY": {
                "country": "Libya",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "MA": {
                "country": "Morocco",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "moroccoLow", "moroccoHigh" ]
              },
              "MC": {
                "country": "Monaco",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "MD": {
                "country": "Moldova, Republic of",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "moldovaLow", "moldovaHigh" ]
              },
              "ME": {
                "country": "Montenegro",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "MF": {
                "country": "Saint Martin (French Part)",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "MG": {
                "country": "Madagascar",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "MH": {
                "country": "Marshall Islands",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "MK": {
                "country": "North Macedonia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": []
              },
              "ML": {
                "country": "Mali",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "maliLow", "maliHigh" ]
              },
              "MM": {
                "country": "Myanmar",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "MN": {
                "country": "Mongolia",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "mongoliaLow", "mongoliaHigh" ]
              },
              "MO": {
                "country": "Macao",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "MP": {
                "country": "Northern Mariana Islands",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "MQ": {
                "country": "Martinique",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "MR": {
                "country": "Mauritania",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "MS": {
                "country": "Montserrat",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "MT": {
                "country": "Malta",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "maltaLow", "maltaHigh" ]
              },
              "MU": {
                "country": "Mauritius",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "MV": {
                "country": "Maldives",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "maldivesLow", "maldivesHigh", "maldivesIslandsLow", "maldivesIslandsHigh" ]
              },
              "MW": {
                "country": "Malawi",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "MX": {
                "country": "Mexico",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "mexicoLow", "mexicoHigh" ]
              },
              "MY": {
                "country": "Malaysia",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "malaysiaLow", "malaysiaHigh" ]
              },
              "MZ": {
                "country": "Mozambique",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "NA": {
                "country": "Namibia",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "namibiaLow", "namibiaHigh" ]
              },
              "NC": {
                "country": "New Caledonia",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "NE": {
                "country": "Niger",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "NF": {
                "country": "Norfolk Island",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "NG": {
                "country": "Nigeria",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "nigeriaLow", "nigeriaHigh" ]
              },
              "NI": {
                "country": "Nicaragua",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "nicaraguaLow", "nicaraguaHigh" ]
              },
              "NL": {
                "country": "Netherlands",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "netherlandsLow", "netherlandsHigh" ]
              },
              "NO": {
                "country": "Norway",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "norwayLow", "norwayHigh" ]
              },
              "NP": {
                "country": "Nepal",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "nepalLow", "nepalHigh" ]
              },
              "NR": {
                "country": "Nauru",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "NU": {
                "country": "Niue",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "NZ": {
                "country": "New Zealand",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": [ "newZealandLow", "newZealandHigh" ]
              },
              "OM": {
                "country": "Oman",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "omanLow", "omanHigh" ]
              },
              "PA": {
                "country": "Panama",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "panamaLow", "panamaHigh" ]
              },
              "PE": {
                "country": "Peru",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "peruLow", "peruHigh" ]
              },
              "PF": {
                "country": "French Polynesia",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "PG": {
                "country": "Papua New Guinea",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "PH": {
                "country": "Philippines",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "philippinesLow", "philippinesHigh" ]
              },
              "PK": {
                "country": "Pakistan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "pakistanLow", "pakistanHigh" ]
              },
              "PL": {
                "country": "Poland",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "polandLow", "polandHigh" ]
              },
              "PM": {
                "country": "Saint Pierre and Miquelon",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "stPierreMiquelonLow", "stPierreMiquelonHigh" ]
              },
              "PN": {
                "country": "Pitcairn",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "PR": {
                "country": "Puerto Rico",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "puertoRicoLow", "puertoRicoHigh" ]
              },
              "PS": {
                "country": "Palestinian, State of",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "palestineLow", "palestineHigh" ]
              },
              "PT": {
                "country": "Portugal",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "portugalLow", "portugalHigh", "portugalRegionsLow", "portugalRegionsHigh" ]
              },
              "PW": {
                "country": "Palau",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "PY": {
                "country": "Paraguay",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "paraguayLow", "paraguayHigh"]
              },
              "QA": {
                "country": "Qatar",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "qatarLow", "qatarHigh" ]
              },
              "RE": {
                "country": "Reunion",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "RO": {
                "country": "Romania",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "romaniaLow", "romaniaHigh" ]
              },
              "RS": {
                "country": "Serbia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "serbiaLow", "serbiaHigh", "serbiaNoKosovoLow", "serbiaNoKosovoHigh" ]
              },
              "RU": {
                "country": "Russian Federation",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "russiaLow", "russiaHigh", "russiaCrimeaLow", "russiaCrimeaHigh" ]
              },
              "RW": {
                "country": "Rwanda",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "SA": {
                "country": "Saudi Arabia",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "saudiArabiaLow", "saudiArabiaHigh" ]
              },
              "SB": {
                "country": "Solomon Islands",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": [ "solomonIslandsLow", "solomonIslandsHigh" ]
              },
              "SC": {
                "country": "Seychelles",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "seychellesLow", "seychellesHigh" ]
              },
              "SD": {
                "country": "Sudan",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "sudanLow", "sudanHigh" ]
              },
              "SE": {
                "country": "Sweden",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "swedenLow", "swedenHigh" ]
              },
              "SG": {
                "country": "Singapore",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "singaporeLow", "singaporeHigh" ]
              },
              "SH": {
                "country": "Saint Helena, Ascension and Tristan da Cunha",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "saintHelenaLow", "saintHelenaHigh" ]
              },
              "SI": {
                "country": "Slovenia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "sloveniaLow", "sloveniaHigh", "sloveniaRegionsLow", "sloveniaRegionsHigh" ]
              },
              "SJ": {
                "country": "Svalbard and Jan Mayen",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "svalbardLow", "svalbardHigh" ]
              },
              "SK": {
                "country": "Slovakia",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "slovakiaLow", "slovakiaHigh" ]
              },
              "SL": {
                "country": "Sierra Leone",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "SM": {
                "country": "San Marino",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "sanMarinoLow", "sanMarinoHigh" ]
              },
              "SN": {
                "country": "Senegal",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "senegalLow", "senegalHigh" ]
              },
              "SO": {
                "country": "Somalia",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "somaliaLow", "somaliaHigh" ]
              },
              "SR": {
                "country": "Suriname",
                "continent_code": "SA",
                "continent": "South America",
                "maps": []
              },
              "SS": {
                "country": "South Sudan",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "ST": {
                "country": "Sao Tome and Principe",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "saoTomePrincipeLow", "saoTomePrincipeHigh" ]
              },
              "SV": {
                "country": "El Salvador",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "elSalvadorLow", "elSalvadorHigh" ]
              },
              "SX": {
                "country": "Sint Maarten (Dutch Part)",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "SY": {
                "country": "Syrian Arab Republic",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "syriaLow", "syriaHigh" ]
              },
              "SZ": {
                "country": "Swaziland",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "eswatiniLow", "eswatiniHigh" ]
              },
              "TC": {
                "country": "Turks and Caicos Islands",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "TD": {
                "country": "Chad",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "chadLow", "chadHigh" ]
              },
              "TF": {
                "country": "French Southern Territories",
                "continent_code": "AN",
                "continent": "Antarctica",
                "maps": []
              },
              "TG": {
                "country": "Togo",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "TH": {
                "country": "Thailand",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "thailandLow", "thailandHigh" ]
              },
              "TJ": {
                "country": "Tajikistan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "tajikistanLow", "tajikistanHigh" ]
              },
              "TK": {
                "country": "Tokelau",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "TL": {
                "country": "Timor-Leste",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "TM": {
                "country": "Turkmenistan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "TN": {
                "country": "Tunisia",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "tunisiaLow", "tunisiaHigh" ]
              },
              "TO": {
                "country": "Tonga",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "TR": {
                "country": "Turkey",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "turkeyLow", "turkeyHigh" ]
              },
              "TT": {
                "country": "Trinidad and Tobago",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "TV": {
                "country": "Tuvalu",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "TW": {
                "country": "Taiwan, Province of China",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": []
              },
              "TZ": {
                "country": "Tanzania, United Republic of",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "tanzaniaLow", "tanzaniaHigh" ]
              },
              "UA": {
                "country": "Ukraine",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "ukraineLow", "ukraineHigh" ]
              },
              "UG": {
                "country": "Uganda",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "UM": {
                "country": "United States Minor Outlying Islands",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "US": {
                "country": "United States",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "usaLow", "usaHigh", "usaTerritoriesLow", "usaTerritoriesHigh", "usaTerritories2Low", "usaTerritories2High" ]
              },
              "UY": {
                "country": "Uruguay",
                "continent_code": "SA",
                "continent": "South America",
                "maps": []
              },
              "UZ": {
                "country": "Uzbekistan",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "uzbekinstanLow", "uzbekinstanHigh" ]
              },
              "VA": {
                "country": "Holy See (Vatican City State)",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "vaticanLow", "vaticanHigh" ]
              },
              "VC": {
                "country": "Saint Vincent and the Grenadines",
                "continent_code": "NA",
                "continent": "North America",
                "maps": [ "saintVincentLow", "saintVincentHigh" ]
              },
              "VE": {
                "country": "Venezuela, Bolivarian Republic of",
                "continent_code": "SA",
                "continent": "South America",
                "maps": [ "venezuelaLow", "venezuelaHigh" ]
              },
              "VG": {
                "country": "Virgin Islands, British",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "VI": {
                "country": "Virgin Islands, U.S.",
                "continent_code": "NA",
                "continent": "North America",
                "maps": []
              },
              "VN": {
                "country": "Viet Nam",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "vietnamLow", "vietnamHigh" ]
              },
              "VU": {
                "country": "Vanuatu",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "WF": {
                "country": "Wallis and Futuna",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": []
              },
              "WS": {
                "country": "Samoa",
                "continent_code": "OC",
                "continent": "Oceania",
                "maps": [ "samoaLow", "samoaHigh" ]
              },
              "YE": {
                "country": "Yemen",
                "continent_code": "AS",
                "continent": "Asia",
                "maps": [ "yemenLow", "yemenHigh" ]
              },
              "YT": {
                "country": "Mayotte",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": []
              },
              "ZA": {
                "country": "South Africa",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "southAfricaLow", "southAfricaHigh" ]
              },
              "ZM": {
                "country": "Zambia",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "zambiaLow", "zambiaHigh" ]
              },
              "ZW": {
                "country": "Zimbabwe",
                "continent_code": "AF",
                "continent": "Africa",
                "maps": [ "zimbabweLow", "zimbabweHigh" ]
              },
              "XK": {
                "country": "Kosovo",
                "continent_code": "EU",
                "continent": "Europe",
                "maps": [ "kosovoLow", "kosovoHigh" ]
              }
            };


            var continents = {
              "AF": 0,
              "AN": 1,
              "AS": 2,
              "EU": 3,
              "NA": 4,
              "OC": 5,
              "SA": 6
            }

            // Create map instance
            var chart = am4core.create("chartdiv", am4maps.MapChart);
            chart.projection = new am4maps.projections.Miller();

            // Create map polygon series for world map
            var worldSeries = chart.series.push(new am4maps.MapPolygonSeries());
            worldSeries.useGeodata = true;
            worldSeries.geodata = am4geodata_worldLow;
            worldSeries.exclude = ["AQ"];

            var worldPolygon = worldSeries.mapPolygons.template;
            worldPolygon.tooltipText = "{name}";
            worldPolygon.nonScalingStroke = true;
            worldPolygon.strokeOpacity = 0.5;
            worldPolygon.fill = am4core.color("#eee");
            worldPolygon.propertyFields.fill = "color";

            var hs = worldPolygon.states.create("hover");
            hs.properties.fill = chart.colors.getIndex(9);


            // Create country specific series (but hide it for now)
            var countrySeries = chart.series.push(new am4maps.MapPolygonSeries());
            countrySeries.useGeodata = true;
            countrySeries.hide();
            countrySeries.geodataSource.events.on("done", function(ev) {
              worldSeries.hide();
              countrySeries.show();
            });

            var countryPolygon = countrySeries.mapPolygons.template;
            countryPolygon.tooltipText = "{name}";
            countryPolygon.nonScalingStroke = true;
            countryPolygon.strokeOpacity = 0.5;
            countryPolygon.fill = am4core.color("#eee");

            var hs = countryPolygon.states.create("hover");
            hs.properties.fill = chart.colors.getIndex(9);

            // Set up click events
            worldPolygon.events.on("hit", function(ev) {
              ev.target.series.chart.zoomToMapObject(ev.target);
              var map = ev.target.dataItem.dataContext.map;
              if (map) {
                ev.target.isHover = false;
                countrySeries.geodataSource.url = "https://www.amcharts.com/lib/4/geodata/json/" + map + ".json";
                countrySeries.geodataSource.load();
              }
            });

            // Set up data for countries
            var data = [];
            for(var id in countries) {
              if (countries.hasOwnProperty(id)) {
                var country = countries[id];
                if (country.maps.length) {
                  data.push({
                    id: id,
                    color: chart.colors.getIndex(continents[country.continent_code]),
                    map: country.maps[0]
                  });
                }
              }
            }
            worldSeries.data = data;

            // Zoom control
            chart.zoomControl = new am4maps.ZoomControl();

            var homeButton = new am4core.Button();
            homeButton.events.on("hit", function() {
              worldSeries.show();
              countrySeries.hide();
              chart.goHome();
            });

            homeButton.icon = new am4core.Sprite();
            homeButton.padding(7, 5, 7, 5);
            homeButton.width = 30;
            homeButton.icon.path = "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8";
            homeButton.marginBottom = 10;
            homeButton.parent = chart.zoomControl;
            homeButton.insertBefore(chart.zoomControl.plusButton);

          });
       });
}


  // calender js
  if(jQuery('#calendar').length){
      document.addEventListener('DOMContentLoaded', function () {
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
              plugins: ['dayGrid']
          });
          calendar.render();
      });
  }

   if(jQuery('#am-stackedcolumn-chart').length){
      am4core.ready(function() {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("am-stackedcolumn-chart", am4charts.XYChart);
      chart.colors.list = [am4core.color("#e64141"),
      am4core.color("#00ca00"),
      am4core.color("#ffd400")];


      // Add data
      chart.data = [{
        "year": "2016",
        "europe": 2.5,
        "namerica": 2.5,
        "asia": 2.1,
        "lamerica": 0.3,
        "meast": 0.2
      }, {
        "year": "2017",
        "europe": 2.6,
        "namerica": 2.7,
        "asia": 2.2,
        "lamerica": 0.3,
        "meast": 0.3
      }, {
        "year": "2018",
        "europe": 2.8,
        "namerica": 2.9,
        "asia": 2.4,
        "lamerica": 0.3,
        "meast": 0.3
      }];

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "year";
      categoryAxis.renderer.grid.template.location = 0;


      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.renderer.inside = true;
      valueAxis.renderer.labels.template.disabled = true;
      valueAxis.min = 0;

      // Create series
      function createSeries(field, name) {

        // Set up series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.name = name;
        series.dataFields.valueY = field;
        series.dataFields.categoryX = "year";
        series.sequencedInterpolation = true;

        // Make it stacked
        series.stacked = true;

        // Configure columns
        series.columns.template.width = am4core.percent(60);
        series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

        // Add label
        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        labelBullet.label.text = "{valueY}";
        labelBullet.locationY = 0.5;

        return series;
      }

      createSeries("europe", "Europe");
      createSeries("namerica", "North America");
      createSeries("asia", "Asia-Pacific");

      // Legend
      chart.legend = new am4charts.Legend();

      }); // end am4core.ready()
   }

  if(jQuery('#high-3d-chart').length){
      var chart = new Highcharts.Chart({
      chart: {
          renderTo: 'high-3d-chart',
          type: 'column',
          options3d: {
              enabled: true,
              alpha: 15,
              beta: 15,
              depth: 50,
              viewDistance: 25
          }
      },
      title: {
          text: 'Chart rotation demo'
      },
      subtitle: {
          text: 'Test options by dragging the sliders below'
      },
      plotOptions: {
          column: {
              depth: 25
          }
      },
      series: [{
          data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
          color: '#0084ff'
      }]
  });

  function showValues() {
      $('#alpha-value').html(chart.options.chart.options3d.alpha);
      $('#beta-value').html(chart.options.chart.options3d.beta);
      $('#depth-value').html(chart.options.chart.options3d.depth);
  }

  // Activate the sliders
  $('#sliders input').on('input change', function () {
      chart.options.chart.options3d[this.id] = parseFloat(this.value);
      showValues();
      chart.redraw(false);
  });

  showValues();
  }

  if(jQuery('#high-gauges-chart').length){
      Highcharts.chart('high-gauges-chart', {

      chart: {
          type: 'gauge',
          plotBackgroundColor: null,
          plotBackgroundImage: null,
          plotBorderWidth: 0,
          plotShadow: false
      },

      title: {
          text: 'Speedometer'
      },

      pane: {
          startAngle: -150,
          endAngle: 150,
          background: [{
              backgroundColor: {
                  linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                  stops: [
                      [0, '#FFF'],
                      [1, '#333']
                  ]
              },
              borderWidth: 0,
              outerRadius: '109%'
          }, {
              backgroundColor: {
                  linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                  stops: [
                      [0, '#333'],
                      [1, '#FFF']
                  ]
              },
              borderWidth: 1,
              outerRadius: '107%'
          }, {
              // default background
          }, {
              backgroundColor: '#DDD',
              borderWidth: 0,
              outerRadius: '105%',
              innerRadius: '103%'
          }]
      },

      // the value axis
      yAxis: {
          min: 0,
          max: 200,

          minorTickInterval: 'auto',
          minorTickWidth: 1,
          minorTickLength: 10,
          minorTickPosition: 'inside',
          minorTickColor: '#666',

          tickPixelInterval: 30,
          tickWidth: 2,
          tickPosition: 'inside',
          tickLength: 10,
          tickColor: '#666',
          labels: {
              step: 2,
              rotation: 'auto'
          },
          title: {
              text: 'km/h'
          },
          plotBands: [{
              from: 0,
              to: 120,
              color: '#55BF3B' // green
          }, {
              from: 120,
              to: 160,
              color: '#DDDF0D' // yellow
          }, {
              from: 160,
              to: 200,
              color: '#DF5353' // red
          }]
      },

      series: [{
          name: 'Speed',
          data: [80],
          tooltip: {
              valueSuffix: ' km/h'
          }
      }]

  },
  // Add some life
  function (chart) {
      if (!chart.renderer.forExport) {
          setInterval(function () {
              var point = chart.series[0].points[0],
                  newVal,
                  inc = Math.round((Math.random() - 0.5) * 20);

              newVal = point.y + inc;
              if (newVal < 0 || newVal > 200) {
                  newVal = point.y - inc;
              }

              point.update(newVal);

          }, 3000);
      }
  });
  }

  if(jQuery('#high-barwithnagative-chart').length){
      var categories = [
  '0-4', '5-9', '10-14', '15-19',
  '20-24', '25-29', '30-34', '35-39', '40-44',
  '45-49', '50-54', '55-59', '60-64', '65-69',
  '70-74', '75-79', '80-84', '85-89', '90-94',
  '95-99', '100 + '
  ];

  Highcharts.chart('high-barwithnagative-chart', {
      chart: {
          type: 'bar'
      },
      title: {
          text: 'Population pyramid for Germany, 2018'
      },
      subtitle: {
          text: 'Source: <a href="http://populationpyramid.net/germany/2018/">Population Pyramids of the World from 1950 to 2100</a>'
      },
      accessibility: {
          point: {
              descriptionFormatter: function (point) {
                  var index = point.index + 1,
                      category = point.category,
                      val = Math.abs(point.y),
                      series = point.series.name;

                  return index + ', Age ' + category + ', ' + val + '%. ' + series + '.';
              }
          }
      },
      xAxis: [{
          categories: categories,
          reversed: false,
          labels: {
              step: 1
          },
          accessibility: {
              description: 'Age (male)'
          }
      }, { // mirror axis on right side
          opposite: true,
          reversed: false,
          categories: categories,
          linkedTo: 0,
          labels: {
              step: 1
          },
          accessibility: {
              description: 'Age (female)'
          }
      }],
      yAxis: {
          title: {
              text: null
          },
          labels: {
              formatter: function () {
                  return Math.abs(this.value) + '%';
              }
          },
          accessibility: {
              description: 'Percentage population',
              rangeDescription: 'Range: 0 to 5%'
          }
      },

      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },

      tooltip: {
          formatter: function () {
              return '<b>' + this.series.name + ', age ' + this.point.category + '</b><br/>' +
                  'Population: ' + Highcharts.numberFormat(Math.abs(this.point.y), 1) + '%';
          }
      },

      series: [{
          name: 'Male',
          data: [
              -2.2, -2.1, -2.2, -2.4,
              -2.7, -3.0, -3.3, -3.2,
              -2.9, -3.5, -4.4, -4.1,
              -0.0
          ],
          color: '#00ca00'
      }, {
          name: 'Female',
          data: [
              2.1, 2.0, 2.1, 2.3, 2.6,
              2.9, 3.2, 3.1, 2.9, 3.4,
              0.0
          ],
          color: '#0084ff'
      }]
  });
  }


