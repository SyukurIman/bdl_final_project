<?php

class Database_conect{
  public function connect(){
    if($koneksi = mysqli_connect("localhost", "root", "", "data_healyou")){
      $createTriggerSQL = "
          CREATE TRIGGER secure_emp BEFORE INSERT ON payments
          FOR EACH ROW
          BEGIN
              DECLARE day VARCHAR(3);
              DECLARE time VARCHAR(5);
              
              SET day = UPPER(DATE_FORMAT(NOW(), '%a'));
              SET time = DATE_FORMAT(NOW(), '%H:%i');
              
              IF (day IN ('WED', 'THU')) OR (time NOT BETWEEN '08:00' AND '18:00') THEN
                  SIGNAL SQLSTATE '45000'
                  SET MESSAGE_TEXT = 'Penyisipan data pada tabel EMPLOYEES hanya diperbolehkan selama jam kerja';
              END IF;
          END;
      ";
      return $koneksi;
    } else if (mysqli_connect_errno()){
      return "Konek database gagal: ".mysqli_connect_error();
    }
  }
}

