<?php

class DonasiController{
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $conn =  $this->db->connect();
        $parent = "Donasi";
        $position = "Home";

        $sql = "SELECT d.id_data_donasi, d.judul_donasi, d.deskripsi_donasi, d.target, d.gambar_donasi, d.batas_waktu_donasi, (SELECT SUM(p.price) FROM payments p WHERE d.id_data_donasi = p.id_donasi AND p.payment_status = 2 ) AS total_donasi FROM data_donasi d";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        return include "../view/donasi/index.php";
    }

    public function create(){
        $parent = "Donasi";
        $position = "Form Create";

        return include "../view/donasi/index.php";
    }

    public function save_create(){
        $conn =  $this->db->connect();

        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
        $path = __DIR__.'/../public/images/donasi/';

        $judul_donasi = $_POST['judul_donasi'];
        $deskripsi_donasi = $_POST['deskripsi_donasi'];
        $target = $_POST['target'];
        $batas_waktu_donasi = $_POST['batas_waktu_donasi'];
        $sql = "";

        $img = $_FILES['gambar_donasi']['name'];
        $tmp = $_FILES['gambar_donasi']['tmp_name'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $final_image = rand(1000,1000000).$img;

        $gambar_donasi = $final_image;
        $sql = $sql."INSERT INTO data_donasi (judul_donasi, deskripsi_donasi, target, batas_waktu_donasi, gambar_donasi) 
                    VALUES ('$judul_donasi', '$deskripsi_donasi', '$target', '$batas_waktu_donasi', '$gambar_donasi')";
        
        $result = mysqli_query($conn, $sql);
        
        if(in_array($ext, $valid_extensions)) { 
            $id = $conn->insert_id;;
            $path = __DIR__.'/../public/images/donasi/';

            if (!file_exists($path.$id)) {
                $path = $path.$id."/";
                mkdir($path);

                $path = $path.strtolower($final_image); 
                move_uploaded_file($tmp,$path);
            } 
        }

        
        if ($result) {
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Data Berhasil Ditambahkan",
                "icon" => "success",
                "ButtonColor" => "#66BB6A"
            ];
            return json_encode($msg);
        }

        $msg = [
            "title" => "Gagal !!",
            "type" => "error",
            "text" => "Data Gagal Ditambahkan",
            "icon" => "error",
            "ButtonColor" => "#EF5350"
        ];
        return json_encode($msg);
    }

    public function update($id){
        $parent = "Donasi";
        $position = "Form Update";
        $conn =  $this->db->connect();

        $sql = "SELECT * FROM data_donasi WHERE id_data_donasi = ".$id;
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        return include "../view/donasi/index.php";
    }

    public function save_update(){
        $conn =  $this->db->connect();

        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
        $path = __DIR__.'/../public/images/donasi/';

        $judul_donasi = $_POST['judul_donasi'];
        $deskripsi_donasi = $_POST['deskripsi_donasi'];
        $target = $_POST['target'];
        
        $batas_waktu_donasi = $_POST['batas_waktu_donasi'];
        $id = $_POST['id_data_donasi'];
        
        $sql = "UPDATE data_donasi SET judul_donasi='$judul_donasi', 
                deskripsi_donasi='$deskripsi_donasi', target='$target', 
                batas_waktu_donasi='$batas_waktu_donasi'";
        if ($_POST['gambar_name'] != '_') {
            if (!file_exists($path.$_POST['id_data_donasi'])) {
                $path = $path.$_POST['id_data_donasi'];
                mkdir($path);
            } 
            $path = __DIR__.'/../public/images/donasi/';
            $path = $path.$_POST['id_data_donasi'].'/';
            
            $img = $_FILES['gambar_donasi']['name'];
            $tmp = $_FILES['gambar_donasi']['tmp_name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            $final_image = rand(1000,1000000).$img;
            // check's valid format
            if(in_array($ext, $valid_extensions)) { 
                $path = $path.strtolower($final_image); 
                if(move_uploaded_file($tmp,$path)) {
                    $gambar_donasi = $final_image;
                    $sql = $sql.", gambar_donasi='$gambar_donasi' ";
                }
            }
        } 
        $sql = $sql."WHERE id_data_donasi='$id'";
        
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Update Data Berhasil",
                "icon" => "success",
                "ButtonColor" => "#66BB6A"
            ];
            return json_encode($msg);
        }

        $msg = [
            "title" => "Gagal !!",
            "type" => "error",
            "text" => "Update Data Gagal !!",
            "icon" => "error",
            "ButtonColor" => "#EF5350"
        ];
        return json_encode($msg);
    }

    public function delete($id){
        $conn = $this->db->connect();

        $sql = "DELETE d.*, p.* FROM data_donasi d LEFT JOIN payments p ON d.id_data_donasi = p.id_donasi WHERE d.id_data_donasi = $id";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo $sql;
        }
    }

    public function filters(){

    }
}