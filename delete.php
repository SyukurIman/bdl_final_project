<?php 

include "config_db.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "DELETE FROM employees WHERE employee_id = ".$id);

if($query){
  header('Location: index.php?msg=Hapus Berhasil');
} else {
  header('Location: index.php?msg=Hapus Gagal');
}

exit;