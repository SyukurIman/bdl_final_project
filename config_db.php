<?php

$koneksi = mysqli_connect("localhost", "root", "", "basis_data_l");

if (mysqli_connect_errno()){
  echo "Konek database gagal: ".mysqli_connect_error();
}