<?php

class Database_conect{
  public function connect(){
    if($koneksi = mysqli_connect("localhost", "root", "", "data_healyou")){
      return $koneksi;
    } else if (mysqli_connect_errno()){
      return "Konek database gagal: ".mysqli_connect_error();
    }
  }
}

