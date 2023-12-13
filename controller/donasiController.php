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
}