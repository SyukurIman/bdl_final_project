<script>
var data = ( function () {

    var table = function(){
        $('#table').DataTable();
    }

    var hapus = function() {
        $('#table').on('click', '#btn-hapus', function() {
            var baris = $(this).parents('tr')[0];
            var table = $('#table').DataTable();
            var data = table.row(baris).data();

            swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Menghapus Data Ini',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2196F3',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value) {
                        var fd = new FormData();
                        fd.append('_token', '{{ csrf_token() }}');
                        fd.append('id_data_donasi', data.id_data_donasi);

                        $.ajax({
                            url: "/donasi/delete",
                            type: "POST",
                            data: fd,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                swal.fire({
                                    html: '<h5>Loading...</h5>',
                                    showConfirmButton: false
                                });
                            },
                            success: function(result) {
                                swal.fire({
                                    title: result.title,
                                    text: result.text,
                                    confirmButtonColor: result.ButtonColor,
                                    type: result.type,
                                });

                                if (result.type == 'success') {
                                    swal.fire({
                                        title: result.title,
                                        text: result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type: result.type,
                                    }).then((result) => {
                                        $('#table').DataTable().ajax.reload();
                                    });
                                } else {
                                    swal.fire({
                                        title: result.title,
                                        text: result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type: result.type,
                                    });
                                }
                            }
                        });
                    } else {
                        swal.fire({
                            text: 'Aksi Dibatalkan!',
                            type: "info",
                            confirmButtonColor: "#EF5350",
                        });
                    }
                });
        });
    }

    var create = function(){
        $('#simpan').click( function(e) {
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
                            url : "<?= $route_name ?> ",
                            type : "POST",
                            data : JSON.stringify(Object.fromEntries(formData)),
                            processData: false,
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
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


   
    return {
        init: function () {
            <?php if($position == 'Home') { ?> 
                table();
                hapus();
            <?php } ?>

            create();
        },
    };
})()

$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  data.init();
});

</script>