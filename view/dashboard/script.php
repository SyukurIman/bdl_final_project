<script>
var data = ( function () {
  var chart_bar = function () {
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
          {
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 15,
              font: {
                size: 14,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
              color: "#fff",
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false,
            },
          },
        },
      },
    });
  };

  var chart_line = function () {
    var ctx2 = document.getElementById("chart-line").getContext("2d");
    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
    gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
    gradientStroke1.addColorStop(0, "rgba(203,12,159,0)"); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
    gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
    gradientStroke2.addColorStop(0, "rgba(20,23,39,0)"); //purple colors

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
          {
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6,
          },
          {
            label: "Websites",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#3A416F",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,
            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
            maxBarThickness: 6,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              padding: 10,
              color: "#b2b9bf",
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              color: "#b2b9bf",
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
        },
      },
    });
  };

  var create = function(){
      $('#simpan').on('click', function(e) {
          e.preventDefault();
          swal.fire({
              title: 'Apakah Anda Yakin?',
              text: 'Menyimpan Data Ini',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#2196F3',
              confirmButtonText: 'Ya',
              cancelButtonText: 'Tidak'
          })
          .then((result) => {
              if (result.value) {
                  var formdata = $(this).serialize();
                  valid = true
                  var err = 0;
                  $('.help-block').hide();
                  $('.form-error').removeClass('form-error');
                  $('#form-data').find('input, textarea').each(function(){
                      if($(this).prop('required')){
                          if(err == 0){
                              if($(this).val() == ""){
                                  valid = false;
                                  real = this.name;
                                  title = $('label[for="' + this.name + '"]').html();
                                  type = '';
                                  if($(this).is("input")){
                                      type = 'diisi';
                                  }else{
                                      type = 'pilih';
                                  }
                                  err++;
                              }
                          }
                      }
                  })
                  if(!valid){
                      if(type == 'diisi'){
                          $("input[name="+real+"]").addClass('form-error');
                          $($("input[name="+real+"]").closest('div').find('.help-block')).html(title + 'belum ' + type);
                          $($("input[name="+real+"]").closest('div').find('.help-block')).show();
                      } else{
                          $("textarea[name="+real+"]").addClass('form-error');
                          $($("textarea[name="+real+"]").closest('div').find('.help-block')).html(title + 'belum ' + type);
                          $($("textarea[name="+real+"]").closest('div').find('.help-block')).show();
                      }
  
                      swal.fire({
                          text : title + 'belum ' + type,
                          type : "error",
                          confirmButtonColor: "#EF5350",
                      });
                  } else{
                      var formData = new FormData($('#form-data')[0]);
                      $.ajax({
                          url : "/setting/save/",
                          type : "POST",
                          data : formData,
                          processData: false,
                          contentType: false,
                          beforeSend: function(){
                              swal.fire({
                                  html: '<h5>Loading...</h5>',
                                  showConfirmButton: false
                              });
                          },
                          success: function(result){
                              if(result.type == 'success'){
                                  swal.fire({
                                      title: result.title,
                                      text : result.text,
                                      confirmButtonColor: result.ButtonColor,
                                      type : result.type,
                                  }).then((result) => {
                                      location.href = "";
                                  });
                              }else{
                                  swal.fire({
                                      title: result.title,
                                      text : result.text,
                                      confirmButtonColor: result.ButtonColor,
                                      type : result.type,
                                  });
                              }
                          }
                      });
                  }
              } else {
                  swal.fire({
                      text : 'Aksi Dibatalkan!',
                      type : "info",
                      confirmButtonColor: "#EF5350",
                  });
              }
          });
      });
  }

  var select_trigger = function(){
      $('#status_trigger').on('change', function(){
        let get_data = $(this).val()
        if (get_data == "on") {
          $('#start_time').prop('required',true);
          $('#end_time').prop('required',true);
        } else {
          $('#start_time').prop('required',false);
          $('#end_time').prop('required',false);
        }
      })
    }

  return {
    init: function () {
      <?php if($position == 'Home') { ?> 
        chart_bar();
        chart_line();
      <?php } ?>

      create()
      select_trigger();
    },
  };
})();

$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  data.init();
});

</script>