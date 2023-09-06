"use strict";
$(document).ready(function () {
  if ($("#apexcharts-area").length > 0) {
    $.post("data_student.php", function (data_student) {
      console.log(data_student);
      let stdB1 = [];
      let stdB2 = [];
      let stdB3 = [];
      let stdB4 = [];
      let stdD1 = [];
      let stdD2 = [];
      let stdD3 = [];
      let stdD4 = [];

      for (let i in data_student) {
        if (
          data_student[i].program == "Bachelor Degree" &&
          data_student[i].year == "1"
        ) {
          stdB1.push(data_student[i].std_id);
        }
        if (
          data_student[i].program == "Bachelor Degree" &&
          data_student[i].year == "2"
        ) {
          stdB2.push(data_student[i].std_id);
        }
        if (
          data_student[i].program == "Bachelor Degree" &&
          data_student[i].year == "3"
        ) {
          stdB3.push(data_student[i].std_id);
        }
        if (
          data_student[i].program == "Bachelor Degree" &&
          data_student[i].year == "4"
        ) {
          stdB4.push(data_student[i].std_id);
        }
        if (
          data_student[i].program == "Diploma Degree" &&
          data_student[i].year == "1"
        ) {
          stdD1.push(data_student[i].std_id);
        }
        if (
          data_student[i].program == "Diploma Degree" &&
          data_student[i].year == "2"
        ) {
          stdD2.push(data_student[i].std_id);
        }
        if (
          data_student[i].program == "Diploma Degree" &&
          data_student[i].year == "3"
        ) {
          stdD3.push(data_student[i].std_id);
        }
        if (
          data_student[i].program == "Diploma Degree" &&
          data_student[i].year == "4"
        ) {
          stdD4.push(data_student[i].std_id);
        }
      }

      let stdB1s = stdB1.length;
      let stdB2s = stdB2.length;
      let stdB3s = stdB3.length;
      let stdB4s = stdB4.length;
      let stdD1s = stdD1.length;
      let stdD2s = stdD2.length;
      let stdD3s = stdD3.length;
      let stdD4s = stdD4.length;

      var options = {
        chart: { height: 350, type: "line", toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: "smooth" },
        series: [
          {
            name: "Bachelor",
            color: "#3D5EE1",
            data: [stdB1s, stdB2s, stdB3s, stdB4s],
          },
          {
            name: "Diploma",
            color: "#70C4CF",
            data: [stdD1s, stdD2s, stdD3s, stdD4s],
          },
        ],
        xaxis: { categories: ["Year 1", "Year 2", "Year 3", "Year 4"] },
      };
      var chart = new ApexCharts(
        document.querySelector("#apexcharts-area"),
        options
      );
      chart.render();
    });
  }

  if ($("#s-col-stacked").length > 0) {
    let scoreA1 = 3;
    let scoreA2 = 1;
    let scoreA3 = 3;
    let scoreA4 = 2;

    let scoreBp1 = [13];
    let scoreBp2 = [13];
    let scoreBp3 = [11];
    let scoreBp4 = [16];

    let scoreB1 = [14];
    let scoreB2 = [16];
    let scoreB3 = [16];
    let scoreB4 = [12];

    
    var sColStacked = {
      chart: {
        height: 350,
        type: "bar",
        stacked: true,
        toolbar: { show: false },
      },
      responsive: [
        {
          breakpoint: 480,
          options: { legend: { position: "bottom", offsetX: -10, offsetY: 0 } },
        },
      ],
      plotOptions: { bar: { horizontal: false } },
      series: [
        { name: "GRADE A", data: [scoreA1, scoreA2, scoreA3, scoreA4] },
        { name: "GRADE B+", data: [scoreBp1, scoreBp2, scoreBp3, scoreBp4] },
        { name: "GRADE B", data: [scoreB1, scoreB2, scoreB3, scoreB4] },
      ],
      xaxis: { categories: ["Year 1", "Year 2", "Year 3", "Year 4"] },
      legend: { position: "right", offsetY: 40 },
      fill: { opacity: 1 },
    };
    var chart = new ApexCharts(
      document.querySelector("#s-col-stacked"),
      sColStacked
    );
    chart.render();
  }

  if ($("#bar").length > 0) {
    var optionsBar = {
      chart: {
        type: "bar",
        height: 350,
        width: "100%",
        stacked: false,
        toolbar: { show: false },
      },
      dataLabels: { enabled: false },
      plotOptions: { bar: { columnWidth: "55%", endingShape: "rounded" } },
      stroke: { show: true, width: 2, colors: ["transparent"] },
      series: [
        {
          name: "Boys",
          color: "#70C4CF",
          data: [420, 532, 516, 575, 519, 517, 454, 392, 262, 383, 446, 551],
        },
        {
          name: "Girls",
          color: "#3D5EE1",
          data: [336, 612, 344, 647, 345, 563, 256, 344, 323, 300, 455, 456],
        },
      ],
      labels: [
        2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020,
      ],
      xaxis: {
        labels: { show: false },
        axisBorder: { show: false },
        axisTicks: { show: false },
      },
      yaxis: {
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: { style: { colors: "#777" } },
      },
      title: { text: "", align: "left", style: { fontSize: "18px" } },
    };
    var chartBar = new ApexCharts(document.querySelector("#bar"), optionsBar);
    chartBar.render();
  }
});
