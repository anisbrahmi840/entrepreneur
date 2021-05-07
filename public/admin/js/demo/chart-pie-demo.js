// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var ev = document.getElementById("ev").value;
var env = document.getElementById("env").value;
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Valide", "Non Valide", "Social"],
    datasets: [{
      data: [ev, env],
      backgroundColor: ['#2c9faf', '#ED1C24', '#36b9cc'],
      hoverBackgroundColor: ['#2c9faf', '#ED1C24', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
