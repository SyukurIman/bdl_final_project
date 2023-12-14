<script>
var data = ( function () {
    var table = function(){
        $('#table').DataTable();
    }
   
    return {
        init: function () {
            <?php if($position == 'Home') { ?> 
                table();
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