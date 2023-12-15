<script>
var data = ( function () {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = String(today.getFullYear());
    var time = today.getHours() + "." + today.getMinutes();
    today = 'Result_Payment_'+mm + '-' + dd + '-' + yyyy+"_"+time;

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
                "url": "/payment/get_data/",
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
                { data: 'email_user', name: 'email_user', class: 'text-left' },
                { data: 'nama_donasi', name: 'nama_donasi', class: 'text-left' },
                { data: 'tgl_transaksi', name: 'tgl_transaksi', class: 'text-left' },
                { data: 'nominal', name: 'nominal', class: 'text-left' },
                { data: 'status_pembayaran', name: 'status_pembayaran', class: 'text-left' },
                        
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
                url : "/payment/filter/",
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
                            title: result.title,
                            text : result.text,
                            confirmButtonColor: result.ButtonColor,
                            type : result.type,
                        });
                    }
                }
            });

            console.log(JSON.stringify(data_new) )
        })
    }
    var topDonasi = function(){
        // check
        $(document).on('click', '#submit_top_donasi', function(){
            var data_new = {
                'tanggal_awal' : $('#tanggal_awal').val(),
                'tanggal_akhir' : $('#tanggal_akhir').val(),
            }

            $.ajax({
                url : "/payment/top_donasi/",
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
                            $('#top_donasi').modal('hide');
                            $('#sql').val(result_ajax.sql);
                           
                            // window.data_sql = { "sql" : result_ajax.sql};
                            console.log($('#sql').val());
                            $('#table').DataTable().ajax.reload();
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

            console.log(JSON.stringify(data_new) )
        })
    }

    return {
        init: function () {
            <?php if($position == 'Home') { ?> 
              table();
              click_filter();
              filter();
              topDonasi();
            <?php } ?>
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