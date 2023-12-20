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

    public function data_payment($sql){
        if($sql != "") {
            return $this->set_table_payment($sql);
        }
        $sql = "SELECT p.id, u.email, d.judul_donasi, p.created_at, p.price, p.payment_status
                FROM payments p
                LEFT JOIN data_donasi d ON p.id_donasi = d.id_data_donasi
                LEFT JOIN users u ON p.id_user = u.id
                ORDER BY p.created_at DESC;
                ";
        return $this->set_table_payment($sql);
    }

    public function create($id){
        $parent = "Donasi";
        $position = "Form Create";

        $conn =  $this->db_payment->connect();

        $sql = "SELECT d.*, 
                (SELECT SUM(p.price) FROM payments p WHERE d.id_data_donasi = p.id_donasi AND p.payment_status = 2 ) AS total_donasi
                FROM data_donasi d WHERE d.id_data_donasi=".$id;
        $result = mysqli_query($conn, $sql);
        $data_donasi = mysqli_fetch_all($result);

        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
        $data_user = mysqli_fetch_all($result);

        return include "../view/payment/index.php";
    }

    public function save_create(){
        $conn =  $this->db_payment->connect();

        $price = $_POST['price'];
        $nama_donasi = isset($_POST['nama_donasi']) && $_POST['nama_donasi'] != "" ? $_POST['nama_donasi'] : "Orang Baik";
        $id_user = $_POST['user'];
        $dukungan = isset($_POST['dukungan']) ? $_POST['dukungan'] : "";
        $payment_status = 1;
        $id_donasi = $_POST['id_data_donasi'];
        $currentDateTime = date('Y-m-d H:i:s');

        $sql = "INSERT INTO payments (id_donasi, price, payment_status, id_user, dukungan, nama_donatur,created_at)
                VALUES ('$id_donasi', '$price', '$payment_status', '$id_user', '$dukungan', '$nama_donasi','$currentDateTime')";
        
        $result = mysqli_query($conn, $sql);
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
        $parent = "Payment";
        $position = "Form Update";

        $conn =  $this->db_payment->connect();

        $sql = "SELECT p.id, d.judul_donasi, p.nama_donatur, 
                (SELECT u.email FROM users u WHERE p.id_user = u.id) 
                as email, p.payment_status, p.price, p.dukungan
                FROM payments p 
                LEFT JOIN data_donasi d
                ON p.id_donasi = d.id_data_donasi 
                WHERE id = ".$id;
        $result = mysqli_query($conn, $sql);
        $data_payment = mysqli_fetch_all($result);
        return include "../view/payment/index.php";
    }

    public function save_update(){
        $conn =  $this->db_payment->connect();

        $nama_donasi = isset($_POST['nama_donasi']) && $_POST['nama_donasi'] != '' ? $_POST['nama_donasi'] : "Orang Baik";
        $dukungan = isset($_POST['dukungan']) ? $_POST['dukungan'] : "";
        $payment_status = $_POST['payment_status'];
        $id = $_POST['id_payment'];

        $sql = "UPDATE payments SET nama_donatur='$nama_donasi', 
                dukungan='$dukungan', payment_status='$payment_status'
                WHERE id=".$id;
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

    public function filters($data){
        $sql = "SELECT p.id, u.email, d.judul_donasi, p.created_at, p.price, p.payment_status
        FROM payments p
        LEFT JOIN data_donasi d ON p.id_donasi = d.id_data_donasi
        LEFT JOIN users u ON p.id_user = u.id";

        $conditions = array();
        if (!empty($data['payment_status'])) {
            $conditions[] = "p.payment_status = '" . $data['payment_status'] . "'";
        }
        
        if (!empty($data['email_user'])) {
            $conditions[] = "u.email = '" . $data['email_user'] . "'";
        }

        if (!empty($data['min_nominal'])) {
            $conditions[] = "p.price > " . $data['min_nominal'];
        }

        if (!empty($data['max_nominal'])) {
            $conditions[] = "p.price < " . $data['max_nominal'];
        }
        
        if (!empty($data['min_tgl_payment']) && !empty($data['max_tgl_payment'])) {
            // Jika keduanya terisi, hapus kondisi tanggal pertama
            $indexMin = array_search("p.created_at > '" . $data['min_tgl_payment'] . "'", $conditions);
            $indexMax = array_search("p.created_at < '" . $data['max_tgl_payment'] . "'", $conditions);

            if ($indexMin !== false) {
                unset($conditions[$indexMin]);
            }

            if ($indexMax !== false) {
                unset($conditions[$indexMax]);
            }

            if($data['max_tgl_payment'] < $data['min_tgl_payment']){
                $msg = [
                    "title" => "Gagal !!",
                    "type" => "error",
                    "text" => "Tanggal input tidak tepat !!",
                    "icon" => "error",
                    "ButtonColor" => "#EF5350"
                ];
                return json_encode($msg);
            }

            $conditions[] = "p.created_at BETWEEN '" . $data['min_tgl_payment'] . "' AND '" . $data['max_tgl_payment'] . "'";
        } elseif (!empty($data['min_tgl_payment'])) {
            // Jika hanya tanggal pertama terisi, hapus kondisi tanggal kedua
            $indexMax = array_search("p.created_at < '" . $data['max_tgl_payment'] . "'", $conditions);

            if ($indexMax !== false) {
                unset($conditions[$indexMax]);
            }

            $conditions[] = "p.created_at > '" . $data['min_tgl_payment'] . "'";
        } elseif (!empty($data['max_tgl_payment'])) {
            // Jika hanya tanggal kedua terisi, hapus kondisi tanggal pertama
            $indexMin = array_search("p.created_at > '" . $data['min_tgl_payment'] . "'", $conditions);

            if ($indexMin !== false) {
                unset($conditions[$indexMin]);
            }

            $conditions[] = "p.created_at < '" . $data['max_tgl_payment'] . "'";
        }


        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $msg = [
            'title' => 'Sukses',
            'type' => 'success',
            'text' => 'Data Berhasil di Perbarui',
            'icon' => 'success',
            'ButtonColor' => '#66BB6A',
            'sql' => $sql
        ];
        return json_encode($msg);
    }

    public function topDonasi($data){
        $tanggal_awal = $data['tanggal_awal'] != "" ? "'".$data['tanggal_awal'] ."'": '' ;
        $tanggal_akhir = $data['tanggal_akhir'] != "" ? "'".$data['tanggal_akhir'] ."'": '';

        $sql = "SELECT p.id, u.email, d.judul_donasi, p.created_at, p.price, p.payment_status
                FROM payments p
                LEFT JOIN data_donasi d ON p.id_donasi = d.id_data_donasi
                LEFT JOIN users u ON p.id_user = u.id
                WHERE p.created_at BETWEEN ".$tanggal_awal." AND ".$tanggal_akhir."
                    AND p.payment_status = 2
                    AND p.price >= (
                        SELECT AVG(price)
                        FROM payments
                        WHERE created_at BETWEEN ".$tanggal_awal." AND ".$tanggal_akhir."
                            AND payment_status = 2
                    )
                ORDER BY p.price DESC;";
        $msg = [
            'title' => 'Sukses',
            'type' => 'success',
            'text' => 'Data Berhasil di Perbarui',
            'icon' => 'success',
            'ButtonColor' => '#66BB6A',
            'sql' => $sql
        ];
        return json_encode($msg);
    }

    public function set_table_payment($sql){
        $conn = $this->db_payment->connect();

        // Function of set data in donasi table
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        $data_json = [];
        $j = 1;
        for ($i = 0; $i < count($data); $i++) { 
            $btn_aksi = '<div class="text-center">
                            <div class="btn-group btn-group-solid mx-2">
                                <a href="/payment/update/'.$data[$i][0].'" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a>
                            </div>
                        </div>';

            $data_json[] = [
                'id' => $data[$i][0],
                'DT_RowIndex' => $j++,
                'action' => $btn_aksi,
                'email_user' => $data[$i][1],
                'nama_donasi' => $data[$i][2],
                'tgl_transaksi' => $data[$i][3],
                'nominal' => "Rp. ".number_format($data[$i][4], 2),
                'status_pembayaran' => $data[$i][5] == 1 ? 'Menunggu Pembayaran' : ($data[$i][5] == 2 ? 'Pembayaran Berhasil' : 'Pembayaran Expired')
            ];
        } 
        return json_encode(["draw"=>1, "recordsFiltered" => count($data),"recordsTotal" => count($data), "data" => $data_json, "start" => "0"]);
    }
}