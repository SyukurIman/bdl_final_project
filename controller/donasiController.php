<?php

class DonasiController{
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $parent = "Donasi";
        $position = "Home";

        $conn =  $this->db->connect();

        $tgl = date('Y-m-d');
        $sql = "SELECT * FROM data_donasi WHERE batas_waktu_donasi >= '$tgl' ";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);

        return include "../view/donasi/index.php";
    }

    public function data_donasi($sql){
        if($sql != "") {
            return $this->set_table_donasi($sql);
        }
        $sql = "SELECT d.id_data_donasi, d.judul_donasi, d.deskripsi_donasi, d.target, d.gambar_donasi, d.batas_waktu_donasi, 
        (SELECT SUM(p.price) 
        FROM payments p 
        WHERE d.id_data_donasi = p.id_donasi AND p.payment_status = 2 ) AS total_donasi 
        FROM data_donasi d";
        return $this->set_table_donasi($sql);
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
        try {
            mysqli_query($conn, $sql);
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
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Data Berhasil Ditambahkan !!",
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
        
        try {
            mysqli_query($conn, $sql);
            $msg = [
                "title" => "Sukses",
                "type" => "success",
                "text" => "Update Data Berhasil",
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

        
    }

    public function delTree($dir){
        $files = array_diff(scandir($dir), array('.', '..')); 
        
        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file"); 
        }
        return rmdir($dir); 
    }

    public function delete($id){
        $conn = $this->db->connect();

        $sql = "DELETE d.*, p.* FROM data_donasi d LEFT JOIN payments p ON d.id_data_donasi = p.id_donasi WHERE d.id_data_donasi = $id";
        try {
            mysqli_query($conn, $sql);
            $dir = __DIR__.'/../public/images/donasi/'.$id.'/';
            $this->delTree($dir);
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

    public function filters($data){
        $sql = "SELECT d.id_data_donasi, d.judul_donasi, d.deskripsi_donasi, d.target, d.gambar_donasi, d.batas_waktu_donasi, (SELECT SUM(p.price) FROM payments p WHERE d.id_data_donasi = p.id_donasi AND p.payment_status = 2 ) AS total_donasi FROM data_donasi d";
        $data_min_nominal = $data['min_nominal'] != "" ? " d.target >= ".$data['min_nominal'] : '';
        $data_max_nominal = $data['max_nominal'] != "" ? " d.target <= ".$data['max_nominal'] : '';
        $sql_nominal = "";
        $data_min_tgl_donasi = $data['min_tgl_donasi'] != '' ? " d.batas_waktu_donasi >= '".$data['min_tgl_donasi']."'" : '';
        $data_max_tgl_donasi = $data['max_tgl_donasi'] != '' ? " d.batas_waktu_donasi <= '".$data['max_tgl_donasi']."'" : '';

        if ($data_min_nominal != "" && $data_max_nominal != "") {
            $sql_nominal = $data_min_nominal." AND ".$data_max_nominal;
        }

        if ($data != ''){
            $sql = $sql." WHERE ";
            if ($sql_nominal != "") {
                $sql = $sql.$sql_nominal;
            } else if ($data_min_nominal != '') {
                $sql = $sql.$data_min_nominal;
            } else if ($data_max_nominal != "") {
                $sql = $sql.$data_max_nominal;
            }

            if ($data_min_tgl_donasi != '' ) {
                if($sql_nominal != "" || $data_min_nominal != '' || $data_max_nominal != ""){
                    $sql = $sql.' AND '.$data_min_tgl_donasi;
                } else {
                    $sql = $sql.$data_min_tgl_donasi;
                }
                
            } 
            if ($data_max_tgl_donasi != '') {
                if($sql_nominal != "" || $data_min_nominal != '' || $data_max_nominal != "" || $data_min_tgl_donasi != '' ){
                    $sql = $sql.' AND '.$data_max_tgl_donasi;
                } else {
                    $sql = $sql.$data_max_tgl_donasi;
                }
            } 
    
            if ($data_max_tgl_donasi != '' && $data_min_tgl_donasi != '') {
                $check_mx_tgl = explode(' ', $data_max_tgl_donasi)[3];
                $check_min_tgl = explode(' ', $data_min_tgl_donasi)[3];
    
                // echo $check_min_tgl;
                if ($check_mx_tgl <= $check_min_tgl) {
                    $msg = [
                        'title' => 'Gagal',
                        'type' => 'error',
                        'text' => 'Data tanggal tidak tepat !!',
                        "icon" => "error",
                        "ButtonColor" => "#EF5350"
                    ];
                    return json_encode($msg);
                }
    
            }
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

    public function set_table_donasi($sql){
        $conn = $this->db->connect();

        // Function of set data in donasi table
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result);
        $tgl = date('Y-m-d');

        $data_json = [];
        $j = 1;
        for ($i = 0; $i < count($data); $i++) {
            $btn_aksi = '<div class="text-center">
                            <div class="btn-group btn-group-solid mx-2">
                                <a href="/donasi/update/'.$data[$i][0].'" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a> &nbsp;
                                <a href="/donasi/payment/'.$data[$i][0].'" class="btn btn-secondary btn-raised btn-xs" id="btn-pay" title="Pay"><i class="icon-diamond"></i> </a> &nbsp;
                                <button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus" data-id="'.$data[$i][0].'"><i class="icon-trash"></i></button>
                            </div>
                        </div>';
            $nama_donasi = '<div class="d-flex px-2 py-1">
                                <div>
                                <img
                                    src="/../images/donasi/'.$data[$i][0].'/'.$data[$i][4].'"
                                    class="avatar avatar-sm me-3"
                                    alt="xd"
                                />
                                </div>
                                <div
                                class="d-flex flex-column justify-content-center"
                                >
                                <h6 class="mb-0 text-sm">'.$data[$i][1].'</h6>
                                </div>
                            </div>';
            $tgl_batas_donasi = $tgl <= $data[$i][5] ? $data[$i][5]." (Aktif)" : $data[$i][5]." (Non Aktif) ";
            $deskripsi = str_word_count($data[$i][2]) >= 50  ? substr($data[$i][2], 0, 50)."...." : $data[$i][2];
            $data_json[] = [
                'id' => $data[$i][0],
                'DT_RowIndex' => $j++,
                'action' => $btn_aksi,
                'judul_donasi' => $nama_donasi,
                'batas_waktu_donasi' => $tgl_batas_donasi,
                'deskripsi_donasi' => $deskripsi,
                'target' => 'RP. '.number_format($data[$i][3], 2),
                'nominal_terkumpul' => 'RP. '.number_format($data[$i][6], 2) 
            ];
        }
        return json_encode(["draw"=>1, "recordsFiltered" => count($data),"recordsTotal" => count($data), "data" => $data_json, "start" => "6"]);
    }
}