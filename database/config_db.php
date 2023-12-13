<?php

$koneksi = mysqli_connect("localhost", "root", "", "data_healyou");

if (mysqli_connect_errno()){
  echo "Konek database gagal: ".mysqli_connect_error();
}