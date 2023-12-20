<script>
var data = ( function () {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = String(today.getFullYear());
    var time = today.getHours() + "." + today.getMinutes();
    today = 'Result_Donasi_'+mm + '-' + dd + '-' + yyyy+"_"+time;

    console.log(today)
    
    var table = function(){
        var t = $('#table').DataTable({
            processing: true,
            pageLength: 5,
            searching: true,
            bLengthChange: true,
            lengthMenu: [ [5, 25, 50, -1], [5, 25, 50, "Semua"] ],
            destroy : true,
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excel',
                title: today,
                text: '<i class="fa fa-file-excel-o"></i> Cetak',
                titleAttr: 'Cetak',
                exportOptions: {
                    columns: '0, 2, 3, 4, 5, 6',
                    modifier: {
                        page: 'current'
                    }
                }
            }],
            'ajax': {
                "url": "/donasi/get_data/",
                "method": "POST",
                "data": function(d){
                    d.sql = $("#sql").val()
                },
                "complete": function () {
                    $('.buttons-excel').hide();
                    swal.close();
                    console.log($('#sql').val())
                    $('#sql').val(" ");
                    console.log("Sql_t"+$('#sql').val())
                }
            },
            'columns': [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                { data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false },
                { data: 'judul_donasi', name: 'judul_donasi', class: 'text-left' },
                { data: 'batas_waktu_donasi', name: 'batas_waktu_donasi', class: 'text-left' },
                { data: 'deskripsi_donasi', name: 'deskripsi_donasi', class: 'text-left' },
                { data: 'target', name: 'target', class: 'text-left' },
                { data: 'nominal_terkumpul', name: 'nominal_terkumpul', class: 'text-left' },
                        
            ],
            "order": [],
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
        cetak(t)
    }

    var cetak = function(t){
        $("#download_btn").on("click", function() {
            t.button('.buttons-excel').trigger();
        });
    }

    var hapus = function() {
        $('#table').on('click', '#btn-hapus', function() {
            var data_id = $(this).data("id")

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
                        $.ajax({
                            url: "/donasi/delete/",
                            type: "POST",
                            data: JSON.stringify(data_id),
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
                            url : "<?= $route_name ?> ",
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

    var click_filter = function(){
        $('#filter_btn').on('click', function(){
            var display =  $(".filter").css("display");
            if (display == "none") {
                $(".filter").attr("style", "display:block");
            } else {
                $(".filter").attr("style", "display:none");
            }
            
        })
    }

    var filter = function(){
        // check
        $(document).on('change', '#form_filter', function(){
            var data_new = {
                'min_nominal' : $('#min_nominal').val(),
                'max_nominal' : $('#max_nominal').val(),
                'min_tgl_donasi' : $('#min_tgl_donasi').val(),
                'max_tgl_donasi' : $('#max_tgl_donasi').val()
            }

            $.ajax({
                url : "/donasi/filter/",
                type : "POST",
                data : JSON.stringify(data_new),
                processData: false,
                contentType: "application/json; charset=utf-8",
                beforeSend: function(){
                    swal.fire({
                        html: '<h5>Loading...</h5>',
                        showConfirmButton: false
                    });
                },
                success: function(result_ajax){
                    if(result_ajax.type == 'success'){
                        swal.fire({
                            title: result_ajax.title,
                            text : result_ajax.text,
                            confirmButtonColor: result_ajax.ButtonColor,
                            type : result_ajax.type,
                        }).then((result) => {
                            $('#sql').val(result_ajax.sql);
                            // window.data_sql = { "sql" : result_ajax.sql};
                            console.log($('#sql').val())
                            $('#table').DataTable().ajax.reload();
                        });
                    }else{
                        swal.fire({
                            title: result_ajax.title,
                            text : result_ajax.text,
                            confirmButtonColor: result_ajax.ButtonColor,
                            type : result_ajax.type,
                        });
                    }
                }
            });

            console.log(JSON.stringify(data_new) )
        })
    }


   
    return {
        init: function () {
            <?php if($position == 'Home') { ?> 
                table();
                hapus();
                click_filter();
                filter();
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