<?php

class AdminController{
    private $db_dashboard;
    public function __construct($db) {
        $this->db_dashboard = $db;
    }

    function index(){
        $parent = "Dashboard";
        $position = "Home";

        $conn =  $this->db_dashboard->connect();

        $sql = 'SELECT * FROM users';
        $result = mysqli_query($conn, $sql);
        $data_user = mysqli_fetch_all($result);

        $sql = 'SELECT * FROM payments p ORDER BY p.created_at DESC';
        $result = mysqli_query($conn, $sql);
        $data_payment = mysqli_fetch_all($result);

        $tgl_now = date('Y-m-d');
        $tgl_start = date('Y-m-d', strtotime('-1 days', strtotime($tgl_now)));
        $sql = "SELECT SUM(p.price) FROM payments p WHERE p.payment_status = 2 AND p.created_at >= $tgl_start ";
        $result = mysqli_query($conn, $sql);
        $sum_payment = mysqli_fetch_all($result);

        $sql = "SELECT d.id_data_donasi, d.judul_donasi, 
                d.deskripsi_donasi, d.target, d.gambar_donasi, d.batas_waktu_donasi, 
                (SELECT SUM(p.price) 
                FROM payments p 
                WHERE d.id_data_donasi = p.id_donasi AND p.payment_status = 2 ) AS total_donasi,
                (SELECT COUNT(p.price) 
                FROM payments p 
                WHERE d.id_data_donasi = p.id_donasi AND p.payment_status = 2 ) AS total_USER 
                FROM data_donasi d ORDER BY d.created_at DESC";
        $result = mysqli_query($conn, $sql);
        $data_donasi = mysqli_fetch_all($result);

        return include "../view/dashboard/index.php";
    }

    public function setting() {
        $parent = "Dashboard";
        $position = "Setting";

        return include "../view/dashboard/index.php";
    }

    public function save_create(){
        $conn =  $this->db_dashboard->connect();

        $status_trigger = $_POST['status_trigger'];
        

        if ($status_trigger == "off") {
            $sql = 'DROP TRIGGER IF EXISTS check_time_update';
            $result = mysqli_query($conn, $sql);

            $sql = 'DROP TRIGGER IF EXISTS check_time_insert';
            $result = mysqli_multi_query($conn, $sql);

            $sql = 'DROP TRIGGER IF EXISTS check_time_delete';
            $result = mysqli_multi_query($conn, $sql);
        } else {
            $start_time = "'".$_POST['start_time'].":00'";
            $end_time = "'".$_POST['end_time'].":00'";

            $sql = 'DROP TRIGGER IF EXISTS check_time_update';
            $result = mysqli_query($conn, $sql);

            $sql = 'DROP TRIGGER IF EXISTS check_time_insert';
            $result = mysqli_multi_query($conn, $sql);

            $sql = 'DROP TRIGGER IF EXISTS check_time_delete';
            $result = mysqli_multi_query($conn, $sql);

            $sql_NEW = file_get_contents(__DIR__."/../src/trigger.sql");
            $sql_NEW = str_replace("?<", $start_time, $sql_NEW);
            $sql_NEW = str_replace("?>", $end_time, $sql_NEW);
            // echo $sql_NEW;
            $result = mysqli_multi_query($conn, $sql_NEW);
        }

        if ($result) {
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Setting Berhasil Diubah",
                "icon" => "success",
                "ButtonColor" => "#66BB6A"
            ];
            return json_encode($msg);
        }

        $msg = [
            "title" => "Gagal !!",
            "type" => "error",
            "text" => "Setting Gagal Diubah",
            "icon" => "error",
            "ButtonColor" => "#EF5350"
        ];
    }
}