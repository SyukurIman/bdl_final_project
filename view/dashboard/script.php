<script>
var data = ( function () {

  var table = function(){
    var t = $('#table').DataTable({
        processing: true,
        pageLength: 5,
        searching: false,
        bLengthChange: false,
        lengthMenu: [ [5, 25, 50, -1], [5, 25, 50, "Semua"] ],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ],
        "language": {
            "lengthMenu": "Menampilkan _MENU_ data",
            "search": "Cari:",
            "zeroRecords": "Data tidak ditemukan",
            "paginate": {
                "first":      "Pertama",
                "last":       "Terakhir",
                "next":       "Selanjutnya",
                "previous":   "Sebelumnya"
            },
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Data kosong",
            "infoFiltered": "(Difilter dari _MAX_ total data)"
        }
    });

    <?php if (isset($data_donasi) && count($data_donasi) == 0) { ?>
      $('#data_donasi').hide();
    <?php } ?>
  }

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
        table();
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