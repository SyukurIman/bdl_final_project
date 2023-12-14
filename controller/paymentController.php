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

        $sql = "SELECT p.id, u.email, d.judul_donasi, p.created_at, p.price, p.payment_status
        FROM payments p
        LEFT JOIN data_donasi d ON p.id_donasi = d.id_data_donasi
        LEFT JOIN users u ON p.id_user = u.id
        ORDER BY p.created_at DESC;
        ";
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