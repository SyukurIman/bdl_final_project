<?php

 class userController {

    private $db_user;
    public function __construct($db) {
        $this->db_user = $db;
    }

    function index(){
        $parent = "User Management";
        $position = "Home";

        $conn =  $this->db_user->connect();
        $sql = "SELECT * FROM users ";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        return include "../view/user/index.php";
    }

    public function data_user($sql){
        if($sql != "") {
            return $this->set_table_user($sql);
        }
        $sql = "SELECT u.id, u.name, u.email, u.is_admin, 
                (SELECT COUNT(p2.price) FROM payments p2 WHERE u.id = p2.id_user AND p2.payment_status = 2) as data_donasi, 
                (SELECT SUM(p2.price) FROM payments p2 WHERE u.id = p2.id_user AND p2.payment_status = 2) as nom_pay
                FROM users u" ;

        return $this->set_table_user($sql);
    }

    public function create(){
        $parent = "User Management";
        $position = "Form Create";

        return include "../view/user/index.php";
    }

    public function save_create(){
        $conn =  $this->db_user->connect();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $is_Admin = $_POST['is_admin'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (name, email, is_admin, password) 
                VALUES('$name', '$email', '$is_Admin', '$password')";
        try {
            mysqli_query($conn, $sql);
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Data Berhasil Ditambahkan",
                "icon" => "success",
                "ButtonColor" => "#66BB6A"
            ];
            return json_encode($msg);
        } catch (Exception $e) {
            $error = $e->getMessage();
            $msg = [
                "title" => "Gagal !!",
                "type" => "error",
                "text" => $error,
                "icon" => "error",
                "ButtonColor" => "#EF5350"
            ];
            return json_encode($msg);
        }

    }

    public function update($id){
        $parent = "User Management";
        $position = "Form Update";
        $conn =  $this->db_user->connect();

        $sql = "SELECT * FROM users WHERE id = ".$id;
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        return include "../view/user/index.php";
    }

    public function save_update(){
        $conn =  $this->db_user->connect();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $is_Admin = $_POST['is_admin'];
        $id = $_POST['id_user'];
        
        $sql = "UPDATE users SET name='$name', email='$email', is_admin='$is_Admin'";

        if (isset($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $sql = $sql.", password='$password' ";
        }
        $sql = $sql." WHERE id=".$id;

        try {
            mysqli_query($conn, $sql);
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Data Berhasil Di Upadte !!",
                "icon" => "success",
                "ButtonColor" => "#66BB6A"
            ];
            return json_encode($msg);
        } catch (Exception $e) {
            $error = $e->getMessage();
            $msg = [
                "title" => "Gagal !!",
                "type" => "error",
                "text" => $error,
                "icon" => "error",
                "ButtonColor" => "#EF5350"
            ];
            return json_encode($msg);
        }

    }

    public function delete($id){
        $conn = $this->db_user->connect();

        $sql = "DELETE u.*, p.* FROM users u LEFT JOIN payments p ON u.id = p.id_user WHERE u.id = $id";
        try {
            mysqli_query($conn, $sql);
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Data Berhasil Dihapus !!",
                "icon" => "success",
                "ButtonColor" => "#66BB6A"
            ];
            return json_encode($msg);
        }catch (Exception $e){
            $error = $e->getMessage();
            $msg = [
                "title" => "Gagal !!",
                "type" => "error",
                "text" => $error,
                "icon" => "error",
                "ButtonColor" => "#EF5350"
            ];
            return json_encode($msg);
        }

        
        $msg = [
            "title" => "Gagal !!",
            "type" => "error",
            "text" => "Data Gagal Dihapus !!",
            "icon" => "error",
            "ButtonColor" => "#EF5350"
        ];
        return json_encode($msg);
    }

    public function set_table_user($sql){
        $conn = $this->db_user->connect();

        // Function of set data in donasi table
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);
        $tgl = date('Y-m-d');

        $data_json = [];
        $j = 1;
        for ($i = 0; $i < count($data); $i++) {
            $btn_aksi = '<div class="text-center">
                            <div class="btn-group btn-group-solid mx-2">
                                <a href="/user/update/'.$data[$i][0].'" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a> &nbsp;
                                <button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus" data-id="'.$data[$i][0].'"><i class="icon-trash"></i></button>
                            </div>
                        </div>';
            $status_pengguna = ($data[$i][3] == 1) ? "Admin" : "Pengguna Biasa";
            $data_json[] = [
                'id' => $data[$i][0],
                'DT_RowIndex' => $j++,
                'action' => $btn_aksi,
                'name' => $data[$i][1],
                'email' => $data[$i][2],
                'status_pengguna' => $status_pengguna,
                'total_donasi' => $data[$i][4],
                'nominal_donasi' => 'RP. '.number_format($data[$i][5], 2) 
            ];
        }
        return json_encode(["draw"=>1, "recordsFiltered" => count($data),"recordsTotal" => count($data), "data" => $data_json, "start" => "6"]);
    }


}
