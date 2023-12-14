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

        $sql = "SELECT * FROM data_donasi";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        return include "../view/donasi/index.php";
    }

    public function create(){
        $parent = "Donasi";
        $position = "Form Create";

        return include "../view/donasi/index.php";
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

    public function save_update($data){
        var_dump($data);
    }
}