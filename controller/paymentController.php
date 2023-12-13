<?php

class PaymentController{
    private $db_payment;
    public function __construct($db) {
        $this->db_payment = $db;
    }

    public function index() {
        $conn =  $this->db_payment->connect();
        $parent = "Payment";
        $position = "Home";

        $sql = "SELECT * FROM payment";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        return include "../view/payment/index.php";
    }

    public function update_view(){
        $parent = "Payment";
        $position = "Form Update";

        return include "../view/payment/index.php";
    }
}